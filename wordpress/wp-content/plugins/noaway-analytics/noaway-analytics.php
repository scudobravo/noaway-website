<?php
/**
 * Plugin Name: NoAway Analytics
 * Description: Analytics dashboard for NoAway licenses, usage, and buy-CTA attribution
 * Version: 1.1.0
 * Author: NoAway
 * Text Domain: noaway-analytics
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NOAWAY_ANALYTICS_VERSION', '1.1.0' );
define( 'NOAWAY_ANALYTICS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NOAWAY_ANALYTICS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once NOAWAY_ANALYTICS_PLUGIN_DIR . 'includes/cta-tracking.php';

register_activation_hook( __FILE__, 'noaway_analytics_cta_install_table' );

/**
 * Registra la voce di menu in admin: NoAway Analytics.
 */
function noaway_analytics_menu() {
	add_menu_page(
		__( 'NoAway Analytics', 'noaway-analytics' ),
		__( 'NoAway Analytics', 'noaway-analytics' ),
		'manage_options',
		'noaway-analytics',
		'noaway_analytics_render_dashboard',
		'dashicons-chart-bar',
		30
	);
}
add_action( 'admin_menu', 'noaway_analytics_menu' );

/**
 * Renderizza la pagina dashboard (solo per utenti con manage_options).
 */
function noaway_analytics_render_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'noaway-analytics' ) );
	}
	wp_enqueue_style(
		'noaway-analytics',
		NOAWAY_ANALYTICS_PLUGIN_URL . 'styles.css',
		array(),
		NOAWAY_ANALYTICS_VERSION
	);
	include NOAWAY_ANALYTICS_PLUGIN_DIR . 'dashboard.php';
}
