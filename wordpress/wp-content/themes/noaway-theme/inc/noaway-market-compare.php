<?php
/**
 * Market price comparison data for /compare/ (NoAway vs cloud Slack tools & USB jigglers).
 * Prices and claims are as checked on the date below — do not invent unpublished figures.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Date prices/claims on this page were last checked (display string). */
define( 'NOAWAY_MARKET_COMPARE_CHECKED', '14 October 2026' );

/**
 * Whether the current request is the /compare/ market page (not a noaway-vs-* landing).
 *
 * @return bool
 */
function noaway_is_market_compare_page() {
	if ( function_exists( 'is_page' ) && is_page( 'compare' ) ) {
		return true;
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && ! empty( $post->post_name ) && $post->post_name === 'compare' ) {
			return true;
		}
	}
	$path = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$parsed = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $parsed ) ) {
			$path = trim( $parsed, '/' );
		}
	}
	return $path === 'compare';
}

/**
 * Canonical URL for /compare/.
 *
 * @return string
 */
function noaway_market_compare_page_url() {
	$page = get_page_by_path( 'compare', OBJECT, 'page' );
	if ( $page instanceof WP_Post && $page->post_status === 'publish' ) {
		$url = get_permalink( $page );
		if ( is_string( $url ) && $url !== '' ) {
			return function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( $url ) : $url;
		}
	}
	$url = home_url( '/compare/' );
	return function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( $url ) : $url;
}

/**
 * Ensure a published WordPress page exists at /compare/ using page-compare.php.
 */
function noaway_ensure_market_compare_page() {
	if ( ! function_exists( 'wp_insert_post' ) ) {
		return;
	}
	$page = get_page_by_path( 'compare', OBJECT, 'page' );
	if ( $page instanceof WP_Post ) {
		$needs = array( 'ID' => (int) $page->ID );
		$changed = false;
		if ( $page->post_status !== 'publish' ) {
			$needs['post_status'] = 'publish';
			$changed              = true;
		}
		if ( $page->post_name !== 'compare' ) {
			$needs['post_name'] = 'compare';
			$changed            = true;
		}
		if ( $changed ) {
			wp_update_post( $needs );
		}
		$tpl = get_post_meta( (int) $page->ID, '_wp_page_template', true );
		if ( $tpl !== 'page-compare.php' ) {
			update_post_meta( (int) $page->ID, '_wp_page_template', 'page-compare.php' );
		}
		return;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Compare',
			'post_name'    => 'compare',
			'post_content' => '',
			'post_parent'  => 0,
			'meta_input'   => array(
				'_wp_page_template' => 'page-compare.php',
			),
		),
		true
	);
	if ( ! is_wp_error( $id ) && $id ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'after_switch_theme', 'noaway_ensure_market_compare_page' );
add_action( 'admin_init', 'noaway_ensure_market_compare_page', 32 );

/**
 * SEO title/description for /compare/.
 *
 * @return array{title:string,description:string}
 */
function noaway_market_compare_seo() {
	return array(
		'title'       => 'NoAway vs Slack Green, NotAway, Idle Pilot: price comparison | NoAway',
		'description' => 'Compare NoAway (€4.99 one-time) with Slack Green, NotAway, Idle Pilot, and USB mouse jigglers. Prices checked on ' . NOAWAY_MARKET_COMPARE_CHECKED . '. Local desktop app vs cloud Slack tools.',
	);
}

/**
 * Price cards for the market comparison (display order).
 *
 * @return array<int, array<string, mixed>>
 */
function noaway_market_compare_cards() {
	$checkout = function_exists( 'noaway_checkout_url' ) ? noaway_checkout_url() : home_url( '/' );
	return array(
		array(
			'id'          => 'noaway',
			'name'        => 'NoAway',
			'highlight'   => true,
			'badge'       => 'Best value',
			'price'       => '€4.99 one-time',
			'price_note'  => 'Teams, Slack, Zoom · Mac & Windows · 7-day refund',
			'scope'       => '',
			'source_url'  => '',
			'source_label'=> '',
			'cta_url'     => $checkout,
			'cta_label'   => 'Buy',
		),
		array(
			'id'           => 'slack-green',
			'name'         => 'Slack Green',
			'highlight'    => false,
			'badge'        => '',
			'price'        => '$3.99/month or $23.99/year',
			'price_extra'  => 'Lifetime CLI $79 one-time',
			'price_note'   => 'Slack only',
			'scope'        => 'Slack only',
			'source_url'   => 'https://slack.green/en',
			'source_label' => 'slack.green',
			'cta_url'      => '',
			'cta_label'    => '',
		),
		array(
			'id'           => 'notaway',
			'name'         => 'NotAway',
			'highlight'    => false,
			'badge'        => '',
			'price'        => '$3.99/month or $29.99/year',
			'price_note'   => 'Slack only',
			'scope'        => 'Slack only',
			'source_url'   => 'https://notaway.app/',
			'source_label' => 'notaway.app',
			'cta_url'      => '',
			'cta_label'    => '',
		),
		array(
			'id'           => 'idle-pilot',
			'name'         => 'Idle Pilot',
			'highlight'    => false,
			'badge'        => '',
			'price'        => '€6/month or €40/year',
			'price_note'   => 'Freedom Pass · Slack or Microsoft Teams (one at a time)',
			'scope'        => 'Slack or Microsoft Teams (one at a time)',
			'source_url'   => 'https://idlepilot.com/pricing/',
			'source_label' => 'idlepilot.com',
			'cta_url'      => '',
			'cta_label'    => '',
		),
		array(
			'id'           => 'usb-jiggler',
			'name'         => 'Mouse jiggler USB',
			'highlight'    => false,
			'badge'        => '',
			'price'        => 'about €10–20',
			'price_note'   => 'Hardware · generic category, no specific brand',
			'scope'        => 'Hardware (generic)',
			'source_url'   => '',
			'source_label' => '',
			'cta_url'      => '',
			'cta_label'    => '',
		),
	);
}

