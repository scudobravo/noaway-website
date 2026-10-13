<?php
/**
 * Mobile "email yourself the download link" capture — REST + storage + wp_mail.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Max submissions per IP per window. */
if ( ! defined( 'NOAWAY_EMAIL_LINK_RATE_LIMIT' ) ) {
	define( 'NOAWAY_EMAIL_LINK_RATE_LIMIT', 3 );
}
/** Rate-limit window in seconds. */
if ( ! defined( 'NOAWAY_EMAIL_LINK_RATE_WINDOW' ) ) {
	define( 'NOAWAY_EMAIL_LINK_RATE_WINDOW', HOUR_IN_SECONDS );
}

/**
 * Absolute downloads URL for the emailed link.
 */
function noaway_email_link_downloads_url() {
	$url = 'https://noaway.app/downloads/';
	if ( function_exists( 'noaway_downloads_page_url' ) ) {
		$dynamic = noaway_downloads_page_url();
		if ( is_string( $dynamic ) && $dynamic !== '' ) {
			$url = $dynamic;
		}
	}
	if ( function_exists( 'noaway_seo_canonical_url' ) ) {
		$url = noaway_seo_canonical_url( $url );
	}
	return $url;
}

/**
 * Downloads URL used inside the email, tagged so buy clicks from the link can be attributed.
 */
function noaway_email_link_mail_url() {
	return add_query_arg( 'ref', 'email-link', noaway_email_link_downloads_url() );
}

/**
 * Whether the current request should load the mobile email-link UI.
 */
function noaway_email_link_should_load() {
	if ( is_admin() ) {
		return false;
	}
	$load = is_front_page();
	$template = function_exists( 'get_page_template_slug' ) ? get_page_template_slug() : '';
	$landing_templates = array(
		'page-keep-teams-active.php',
		'page-keep-teams-active-de.php',
		'page-keep-teams-active-es.php',
		'page-keep-teams-active-pt-br.php',
		'page-keep-teams-active-fr.php',
		'page-teams-away-status.php',
		'page-keep-slack-active.php',
		'page-keep-slack-active-de.php',
		'page-keep-slack-active-es.php',
		'page-keep-slack-active-pt-br.php',
		'page-keep-slack-active-fr.php',
		'page-prevent-computer-sleep.php',
		'page-is-noaway-safe.php',
		'page-compare.php',
		'page-features.php',
		'page-how-it-works.php',
		'page-downloads.php',
		'page-download.php',
	);
	if ( $template && in_array( $template, $landing_templates, true ) ) {
		$load = true;
	}
	if ( function_exists( 'noaway_i18n_landing_from_request' ) && noaway_i18n_landing_from_request() ) {
		$load = true;
	}
	return (bool) apply_filters( 'noaway_email_link_should_load', $load );
}

/**
 * Create / upgrade storage table.
 */
function noaway_email_link_maybe_install_table() {
	global $wpdb;
	$table   = $wpdb->prefix . 'noaway_email_links';
	$version = '1.0';
	if ( get_option( 'noaway_email_links_db_version' ) === $version ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$charset = $wpdb->get_charset_collate();
	$sql     = "CREATE TABLE {$table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		email varchar(190) NOT NULL,
		marketing_opt_in tinyint(1) NOT NULL DEFAULT 0,
		ip_hash char(64) NOT NULL DEFAULT '',
		page_url text NULL,
		user_agent varchar(255) NOT NULL DEFAULT '',
		created_at datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY email (email),
		KEY created_at (created_at),
		KEY ip_hash (ip_hash)
	) {$charset};";
	dbDelta( $sql );
	update_option( 'noaway_email_links_db_version', $version, false );
}
add_action( 'after_setup_theme', 'noaway_email_link_maybe_install_table' );

/**
 * Client IP (best-effort; hashed before storage).
 */
function noaway_email_link_client_ip() {
	$ip = '';
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && is_string( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
		$ip = wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) && is_string( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = wp_unslash( $_SERVER['REMOTE_ADDR'] );
	}
	$ip = is_string( $ip ) ? trim( $ip ) : '';
	if ( $ip === '' || ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
		return '0.0.0.0';
	}
	return $ip;
}

