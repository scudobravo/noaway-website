<?php
/**
 * NoAway Theme - Analytics helpers + Consent Mode v2 defaults.
 *
 * Measurement ID default: G-PNZRGD4233
 * Per usare un altro ID: in wp-config.php definisci NOAWAY_GA_MEASUREMENT_ID.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a validated GA4 measurement ID or an empty string.
 */
function noaway_get_ga_measurement_id() {
	$ga_id = defined( 'NOAWAY_GA_MEASUREMENT_ID' ) ? NOAWAY_GA_MEASUREMENT_ID : 'G-PNZRGD4233';
	$ga_id = is_string( $ga_id ) ? trim( $ga_id ) : '';

	if ( $ga_id === '' || ! preg_match( '/^G-[A-Z0-9]+$/i', $ga_id ) ) {
		return '';
	}

	return $ga_id;
}

/**
 * Consent Mode v2 defaults must be set before any optional tracking.
 */
function noaway_print_consent_mode_defaults() {
	?>
	<script>
		window.dataLayer = window.dataLayer || [];
		window.gtag = window.gtag || function(){window.dataLayer.push(arguments);};
		gtag('consent', 'default', {
			ad_storage: 'denied',
			ad_user_data: 'denied',
			ad_personalization: 'denied',
			analytics_storage: 'denied'
		});
	</script>
	<?php
}
add_action( 'wp_head', 'noaway_print_consent_mode_defaults', 1 );
