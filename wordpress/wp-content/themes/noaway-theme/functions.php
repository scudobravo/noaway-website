<?php
/**
 * NoAway theme — bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$noaway_inc = get_template_directory() . '/inc/';
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

add_action(
	'wp_enqueue_scripts',
	function () {
		$ver = '1.1.2';
		wp_enqueue_style( 'noaway-theme', get_stylesheet_uri(), array(), $ver );
		wp_enqueue_style( 'noaway-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array( 'noaway-theme' ), $ver );
		wp_enqueue_style( 'noaway-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@700;800&display=swap', array(), null );
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
 * /download/ and /contacts/ are not in this map: those slugs are the live pages
 * (page-downloads.php and page-contatti.php). /downloads/ is a 404, and /contact/
 * already 301s to /contacts/.
 */
function noaway_legacy_redirects() {
	return array(
		'/prevent-teams-away'         => '/keep-teams-active/',
		'/keep-teams-icon-green'      => '/keep-teams-active/',
		'/keep-microsoft-teams-active' => '/keep-teams-active/',
		'/keep-active'                => '/',
		'/keep-active-native'         => '/',
		'/keep-ticks-active'          => '/',
		'/keep-testimonials'          => '/',
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
