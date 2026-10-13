<?php
/**
 * NoAway theme — bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$noaway_inc = get_template_directory() . '/inc/';
require_once $noaway_inc . 'noaway-facts.php';
require_once $noaway_inc . 'noaway-pages.php';
require_once $noaway_inc . 'noaway-i18n.php';
require_once $noaway_inc . 'noaway-comparisons.php';
require_once $noaway_inc . 'noaway-analytics.php';
require_once $noaway_inc . 'noaway-cookie-consent.php';
require_once $noaway_inc . 'noaway-email-link.php';
require_once $noaway_inc . 'noaway-seo.php';
require_once $noaway_inc . 'noaway-sitemap.php';
require_once $noaway_inc . 'noaway-ai-discovery.php';

/**
 * Redirect host/protocol are enforced at web-server level to keep one-hop 301.
 * Avoid PHP-level host redirects here to prevent chains and crawl instability.
 */

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 320,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
	}
);

/**
 * Favicon / site icons for browsers and Google Search.
 * Theme assets take precedence over any WP Site Icon set in admin.
 */
remove_action( 'wp_head', 'wp_site_icon', 99 );

/**
 * Absolute URL for a theme image under assets/images/.
 *
 * @param string $filename File name (e.g. favicon-48.png).
 * @return string
 */
function noaway_theme_image_url( $filename ) {
	return get_template_directory_uri() . '/assets/images/' . ltrim( (string) $filename, '/' );
}

/**
 * Output favicon and apple-touch-icon link tags.
 */
function noaway_favicon_wp_head() {
	$icon_32  = esc_url( noaway_theme_image_url( 'favicon-32.png' ) );
	$icon_48  = esc_url( noaway_theme_image_url( 'favicon-48.png' ) );
	$icon_192 = esc_url( noaway_theme_image_url( 'favicon-192.png' ) );
	$icon_svg = esc_url( noaway_theme_image_url( 'logo.svg' ) );
	$apple    = esc_url( noaway_theme_image_url( 'apple-touch-icon.png' ) );
	$ico      = esc_url( noaway_theme_image_url( 'favicon.ico' ) );

	echo "\n";
	echo '<link rel="icon" href="' . $icon_48 . '" sizes="48x48" type="image/png">' . "\n";
	echo '<link rel="icon" href="' . $icon_32 . '" sizes="32x32" type="image/png">' . "\n";
	echo '<link rel="icon" href="' . $icon_192 . '" sizes="192x192" type="image/png">' . "\n";
	echo '<link rel="icon" href="' . $icon_svg . '" type="image/svg+xml">' . "\n";
	echo '<link rel="shortcut icon" href="' . $ico . '">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . $apple . '" sizes="180x180">' . "\n";
}
add_action( 'wp_head', 'noaway_favicon_wp_head', 1 );

add_action(
	'wp_enqueue_scripts',
	function () {
		$ver = '1.1.2';
		wp_enqueue_style( 'noaway-theme', get_stylesheet_uri(), array(), $ver );
		wp_enqueue_style( 'noaway-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array( 'noaway-theme' ), $ver );
		// Inter: medium/semibold/bold/extrabold/black used in templates (400 unused).
		// Montserrat: logo wordmark (font-logo font-extrabold).
		// Material Symbols: used widely across templates (not few icons — keep as webfont).
		wp_enqueue_style( 'noaway-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800;900&family=Montserrat:wght@800&display=swap', array(), null );
		wp_enqueue_style( 'noaway-material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null );
	}
);

/**
 * Public installer URLs under /noaway-releases/*.dmg must not be altered by redirect_canonical
 * (www vs non-www, trailing slash, etc.). Those files are served as static assets by Apache.
 */
add_filter(
	'redirect_canonical',
	function ( $redirect_url, $requested_url ) {
		$path = '';
		if ( is_string( $requested_url ) && $requested_url !== '' ) {
			$path = (string) wp_parse_url( $requested_url, PHP_URL_PATH );
		}
		if ( $path && preg_match( '#^/sitemap\.xml/?$#i', $path ) ) {
			return false;
		}
		if ( $path && preg_match( '#^/noaway-releases/.+\.(dmg|exe)$#i', $path ) ) {
			return false;
		}
		return $redirect_url;
	},
	10,
	2
);

/**
 * Legacy path (no trailing slash) => target path.
 * Add rows here. /noaway-releases/ is never redirected.
 *
 * /contacts/ is the canonical contact page (page-contatti.php).
 * /contact/ 301s here. Canonical download URL is /downloads/; /download/ 301s there.
 * /privacy-policy/ is canonical; /privacy-policy-2/ 301s there.
 */
function noaway_legacy_redirects() {
	return array(
		'/prevent-teams-away'          => '/keep-teams-active/',
		'/keep-teams-icon-green'       => '/keep-teams-active/',
		'/keep-microsoft-teams-active' => '/keep-teams-active/',
		'/keep-active'                 => '/',
		'/keep-active-native'          => '/',
		'/keep-ticks-active'           => '/',
		'/keep-testimonials'           => '/',
		// Canonical download slug is /downloads/.
		'/download'                    => '/downloads/',
		'/contact'                     => '/contacts/',
		'/privacy-policy-2'            => '/privacy-policy/',
	);
}

/**
 * 301 legacy URLs before any template output.
 */
add_action(
	'template_redirect',
	function () {
		if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}
		$path = '';
		if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
			$parsed = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
			$path   = is_string( $parsed ) ? $parsed : '';
		}
		$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		$home_path = untrailingslashit( $home_path );
		if ( $home_path !== '' && strpos( $path, $home_path ) === 0 ) {
			$path = substr( $path, strlen( $home_path ) );
		}
		if ( $path === '' || $path[0] !== '/' ) {
			$path = '/' . ltrim( $path, '/' );
		}
		if ( preg_match( '#^/noaway-releases/#i', $path ) ) {
			return;
		}
		$path = untrailingslashit( $path );
		if ( $path === '' ) {
			$path = '/';
		}
		$map = noaway_legacy_redirects();
		if ( ! isset( $map[ $path ] ) ) {
			return;
		}
		// WordPress currently serves the policy at /privacy-policy-2/ and
		// redirects /privacy-policy/ there. 301 the other way only after the
		// slug in wp-admin is privacy-policy, or the two redirects loop.
		if ( $path === '/privacy-policy-2' ) {
			$privacy_page = get_page_by_path( 'privacy-policy' );
			if ( ! ( $privacy_page instanceof WP_Post ) || $privacy_page->post_status !== 'publish' ) {
				return;
			}
		}
		$target = home_url( $map[ $path ] );
		if ( function_exists( 'noaway_seo_canonical_url' ) ) {
			$target = noaway_seo_canonical_url( $target );
		}
		if ( ! is_string( $target ) || $target === '' ) {
			return;
		}
		wp_safe_redirect( $target, 301 );
		exit;
	},
	0
);