/**
 * One-way hash of IP + site salt (no raw IP stored).
 */
function noaway_email_link_ip_hash( $ip ) {
	$salt = wp_salt( 'nonce' );
	return hash( 'sha256', $ip . '|' . $salt );
}

/**
 * Rate-limit check; returns WP_Error when exceeded.
 *
 * @param string $ip_hash Hashed IP.
 * @return true|WP_Error
 */
function noaway_email_link_check_rate_limit( $ip_hash ) {
	$key   = 'noaway_el_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	if ( $count >= (int) NOAWAY_EMAIL_LINK_RATE_LIMIT ) {
		return new WP_Error(
			'rate_limited',
			__( 'Too many requests. Please try again later.', 'noaway' ),
			array( 'status' => 429 )
		);
	}
	return true;
}

/**
 * Increment rate-limit counter after a successful accept (including honeypot silent accept).
 *
 * @param string $ip_hash Hashed IP.
 */
function noaway_email_link_bump_rate_limit( $ip_hash ) {
	$key   = 'noaway_el_' . substr( $ip_hash, 0, 32 );
	$count = (int) get_transient( $key );
	set_transient( $key, $count + 1, (int) NOAWAY_EMAIL_LINK_RATE_WINDOW );
}

/**
 * Persist a submission.
 *
 * @param string $email Email.
 * @param bool   $marketing Marketing opt-in.
 * @param string $ip_hash IP hash.
 * @param string $page_url Source page.
 * @param string $ua User agent.
 * @return int|false Insert id or false.
 */
function noaway_email_link_store( $email, $marketing, $ip_hash, $page_url, $ua ) {
	global $wpdb;
	$table = $wpdb->prefix . 'noaway_email_links';
	$ok    = $wpdb->insert(
		$table,
		array(
			'email'            => $email,
			'marketing_opt_in' => $marketing ? 1 : 0,
			'ip_hash'          => $ip_hash,
			'page_url'         => $page_url,
			'user_agent'       => $ua,
			'created_at'       => current_time( 'mysql', true ),
		),
		array( '%s', '%d', '%s', '%s', '%s', '%s' )
	);
	return $ok ? (int) $wpdb->insert_id : false;
}

/**
 * Send the downloads link email.
 *
 * @param string $email To address.
 * @return bool
 */
function noaway_email_link_send_mail( $email ) {
	$downloads = noaway_email_link_mail_url();
	$subject   = __( 'Your NoAway download link', 'noaway' );
	$body      = sprintf(
		/* translators: %s: downloads URL */
		__( "Hi,\n\nHere is the NoAway download page to open on your computer:\n\n%s\n\nNoAway works on Mac and Windows. Buy once, then install on your desktop.\n\n— The NoAway team\n", 'noaway' ),
		$downloads
	);
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	$from    = apply_filters( 'noaway_email_link_from', '' );
	if ( is_string( $from ) && is_email( $from ) ) {
		$headers[] = 'From: NoAway <' . $from . '>';
	}
	return (bool) wp_mail( $email, $subject, $body, $headers );
}

/**
 * Register REST route.
 */
