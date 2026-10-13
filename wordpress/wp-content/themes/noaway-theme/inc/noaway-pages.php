<?php
/**
 * NoAway theme — page URLs, checkout, license API, macOS DMG URLs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve permalink for a page using a given template file, or fallback path.
 *
 * @param string $template_file e.g. 'page-downloads.php'.
 * @param string $fallback_path e.g. '/downloads/'.
 */
function noaway_page_url_by_template( $template_file, $fallback_path ) {
	$fallback_path = is_string( $fallback_path ) ? trim( $fallback_path ) : '/';
	if ( $fallback_path === '' ) {
		$fallback_path = '/';
	}
	if ( $fallback_path[0] !== '/' ) {
		$fallback_path = '/' . $fallback_path;
	}

	$base = '';
	if ( defined( 'WP_HOME' ) && WP_HOME ) {
		$base = rtrim( WP_HOME, '/' );
	} else {
		$home = home_url( '/' );
		if ( is_string( $home ) && preg_match( '#^https?://#i', $home ) ) {
			$base = rtrim( $home, '/' );
		}
	}
	$fallback_url = $base !== '' ? $base . $fallback_path : home_url( $fallback_path );

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template_file,
			'number'      => 1,
			'sort_column' => 'post_date',
			'sort_order'  => 'ASC',
		)
	);
	$url = ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : $fallback_url;
	if ( ! is_string( $url ) || $url === '' || $url === '/' ) {
		$url = $fallback_url;
	}
	if ( function_exists( 'noaway_seo_canonical_url' ) ) {
		$url = noaway_seo_canonical_url( $url );
	}
	if ( ! preg_match( '#^https?://#i', $url ) ) {
		$url = $fallback_url;
	}
	return $url;
}

/**
 * Current landing slug for attribution (home, keep-teams-active, …).
 *
 * @return string
 */
function noaway_current_landing_slug() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && ! empty( $post->post_name ) && is_string( $post->post_name ) ) {
			return sanitize_title( $post->post_name );
		}
	}
	$path = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$parsed = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $parsed ) ) {
			$path = trim( $parsed, '/' );
		}
	}
	if ( $path === '' ) {
		return 'home';
	}
	$parts = explode( '/', $path );
	$slug  = end( $parts );
	return $slug ? sanitize_title( $slug ) : 'home';
}

/**
 * Current page path for CTA analytics (e.g. /keep-teams-active/).
 *
 * @return string
 */
function noaway_current_landing_path() {
	if ( is_front_page() ) {
		return '/';
	}
	if ( is_singular() ) {
		$permalink = get_permalink();
		if ( is_string( $permalink ) && $permalink !== '' ) {
			$path = wp_parse_url( $permalink, PHP_URL_PATH );
			if ( is_string( $path ) && $path !== '' ) {
				return trailingslashit( $path );
			}
		}
	}
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $path ) && $path !== '' ) {
			return trailingslashit( $path );
		}
	}
	return '/';
}

/**
 * Stripe / license checkout URL, with landing attribution query args.
 *
 * @param array<string,mixed> $args Optional. Keys: ref (slug override).
 * @return string
 */
function noaway_checkout_url( $args = array() ) {
	$base = defined( 'NOAWAY_STRIPE_CHECKOUT_URL' ) ? NOAWAY_STRIPE_CHECKOUT_URL : 'https://license.noaway.app/create-checkout-session';
	if ( ! is_array( $args ) ) {
		$args = array();
	}
	$slug = '';
	if ( isset( $args['ref'] ) && is_string( $args['ref'] ) && $args['ref'] !== '' ) {
		$slug = sanitize_title( $args['ref'] );
	} else {
		$slug = noaway_current_landing_slug();
	}
	if ( $slug !== '' ) {
		// ref = our analytics slug; client_reference_id = Stripe-compatible if the endpoint forwards it.
		$base = add_query_arg(
			array(
				'ref'                  => $slug,
				'client_reference_id'  => $slug,
			),
			$base
		);
	}
	return $base;
}