/**
 * Two-year cost summary line (yearly plans where published).
 *
 * @return array<int, array{name:string,cost:string}>
 */
function noaway_market_compare_two_year_costs() {
	return array(
		array( 'name' => 'NoAway', 'cost' => '€4.99' ),
		array( 'name' => 'Slack Green', 'cost' => '$47.98 (yearly)' ),
		array( 'name' => 'NotAway', 'cost' => '$59.98 (yearly)' ),
		array( 'name' => 'Idle Pilot', 'cost' => '€80 (yearly)' ),
		array( 'name' => 'USB jiggler', 'cost' => '€10–20' ),
	);
}

/**
 * Detail table: first column is the feature label; then values in product order.
 * Price rows come first so the comparison is readable without separate cards.
 *
 * @return array{headers:array<int,string>,highlight_badge:string,rows:array<int,array{label:string,cells:array<int,string>,emphasize?:bool}>}
 */
function noaway_market_compare_table() {
	return array(
		'headers'         => array( 'NoAway', 'Slack Green', 'NotAway', 'Idle Pilot', 'Mouse jiggler USB' ),
		'highlight_badge' => 'Best value',
		'rows'            => array(
			array(
				'label'     => 'Price',
				'emphasize' => true,
				'cells'     => array(
					'€4.99 one-time',
					'$3.99/month or $23.99/year; Lifetime CLI $79 one-time',
					'$3.99/month or $29.99/year',
					'€6/month or €40/year (Freedom Pass; yearly saves 44%)',
					'about €10–20',
				),
			),
			array(
				'label'     => 'Cost over 2 years',
				'emphasize' => true,
				'cells'     => array(
					'€4.99',
					'$47.98 (yearly)',
					'$59.98 (yearly)',
					'€80 (yearly)',
					'€10–20',
				),
			),
			array(
				'label' => 'Type',
				'cells' => array(
					'Local desktop app',
					'Cloud (local CLI for Lifetime)',
					'Cloud',
					'Cloud',
					'USB device',
				),
			),
			array(
				'label' => 'Apps supported',
				'cells' => array(
					'Teams, Slack, Zoom and others',
					'Slack only',
					'Slack only',
					'Slack or Microsoft Teams (one at a time)',
					'Any',
				),
			),
			array(
				'label' => 'Slack session accessed from an external server',
				'cells' => array(
					'No',
					'Yes (cloud)',
					'Yes',
					'Yes',
					'No',
				),
			),
			array(
				'label' => 'Works with computer off',
				'cells' => array(
					'No',
					'Yes (cloud)',
					'Yes',
					'Yes',
					'No',
				),
			),
			array(
				'label' => 'Trial / guarantee',
				'cells' => array(
					'7-day refund',
					'14-day trial + 7-day refund',
					'7-day trial',
					'3-day free trial (7 days if you connect within 3 hours of sign-up)',
					'Depends on seller',
				),
			),
			array(
				'label' => 'License',
				'cells' => array(
					'1 device',
					'Up to 3 workspaces (monthly)',
					'Up to 7 workspaces',
					'One Slack workspace or one Teams account at a time',
					'—',
				),
			),
			array(
				'label' => 'Hardware to plug in',
				'cells' => array(
					'No',
					'No',
					'No',
					'No',
					'Yes',
				),
			),
		),
	);
}

/**
 * Source links shown under the comparison table.
 *
 * @return array<int, array{name:string,url:string,label:string}>
 */
function noaway_market_compare_sources() {
	return array(
		array( 'name' => 'NoAway', 'url' => home_url( '/' ), 'label' => 'noaway.app' ),
		array( 'name' => 'Slack Green', 'url' => 'https://slack.green/en', 'label' => 'slack.green' ),
		array( 'name' => 'NotAway', 'url' => 'https://notaway.app/', 'label' => 'notaway.app' ),
		array( 'name' => 'Idle Pilot', 'url' => 'https://idlepilot.com/pricing/', 'label' => 'idlepilot.com' ),
		array( 'name' => 'Mouse jiggler USB', 'url' => '', 'label' => 'typical retail range (no specific brand)' ),
	);
}

/**
 * Honest “choose if” blocks.
 *
 * @return array{choose_noaway:array{heading:string,points:array<int,string>},choose_cloud:array{heading:string,points:array<int,string>,note:string,note_url:string,note_label:string}}
 */
function noaway_market_compare_guidance() {
	return array(
		'choose_noaway' => array(
			'heading' => 'Choose NoAway if',
			'points'  => array(
				'You use Teams or Zoom as well as Slack',
				'Your computer stays on while you work',
				'You do not want to give your Slack session to an external service',
				'You prefer to pay once',
			),
		),
		'choose_cloud'  => array(
			'heading'    => 'A cloud tool may suit you better if',
			'points'     => array(
				'You need an active status with the computer off',
				'You are fine with a cloud service holding your Slack or Teams session',
			),
			'note'       => 'Cloud services use your Slack session from their server. Slack Green states that on paid Slack plans, admins can see that IP in the access logs.',
			'note_url'   => 'https://slack.green/en/blog/will-i-get-caught-using-slack-green',
			'note_label' => 'Slack Green: what admins see',
		),
	);
}