function noaway_email_link_register_rest() {
	register_rest_route(
		'noaway/v1',
		'/email-download-link',
		array(
			'methods'             => 'POST',
			'callback'            => 'noaway_email_link_rest_handler',
			'permission_callback' => '__return_true',
			'args'                => array(
				'email' => array(
					'required'          => true,
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_email',
				),
				'marketing_opt_in' => array(
					'required' => false,
					'type'     => 'boolean',
					'default'  => false,
				),
				'website' => array(
					// Honeypot — bots fill this; humans leave empty.
					'required'          => false,
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => '',
				),
				'page_url' => array(
					'required'          => false,
					'type'              => 'string',
					'sanitize_callback' => 'esc_url_raw',
					'default'           => '',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'noaway_email_link_register_rest' );

/**
 * REST handler.
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function noaway_email_link_rest_handler( WP_REST_Request $request ) {
	$ip      = noaway_email_link_client_ip();
	$ip_hash = noaway_email_link_ip_hash( $ip );

	$rate = noaway_email_link_check_rate_limit( $ip_hash );
	if ( is_wp_error( $rate ) ) {
		return $rate;
	}

	// Always bump after we accept the request past rate check (including honeypot).
	$honeypot = (string) $request->get_param( 'website' );
	if ( $honeypot !== '' ) {
		noaway_email_link_bump_rate_limit( $ip_hash );
		// Silent success — do not tip off bots.
		return rest_ensure_response(
			array(
				'ok'      => true,
				'message' => __( 'Check your inbox for the download link.', 'noaway' ),
			)
		);
	}

	$email = sanitize_email( (string) $request->get_param( 'email' ) );
	if ( $email === '' || ! is_email( $email ) ) {
		return new WP_Error(
			'invalid_email',
			__( 'Please enter a valid email address.', 'noaway' ),
			array( 'status' => 400 )
		);
	}

	$marketing = (bool) $request->get_param( 'marketing_opt_in' );
	$page_url  = (string) $request->get_param( 'page_url' );
	$ua_raw    = isset( $_SERVER['HTTP_USER_AGENT'] ) && is_string( $_SERVER['HTTP_USER_AGENT'] )
		? wp_unslash( $_SERVER['HTTP_USER_AGENT'] )
		: '';
	$ua        = substr( sanitize_text_field( $ua_raw ), 0, 255 );

	noaway_email_link_store( $email, $marketing, $ip_hash, $page_url, $ua );
	noaway_email_link_bump_rate_limit( $ip_hash );

	$sent = noaway_email_link_send_mail( $email );
	if ( ! $sent ) {
		return new WP_Error(
			'mail_failed',
			__( 'We could not send the email. Please try again or open the downloads page on your computer.', 'noaway' ),
			array( 'status' => 500 )
		);
	}

	/**
	 * Fires after a successful email-link send (marketing flag included).
	 *
	 * @param string $email     Email.
	 * @param bool   $marketing Opt-in for occasional product emails.
	 * @param string $page_url  Source URL.
	 */
	do_action( 'noaway_email_link_sent', $email, $marketing, $page_url );

	return rest_ensure_response(
		array(
			'ok'      => true,
			'message' => __( 'Check your inbox for the download link.', 'noaway' ),
		)
	);
}

/**
 * Enqueue assets on landing + home.
 */
function noaway_email_link_enqueue_assets() {
	if ( ! noaway_email_link_should_load() ) {
		return;
	}
	$css_rel = '/assets/css/noaway-email-link.css';
	$js_rel  = '/assets/js/noaway-email-link.js';
	$css_abs = get_template_directory() . $css_rel;
	$js_abs  = get_template_directory() . $js_rel;
	$css_ver = file_exists( $css_abs ) ? (string) filemtime( $css_abs ) : '1.0.0';
	$js_ver  = file_exists( $js_abs ) ? (string) filemtime( $js_abs ) : '1.0.0';

	wp_enqueue_style(
		'noaway-email-link',
		get_template_directory_uri() . $css_rel,
		array(),
		$css_ver
	);
	wp_enqueue_script(
		'noaway-email-link',
		get_template_directory_uri() . $js_rel,
		array(),
		$js_ver,
		true
	);
	wp_localize_script(
		'noaway-email-link',
		'NoAwayEmailLink',
		array(
			'restUrl'     => esc_url_raw( rest_url( 'noaway/v1/email-download-link' ) ),
			'nonce'       => wp_create_nonce( 'wp_rest' ),
			'downloadsUrl'=> esc_url_raw( noaway_email_link_downloads_url() ),
			'privacyUrl'  => esc_url_raw( home_url( '/privacy-policy/' ) ),
			'cookieKey'   => 'noawayCookieConsentV1',
			'i18n'        => array(
				'sending' => __( 'Sending…', 'noaway' ),
				'success' => __( 'Check your inbox for the download link.', 'noaway' ),
				'error'   => __( 'Something went wrong. Please try again.', 'noaway' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'noaway_email_link_enqueue_assets', 35 );

/**
 * Render the mobile-only email link: a compact text toggle that expands into the form.
 *
 * Place this AFTER the primary Buy button so the purchase CTA always comes first on mobile.
 */
function noaway_render_mobile_email_link_box( $args = array() ) {
	if ( ! noaway_email_link_should_load() ) {
		return;
	}
	$args    = wp_parse_args( is_array( $args ) ? $args : array(), array( 'on_primary' => false ) );
	$classes = 'noaway-email-link md:hidden' . ( ! empty( $args['on_primary'] ) ? ' noaway-email-link--on-primary' : '' );
	$privacy = home_url( '/privacy-policy/' );
	$ui      = function_exists( 'noaway_i18n_ui' );
	$aria    = $ui ? noaway_i18n_ui( 'email_aria' ) : __( 'Email yourself the download link', 'noaway' );
	$toggle  = $ui ? noaway_i18n_ui( 'email_toggle' ) : __( 'Not on your computer? Email me the link', 'noaway' );
	$title   = $ui ? noaway_i18n_ui( 'email_title' ) : __( 'On your phone? Email yourself the link and buy on your computer.', 'noaway' );
	$label   = $ui ? noaway_i18n_ui( 'email_label' ) : __( 'Email address', 'noaway' );
	$ph      = $ui ? noaway_i18n_ui( 'email_placeholder' ) : __( 'you@example.com', 'noaway' );
	$hp      = $ui ? noaway_i18n_ui( 'email_hp' ) : __( 'Company website', 'noaway' );
	$consent = $ui ? noaway_i18n_ui( 'email_consent' ) : __( 'Send me occasional product emails (optional)', 'noaway' );
	$note    = $ui ? noaway_i18n_ui( 'email_note' ) : __( 'We email only the download link unless you opt in. See our', 'noaway' );
	$privacy_label = $ui ? noaway_i18n_ui( 'email_privacy' ) : __( 'Privacy Policy', 'noaway' );
	$submit  = $ui ? noaway_i18n_ui( 'email_submit' ) : __( 'Email me the link', 'noaway' );
	?>
	<div class="<?php echo esc_attr( $classes ); ?>" data-noaway-email-link role="region" aria-label="<?php echo esc_attr( $aria ); ?>">
		<button type="button" class="noaway-email-link__toggle" data-noaway-email-link-toggle aria-expanded="false" aria-controls="noaway-email-link-panel"><?php echo esc_html( $toggle ); ?></button>
		<div class="noaway-email-link__panel" id="noaway-email-link-panel" data-noaway-email-link-panel hidden>
			<p class="noaway-email-link__title"><?php echo esc_html( $title ); ?></p>
			<form class="noaway-email-link__form" data-noaway-email-link-form novalidate>
				<label class="noaway-email-link__sr-only" for="noaway-email-link-input"><?php echo esc_html( $label ); ?></label>
				<input
					id="noaway-email-link-input"
					class="noaway-email-link__input"
					type="email"
					name="email"
					autocomplete="email"
					inputmode="email"
					required
					placeholder="<?php echo esc_attr( $ph ); ?>"
				>
				<?php /* Honeypot — leave empty. */ ?>
				<div class="noaway-email-link__hp" aria-hidden="true">
					<label for="noaway-email-link-hp"><?php echo esc_html( $hp ); ?></label>
					<input id="noaway-email-link-hp" type="text" name="website" tabindex="-1" autocomplete="off">
				</div>
				<label class="noaway-email-link__consent">
					<input type="checkbox" name="marketing_opt_in" value="1">
					<span><?php echo esc_html( $consent ); ?></span>
				</label>
				<p class="noaway-email-link__note">
					<?php echo esc_html( $note ); ?>
					<a href="<?php echo esc_url( $privacy ); ?>"><?php echo esc_html( $privacy_label ); ?></a>.
				</p>
				<button type="submit" class="noaway-email-link__submit"><?php echo esc_html( $submit ); ?></button>
				<p class="noaway-email-link__status" data-noaway-email-link-status role="status" aria-live="polite" hidden></p>
			</form>
		</div>
	</div>
	<?php
}
