<?php
/**
 * Buy CTA click + purchase attribution tracking (consent-gated on the frontend).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Events table name.
 */
function noaway_analytics_cta_table() {
	global $wpdb;
	return $wpdb->prefix . 'noaway_cta_events';
}

/**
 * Install / upgrade CTA events table.
 */
function noaway_analytics_cta_install_table() {
	global $wpdb;
	$table   = noaway_analytics_cta_table();
	$version = '1.0';
	if ( get_option( 'noaway_cta_events_db_version' ) === $version ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$charset = $wpdb->get_charset_collate();
	$sql     = "CREATE TABLE {$table} (
		id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		event_type varchar(20) NOT NULL,
		page_path varchar(255) NOT NULL DEFAULT '',
		page_slug varchar(191) NOT NULL DEFAULT '',
		position varchar(64) NOT NULL DEFAULT '',
		session_id varchar(128) NOT NULL DEFAULT '',
		created_at datetime NOT NULL,
		PRIMARY KEY  (id),
		KEY event_created (event_type, created_at),
		KEY slug_created (page_slug, created_at),
		KEY session_event (session_id, event_type)
	) {$charset};";
	dbDelta( $sql );
	update_option( 'noaway_cta_events_db_version', $version, false );
}
add_action( 'plugins_loaded', 'noaway_analytics_cta_install_table' );

/**
 * Register REST routes.
 */
