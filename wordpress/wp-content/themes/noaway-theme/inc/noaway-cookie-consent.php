<?php
/**
 * NoAway Theme - Cookie consent banner + preferences modal (GDPR style).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue cookie consent assets and pass runtime configuration.
 */
function noaway_cookie_consent_enqueue_assets() {
	$css_rel_path = '/assets/css/noaway-cookie-consent.css';
	$js_rel_path  = '/assets/js/noaway-cookie-consent.js';
	$css_abs_path = get_template_directory() . $css_rel_path;
	$js_abs_path  = get_template_directory() . $js_rel_path;

	$css_ver = file_exists( $css_abs_path ) ? (string) filemtime( $css_abs_path ) : '1.0.0';
	$js_ver  = file_exists( $js_abs_path ) ? (string) filemtime( $js_abs_path ) : '1.0.0';

	wp_enqueue_style(
		'noaway-cookie-consent',
		get_template_directory_uri() . $css_rel_path,
		array(),
		$css_ver
	);

	wp_enqueue_script(
		'noaway-cookie-consent',
		get_template_directory_uri() . $js_rel_path,
		array(),
		$js_ver,
		true
	);

	wp_localize_script(
		'noaway-cookie-consent',
		'NoAwayCookieConsentConfig',
		array(
			'gaMeasurementId' => noaway_get_ga_measurement_id(),
			'privacyPolicyUrl' => esc_url( home_url( '/privacy-policy/' ) ),
			'storageKey'      => 'noawayCookieConsentV1',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'noaway_cookie_consent_enqueue_assets', 30 );

/**
 * Print global banner + modal markup near the end of body.
 */
function noaway_cookie_consent_render_markup() {
	$ui = function_exists( 'noaway_i18n_ui' );
	?>
	<div class="noaway-cookie-consent" data-noaway-cookie-consent>
		<div class="noaway-cookie-consent__banner" data-consent-banner role="region" aria-label="<?php echo esc_attr( $ui ? noaway_i18n_ui( 'cookie_banner_aria' ) : 'Cookie consent banner' ); ?>" aria-live="polite" hidden>
			<div class="noaway-cookie-consent__content">
				<h2 class="noaway-cookie-consent__title"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_title' ) : 'Privacy Preferences' ); ?></h2>
				<p class="noaway-cookie-consent__text">
					<?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_text' ) : 'We use strictly necessary cookies to make this website work. With your consent, we also use analytics cookies to understand how visitors use the site and improve performance. You can accept all, reject non-essential cookies, or manage your preferences.' ); ?>
				</p>
				<p class="noaway-cookie-consent__policy">
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_policy_link' ) : 'Learn more in our Privacy Policy' ); ?></a>
				</p>
			</div>
			<div class="noaway-cookie-consent__actions">
				<button type="button" class="noaway-cc-btn noaway-cc-btn--primary" data-consent-action="accept-all"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_accept_all' ) : 'Accept All' ); ?></button>
				<button type="button" class="noaway-cc-btn noaway-cc-btn--secondary" data-consent-action="reject-all"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_reject' ) : 'Reject Non-Essential' ); ?></button>
				<button type="button" class="noaway-cc-btn noaway-cc-btn--ghost" data-consent-action="open-preferences"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_manage' ) : 'Manage Preferences' ); ?></button>
			</div>
		</div>

		<div class="noaway-cookie-consent__overlay" data-consent-modal hidden>
			<div class="noaway-cookie-consent__dialog" role="dialog" aria-modal="true" aria-labelledby="noaway-cookie-preferences-title" aria-describedby="noaway-cookie-preferences-intro">
				<button type="button" class="noaway-cookie-consent__close" data-consent-action="close-preferences" aria-label="<?php echo esc_attr( $ui ? noaway_i18n_ui( 'cookie_close' ) : 'Close cookie preferences' ); ?>">×</button>
				<h2 id="noaway-cookie-preferences-title" class="noaway-cookie-consent__title noaway-cookie-consent__title--modal"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_prefs_title' ) : 'Cookie Preferences' ); ?></h2>
				<p id="noaway-cookie-preferences-intro" class="noaway-cookie-consent__text noaway-cookie-consent__text--modal">
					<?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_prefs_intro' ) : 'You can choose which optional cookies to allow. Strictly necessary cookies are always enabled because they are required for the website to function properly.' ); ?>
				</p>

				<div class="noaway-cookie-consent__category">
					<div class="noaway-cookie-consent__category-header">
						<h3><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_necessary_h' ) : 'Strictly Necessary Cookies' ); ?></h3>
						<span class="noaway-cookie-consent__badge" aria-label="<?php echo esc_attr( $ui ? noaway_i18n_ui( 'cookie_necessary_badge' ) : 'Always active' ); ?>"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_necessary_badge' ) : 'Always Active' ); ?></span>
					</div>
					<p><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_necessary_p' ) : 'These cookies are essential for the website to function properly and cannot be disabled.' ); ?></p>
				</div>

				<div class="noaway-cookie-consent__category">
					<div class="noaway-cookie-consent__category-header">
						<h3><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_analytics_h' ) : 'Analytics Cookies' ); ?></h3>
						<label class="noaway-cookie-consent__switch">
							<input type="checkbox" data-consent-analytics aria-label="<?php echo esc_attr( $ui ? noaway_i18n_ui( 'cookie_analytics_aria' ) : 'Enable analytics cookies' ); ?>">
							<span class="noaway-cookie-consent__slider" aria-hidden="true"></span>
						</label>
					</div>
					<p><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_analytics_p' ) : 'These cookies help us understand how visitors interact with the website so we can improve performance and usability.' ); ?></p>
				</div>

				<div class="noaway-cookie-consent__modal-actions">
					<button type="button" class="noaway-cc-btn noaway-cc-btn--secondary" data-consent-action="reject-optional"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_reject_optional' ) : 'Reject Optional Cookies' ); ?></button>
					<button type="button" class="noaway-cc-btn noaway-cc-btn--ghost" data-consent-action="save-preferences"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_save' ) : 'Save Preferences' ); ?></button>
					<button type="button" class="noaway-cc-btn noaway-cc-btn--primary" data-consent-action="accept-all"><?php echo esc_html( $ui ? noaway_i18n_ui( 'cookie_accept_all' ) : 'Accept All' ); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'noaway_cookie_consent_render_markup', 5 );