/**
 * HTML attributes for buy CTAs (tracking + attribution metadata).
 *
 * @param string $position Button position label (hero, footer, header, cta, …).
 * @return string Attributes string starting with a space (safe to echo inside a tag).
 */
function noaway_buy_cta_attrs( $position = 'cta' ) {
	$position = is_string( $position ) ? sanitize_key( $position ) : 'cta';
	if ( $position === '' ) {
		$position = 'cta';
	}
	$path = noaway_current_landing_path();
	$slug = noaway_current_landing_slug();
	return sprintf(
		' data-noaway-cta="buy" data-noaway-path="%s" data-noaway-position="%s" data-noaway-ref="%s"',
		esc_attr( $path ),
		esc_attr( $position ),
		esc_attr( $slug )
	);
}

function noaway_license_api_url() {
	return defined( 'NOAWAY_LICENSE_API_URL' ) ? NOAWAY_LICENSE_API_URL : 'https://license.noaway.app';
}

/** Launch price label, e.g. "€4.99". Amount: NOAWAY_SEO_PRICE_AMOUNT. */
function noaway_price_label() {
	return '€' . NOAWAY_SEO_PRICE_AMOUNT;
}

/** Regular price label, e.g. "€9.99". Amount: NOAWAY_REGULAR_PRICE_AMOUNT. */
function noaway_regular_price_label() {
	return '€' . NOAWAY_REGULAR_PRICE_AMOUNT;
}

/**
 * Optional social-proof label for the homepage.
 * Empty by default so unverified counts are not shown.
 * Supply a real figure via the `noaway_social_proof_label` filter.
 *
 * @return string
 */
function noaway_social_proof_label() {
	$label = apply_filters( 'noaway_social_proof_label', '' );
	if ( ! is_string( $label ) ) {
		return '';
	}
	return trim( $label );
}

/**
 * Public Mac/Windows installer URLs are intentionally not exposed.
 * Anonymous visitors go to checkout; signed links are issued after purchase
 * (thank-you page + license email via api/download.php).
 *
 * Legacy NOAWAY_MAC_*_DMG / NOAWAY_WINDOWS_SETUP_EXE constants are ignored.
 */
function noaway_mac_universal_url() {
	return noaway_checkout_url();
}

function noaway_mac_arm64_url() {
	return noaway_checkout_url();
}

/** Empty = theme templates must send visitors to checkout (not a public .exe). */
function noaway_windows_setup_url() {
	return '';
}

function noaway_features_page_url() {
	return noaway_page_url_by_template( 'page-features.php', '/features/' );
}

function noaway_how_it_works_page_url() {
	return noaway_page_url_by_template( 'page-how-it-works.php', '/how-it-works/' );
}

function noaway_keep_teams_active_page_url() {
	return noaway_page_url_by_template( 'page-keep-teams-active.php', '/keep-teams-active/' );
}

function noaway_teams_away_status_page_url() {
	return noaway_page_url_by_template( 'page-teams-away-status.php', '/teams-away-status/' );
}

function noaway_keep_slack_active_page_url() {
	return noaway_page_url_by_template( 'page-keep-slack-active.php', '/keep-slack-active/' );
}

function noaway_prevent_computer_sleep_page_url() {
	return noaway_page_url_by_template( 'page-prevent-computer-sleep.php', '/prevent-computer-sleep/' );
}

function noaway_is_noaway_safe_page_url() {
	return noaway_page_url_by_template( 'page-is-noaway-safe.php', '/is-noaway-safe/' );
}

function noaway_help_page_url() {
	return noaway_page_url_by_template( 'page-help.php', '/help/' );
}

function noaway_downloads_page_url() {
	// Canonical download URL is /downloads/ (/download/ 301s there).
	return noaway_page_url_by_template( 'page-downloads.php', '/downloads/' );
}

/**
 * Ensure the downloads page uses the /downloads/ slug (idempotent).
 */