function noaway_analytics_cta_register_rest() {
	register_rest_route(
		'noaway-analytics/v1',
		'/cta-event',
		array(
			'methods'             => 'POST',
			'callback'            => 'noaway_analytics_cta_rest_handler',
			'permission_callback' => '__return_true',
			'args'                => array(
				'event_type' => array(
					'required' => true,
					'type'     => 'string',
				),
				'page_path'  => array(
					'required' => false,
					'type'     => 'string',
					'default'  => '',
				),
				'page_slug'  => array(
					'required' => false,
					'type'     => 'string',
					'default'  => '',
				),
				'position'   => array(
					'required' => false,
					'type'     => 'string',
					'default'  => '',
				),
				'session_id' => array(
					'required' => false,
					'type'     => 'string',
					'default'  => '',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'noaway_analytics_cta_register_rest' );

/**
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response|WP_Error
 */
function noaway_analytics_cta_rest_handler( WP_REST_Request $request ) {
	$type = sanitize_key( (string) $request->get_param( 'event_type' ) );
	// `email_link_sent` is recorded server-side only (see noaway_analytics_email_link_sent_record()).
	if ( ! in_array( $type, array( 'click', 'purchase', 'email_link_click' ), true ) ) {
		return new WP_Error( 'invalid_type', 'Invalid event type.', array( 'status' => 400 ) );
	}

	$path = sanitize_text_field( (string) $request->get_param( 'page_path' ) );
	$path = substr( $path, 0, 255 );
	$slug = sanitize_title( (string) $request->get_param( 'page_slug' ) );
	$slug = substr( $slug, 0, 191 );
	$pos  = sanitize_key( (string) $request->get_param( 'position' ) );
	$pos  = substr( $pos, 0, 64 );
	$sid  = sanitize_text_field( (string) $request->get_param( 'session_id' ) );
	$sid  = substr( $sid, 0, 128 );

	if ( $slug === '' && $path !== '' ) {
		$trim = trim( $path, '/' );
		$slug = $trim === '' ? 'home' : sanitize_title( basename( $trim ) );
	}
	if ( $slug === '' ) {
		$slug = 'unknown';
	}

	// Deduplicate purchase events by Stripe session id.
	if ( $type === 'purchase' && $sid !== '' ) {
		global $wpdb;
		$table = noaway_analytics_cta_table();
		$exists = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE event_type = %s AND session_id = %s LIMIT 1",
				'purchase',
				$sid
			)
		);
		if ( $exists > 0 ) {
			return rest_ensure_response( array( 'ok' => true, 'deduped' => true ) );
		}
	}

	global $wpdb;
	$table = noaway_analytics_cta_table();
	$wpdb->insert(
		$table,
		array(
			'event_type' => $type,
			'page_path'  => $path,
			'page_slug'  => $slug,
			'position'   => $pos,
			'session_id' => $sid,
			'created_at' => current_time( 'mysql', true ),
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s' )
	);

	return rest_ensure_response( array( 'ok' => true ) );
}

/**
 * Record a successful "email me the link" send (server-side, no email address stored here).
 *
 * Hooked to `noaway_email_link_sent` from the theme. Counted as event_type `email_link_sent`.
 *
 * @param string $email     Unused (never stored in the CTA events table).
 * @param bool   $marketing Unused.
 * @param string $page_url  Page the visitor submitted the form from.
 */
function noaway_analytics_email_link_sent_record( $email = '', $marketing = false, $page_url = '' ) {
	global $wpdb;
	$path = '';
	if ( is_string( $page_url ) && $page_url !== '' ) {
		$parsed = wp_parse_url( $page_url );
		$path   = isset( $parsed['path'] ) ? (string) $parsed['path'] : '';
	}
	$path = substr( sanitize_text_field( $path ), 0, 255 );
	$trim = trim( $path, '/' );
	$slug = $trim === '' ? 'home' : sanitize_title( basename( $trim ) );
	if ( $slug === '' ) {
		$slug = 'unknown';
	}
	$wpdb->insert(
		noaway_analytics_cta_table(),
		array(
			'event_type' => 'email_link_sent',
			'page_path'  => $path,
			'page_slug'  => substr( $slug, 0, 191 ),
			'position'   => 'email-link',
			'session_id' => '',
			'created_at' => current_time( 'mysql', true ),
		),
		array( '%s', '%s', '%s', '%s', '%s', '%s' )
	);
}
add_action( 'noaway_email_link_sent', 'noaway_analytics_email_link_sent_record', 10, 3 );

/**
 * Frontend assets for CTA click + thank-you purchase ping.
 */
function noaway_analytics_cta_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}
	$js_rel = 'assets/cta-tracking.js';
	$js_abs = NOAWAY_ANALYTICS_PLUGIN_DIR . $js_rel;
	$ver    = file_exists( $js_abs ) ? (string) filemtime( $js_abs ) : NOAWAY_ANALYTICS_VERSION;

	wp_enqueue_script(
		'noaway-analytics-cta',
		NOAWAY_ANALYTICS_PLUGIN_URL . $js_rel,
		array(),
		$ver,
		true
	);

	$is_thank_you = false;
	$template     = function_exists( 'get_page_template_slug' ) ? get_page_template_slug() : '';
	if ( $template === 'page-thank-you.php' ) {
		$is_thank_you = true;
	}

	wp_localize_script(
		'noaway-analytics-cta',
		'NoAwayAnalyticsCta',
		array(
			'restUrl'     => esc_url_raw( rest_url( 'noaway-analytics/v1/cta-event' ) ),
			'nonce'       => wp_create_nonce( 'wp_rest' ),
			'cookieKey'   => 'noawayCookieConsentV1',
			'storageKey'  => 'noawayCtaAttribution',
			'isThankYou'  => $is_thank_you,
			'sessionId'   => isset( $_GET['session_id'] ) ? sanitize_text_field( wp_unslash( $_GET['session_id'] ) ) : '',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'noaway_analytics_cta_enqueue_assets', 40 );

/**
 * Landing attribution rows for the last N days.
 *
 * @param int $days Days window.
 * @return array<int, array{page:string,clicks:int,purchases:int,conversion:float}>
 */
function noaway_analytics_cta_attribution_rows( $days = 30 ) {
	global $wpdb;
	$table = noaway_analytics_cta_table();
	$days  = max( 1, (int) $days );

	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is internal.
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return array();
	}

	$sql = $wpdb->prepare(
		"SELECT page_slug,
			SUM(CASE WHEN event_type = 'click' THEN 1 ELSE 0 END) AS clicks,
			SUM(CASE WHEN event_type = 'purchase' THEN 1 ELSE 0 END) AS purchases
		FROM {$table}
		WHERE created_at >= (UTC_TIMESTAMP() - INTERVAL %d DAY)
		GROUP BY page_slug
		ORDER BY clicks DESC, purchases DESC, page_slug ASC",
		$days
	);
	// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	$raw = $wpdb->get_results( $sql, ARRAY_A );
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$rows = array();
	foreach ( $raw as $row ) {
		$clicks     = isset( $row['clicks'] ) ? (int) $row['clicks'] : 0;
		$purchases  = isset( $row['purchases'] ) ? (int) $row['purchases'] : 0;
		$slug       = isset( $row['page_slug'] ) && $row['page_slug'] !== '' ? $row['page_slug'] : 'unknown';
		$conversion = $clicks > 0 ? round( ( $purchases / $clicks ) * 100, 1 ) : 0.0;
		$rows[]     = array(
			'page'       => $slug,
			'clicks'     => $clicks,
			'purchases'  => $purchases,
			'conversion' => $conversion,
		);
	}
	return $rows;
}

/**
 * Email-link funnel totals for the last N days.
 *
 * `sent` = emails sent from the mobile form; `clicks` = buy-CTA clicks made on a page
 * opened from the emailed link (URL carries ref=email-link).
 *
 * @param int $days Days window.
 * @return array{sent:int,clicks:int}
 */
function noaway_analytics_email_link_totals( $days = 30 ) {
	global $wpdb;
	$table = noaway_analytics_cta_table();
	$days  = max( 1, (int) $days );

	// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- table name is internal.
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( $exists !== $table ) {
		return array( 'sent' => 0, 'clicks' => 0 );
	}
	$sql = $wpdb->prepare(
		"SELECT
			SUM(CASE WHEN event_type = 'email_link_sent' THEN 1 ELSE 0 END) AS sent,
			SUM(CASE WHEN event_type = 'email_link_click' THEN 1 ELSE 0 END) AS clicks
		FROM {$table}
		WHERE created_at >= (UTC_TIMESTAMP() - INTERVAL %d DAY)",
		$days
	);
	// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	$row = $wpdb->get_row( $sql, ARRAY_A );
	return array(
		'sent'   => isset( $row['sent'] ) ? (int) $row['sent'] : 0,
		'clicks' => isset( $row['clicks'] ) ? (int) $row['clicks'] : 0,
	);
}
