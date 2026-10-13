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
	$basename = preg_replace( '/\.(webp|png|jpe?g|gif|svg)$/i', '', $basename );
	if ( ! is_string( $basename ) || $basename === '' ) {
		return;
	}
	if ( ! is_array( $attrs ) ) {
		$attrs = array();
	}
	$dir  = get_stylesheet_directory() . '/assets/images/';
	$uri  = get_stylesheet_directory_uri() . '/assets/images/';
	$webp = $dir . $basename . '.webp';
	$png  = $dir . $basename . '.png';
	$class = isset( $attrs['class'] ) ? (string) $attrs['class'] : '';
	$width = isset( $attrs['width'] ) ? (int) $attrs['width'] : 0;
	$height = isset( $attrs['height'] ) ? (int) $attrs['height'] : 0;
	$loading = isset( $attrs['loading'] ) ? (string) $attrs['loading'] : '';
	$fetchpriority = isset( $attrs['fetchpriority'] ) ? (string) $attrs['fetchpriority'] : '';
	$decoding = isset( $attrs['decoding'] ) ? (string) $attrs['decoding'] : 'async';

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

	$fallback_src = file_exists( $png ) ? $uri . $basename . '.png' : $uri . $basename . '.webp';
	echo '<picture>';
	if ( file_exists( $webp ) ) {
		echo '<source type="image/webp" srcset="' . esc_url( $uri . $basename . '.webp' ) . '">';
	}
	echo '<img' . $img_attrs . ' alt="' . esc_attr( $alt ) . '" src="' . esc_url( $fallback_src ) . '">';
	echo '</picture>';
}