function noaway_ensure_downloads_slug() {
	if ( ! function_exists( 'wp_update_post' ) ) {
		return;
	}
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-downloads.php',
			'number'      => 1,
			'post_status' => array( 'publish', 'private', 'draft' ),
		)
	);
	if ( empty( $pages[0] ) ) {
		return;
	}
	$page = $pages[0];
	if ( $page->post_name === 'downloads' ) {
		return;
	}
	$conflict = get_page_by_path( 'downloads', OBJECT, 'page' );
	if ( $conflict instanceof WP_Post && (int) $conflict->ID !== (int) $page->ID ) {
		return;
	}
	$result = wp_update_post(
		array(
			'ID'        => (int) $page->ID,
			'post_name' => 'downloads',
		),
		true
	);
	if ( ! is_wp_error( $result ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'after_switch_theme', 'noaway_ensure_downloads_slug' );
add_action( 'admin_init', 'noaway_ensure_downloads_slug', 31 );

function noaway_faq_page_url() {
	return noaway_page_url_by_template( 'page-faq.php', '/faq/' );
}

function noaway_contact_page_url() {
	// Production slug is /contacts/. /contact/ already 301s to /contacts/.
	return noaway_page_url_by_template( 'page-contatti.php', '/contacts/' );
}

/**
 * Responsive <picture> with WebP + PNG fallback for theme images.
 *
 * @param string               $basename Filename without extension under assets/images/ (e.g. landing-hero-section).
 * @param string               $alt      Alt text.
 * @param array<string,mixed>  $attrs    Optional img attrs: class, width, height, loading, fetchpriority, decoding.
 */
function noaway_picture( $basename, $alt, $attrs = array() ) {
	$basename = is_string( $basename ) ? basename( $basename ) : '';
	$basename = preg_replace( '/\.(webp|png|jpe?g|gif|svg|avif)$/i', '', $basename );
	if ( ! is_string( $basename ) || $basename === '' ) {
		return;
	}
	if ( ! is_array( $attrs ) ) {
		$attrs = array();
	}
	$dir   = get_stylesheet_directory() . '/assets/images/';
	$uri   = get_stylesheet_directory_uri() . '/assets/images/';
	$class = isset( $attrs['class'] ) ? (string) $attrs['class'] : '';
	$width = isset( $attrs['width'] ) ? (int) $attrs['width'] : 0;
	$height = isset( $attrs['height'] ) ? (int) $attrs['height'] : 0;
	$loading = isset( $attrs['loading'] ) ? (string) $attrs['loading'] : '';
	$fetchpriority = isset( $attrs['fetchpriority'] ) ? (string) $attrs['fetchpriority'] : '';
	$decoding = isset( $attrs['decoding'] ) ? (string) $attrs['decoding'] : 'async';
	$sizes = isset( $attrs['sizes'] ) ? (string) $attrs['sizes'] : '';
	$widths = array();
	if ( ! empty( $attrs['widths'] ) && is_array( $attrs['widths'] ) ) {
		foreach ( $attrs['widths'] as $candidate ) {
			$candidate = (int) $candidate;
			if ( $candidate > 0 ) {
				$widths[] = $candidate;
			}
		}
	}

	$srcset_for = function ( $ext ) use ( $dir, $uri, $basename, $widths ) {
		$parts = array();
		foreach ( $widths as $w ) {
			$file = $dir . $basename . '-' . $w . '.' . $ext;
			if ( ! file_exists( $file ) ) {
				continue;
			}
			$parts[] = esc_url( $uri . $basename . '-' . $w . '.' . $ext ) . ' ' . $w . 'w';
		}
		return implode( ', ', $parts );
	};

	$img_attrs = '';
	if ( $class !== '' ) {
		$img_attrs .= ' class="' . esc_attr( $class ) . '"';
	}
	if ( $width > 0 ) {
		$img_attrs .= ' width="' . $width . '"';
	}
	if ( $height > 0 ) {
		$img_attrs .= ' height="' . $height . '"';
	}
	if ( $loading !== '' ) {
		$img_attrs .= ' loading="' . esc_attr( $loading ) . '"';
	}
	if ( $fetchpriority !== '' ) {
		$img_attrs .= ' fetchpriority="' . esc_attr( $fetchpriority ) . '"';
	}
	if ( $decoding !== '' ) {
		$img_attrs .= ' decoding="' . esc_attr( $decoding ) . '"';
	}

	$png_srcset = $srcset_for( 'png' );
	$webp_srcset = $srcset_for( 'webp' );
	$avif_srcset = $srcset_for( 'avif' );
	$png = $dir . $basename . '.png';
	$webp = $dir . $basename . '.webp';
	$fallback_src = file_exists( $png ) ? $uri . $basename . '.png' : $uri . $basename . '.webp';
	if ( $png_srcset !== '' && ! empty( $widths ) ) {
		$largest = max( $widths );
		$sized_png = $dir . $basename . '-' . $largest . '.png';
		if ( file_exists( $sized_png ) ) {
			$fallback_src = $uri . $basename . '-' . $largest . '.png';
		}
	}

	$sizes_attr = $sizes !== '' ? ' sizes="' . esc_attr( $sizes ) . '"' : '';
	echo '<picture>';
	if ( $avif_srcset !== '' ) {
		echo '<source type="image/avif" srcset="' . $avif_srcset . '"' . $sizes_attr . '>';
	}
	if ( $webp_srcset !== '' ) {
		echo '<source type="image/webp" srcset="' . $webp_srcset . '"' . $sizes_attr . '>';
	} elseif ( file_exists( $webp ) ) {
		echo '<source type="image/webp" srcset="' . esc_url( $uri . $basename . '.webp' ) . '">';
	}
	if ( $png_srcset !== '' ) {
		$img_attrs .= ' srcset="' . $png_srcset . '"' . $sizes_attr;
	}
	echo '<img' . $img_attrs . ' alt="' . esc_attr( $alt ) . '" src="' . esc_url( $fallback_src ) . '">';
	echo '</picture>';
}

/**
 * Short "what it controls / what it doesn't" block. Same limits as Help.
 *
 * @param string $lang en|de|es|pt-br|fr.
 */
function noaway_render_controls_note( $lang = 'en' ) {
	$lang = is_string( $lang ) ? $lang : 'en';
	$copy = array(
		'en'    => array(
			'h'   => 'What NoAway controls — and what it doesn’t',
			'yes' => 'System activity and sleep on the computer where NoAway is running, while Keep Active is on.',
			'no'  => 'Calendar status, a locked screen, company policy, and presence on other devices.',
		),
		'de'    => array(
			'h'   => 'Was NoAway steuert — und was nicht',
			'yes' => 'Systemaktivität und Ruhezustand auf dem Computer, auf dem NoAway läuft, solange Keep Active an ist.',
			'no'  => 'Kalenderstatus, einen gesperrten Bildschirm, Unternehmensrichtlinien und die Anwesenheit auf anderen Geräten.',
		),
		'es'    => array(
			'h'   => 'Qué controla NoAway — y qué no',
			'yes' => 'La actividad del sistema y la suspensión en el equipo donde NoAway está en marcha, mientras Keep Active está activo.',
			'no'  => 'El estado del calendario, una pantalla bloqueada, las políticas de la empresa y la presencia en otros dispositivos.',
		),
		'pt-br' => array(
			'h'   => 'O que o NoAway controla — e o que não controla',
			'yes' => 'A atividade do sistema e a suspensão no computador em que o NoAway está rodando, enquanto o Keep Active está ligado.',
			'no'  => 'O status do calendário, uma tela bloqueada, as políticas da empresa e a presença em outros dispositivos.',
		),
		'fr'    => array(
			'h'   => 'Ce que NoAway contrôle — et ce qu’il ne contrôle pas',
			'yes' => 'L’activité du système et la veille sur l’ordinateur où NoAway tourne, tant que Keep Active est activé.',
			'no'  => 'Le statut du calendrier, un écran verrouillé, les règles de l’entreprise et la présence sur d’autres appareils.',
		),
	);
	$c = isset( $copy[ $lang ] ) ? $copy[ $lang ] : $copy['en'];
	$yes_label = array(
		'en'    => 'It controls',
		'de'    => 'Es steuert',
		'es'    => 'Controla',
		'pt-br' => 'Controla',
		'fr'    => 'Il contrôle',
	);
	$no_label = array(
		'en'    => 'It doesn’t',
		'de'    => 'Nicht',
		'es'    => 'No controla',
		'pt-br' => 'Não controla',
		'fr'    => 'Il ne contrôle pas',
	);
	$yes = isset( $yes_label[ $lang ] ) ? $yes_label[ $lang ] : $yes_label['en'];
	$no  = isset( $no_label[ $lang ] ) ? $no_label[ $lang ] : $no_label['en'];
	?>
	<section class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/40 p-6" aria-labelledby="noaway-controls-heading">
		<h2 id="noaway-controls-heading" class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-3"><?php echo esc_html( $c['h'] ); ?></h2>
		<ul class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed space-y-2">
			<li><strong class="text-slate-800 dark:text-slate-200"><?php echo esc_html( $yes ); ?>:</strong> <?php echo esc_html( $c['yes'] ); ?></li>
			<li><strong class="text-slate-800 dark:text-slate-200"><?php echo esc_html( $no ); ?>:</strong> <?php echo esc_html( $c['no'] ); ?></li>
		</ul>
	</section>
	<?php
}

/**
 * Data actually sent, from this repo. Unknown client fields stay as PHP TODOs.
 *
 * @return array<int, array{activity:string,where:string,data:string}>
 */
function noaway_privacy_transfer_rows() {
	return array(
		array(
			'activity' => 'Keep Active',
			'where'    => 'On your computer',
			'data'     => 'Nothing for the idle and sleep prevention itself. It does not send keystrokes, screen contents, chats, or files.',
		),
		array(
			'activity' => 'Activation',
			'where'    => 'License server (license.noaway.app)',
			'data'     => 'License key, the email used at purchase, and a device id.',
		),
		array(
			'activity' => 'License check',
			'where'    => 'License server',
			'data'     => 'License key and device id. The server also accepts, when the app includes them, app version, platform, activity mode, detected app names (Teams, Slack, Zoom, or Discord), and seconds kept active that day.',
			// TODO: Confirm which of those optional fields the shipping app actually sends.
		),
		array(
			'activity' => 'Updates',
			'where'    => 'License server',
			'data'     => 'Updates contact the license server.',
			// TODO: Confirm the update-check URL and the fields the app sends.
		),
		array(
			'activity' => 'Purchase',
			'where'    => 'Stripe, via the license server',
			'data'     => 'Stripe collects the payment. This website only adds a landing reference (ref and client_reference_id) to the checkout URL.',
			// TODO: Confirm which billing fields the license server stores after Stripe payment (email, order id).
		),
		array(
			'activity' => 'Website',
			'where'    => 'Google Analytics 4, only after analytics consent',
			'data'     => 'Page views. Buy-button clicks record the page path, button position, and landing reference in this site’s analytics.',
		),
		array(
			'activity' => 'Support',
			'where'    => 'Email to support@noaway.app',
			'data'     => 'Name, email, topic, subject, and message from the contact form. A reCAPTCHA token is included only if a site key is configured.',
		),
	);
}

/**
 * Visible privacy table shared by /is-noaway-safe/ and /privacy-policy/.
 */
function noaway_render_privacy_transfer_table() {
	$rows = noaway_privacy_transfer_rows();
	?>
	<div class="not-prose overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 mb-6">
		<table class="w-full text-left text-sm">
			<thead>
				<tr class="bg-slate-50 dark:bg-slate-900/60">
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Activity</th>
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Where</th>
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Data sent</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-slate-200 dark:divide-slate-700">
				<?php foreach ( $rows as $row ) : ?>
				<tr>
					<td class="p-4 font-semibold text-slate-800 dark:text-slate-200 align-top"><?php echo esc_html( $row['activity'] ); ?></td>
					<td class="p-4 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['where'] ); ?></td>
					<td class="p-4 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['data'] ); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}
