<?php
/**
 * Template Name: Compare NoAway
 *
 * - Slug /compare/ → market price comparison (template-parts/comparison-market.php).
 * - Slugs noaway-vs-* → one-to-one landings from inc/noaway-comparisons.php
 *   (template-parts/comparison-vs.php).
 */
if ( function_exists( 'noaway_is_market_compare_page' ) && noaway_is_market_compare_page() ) {
	require get_template_directory() . '/template-parts/comparison-market.php';
} else {
	require get_template_directory() . '/template-parts/comparison-vs.php';
}
