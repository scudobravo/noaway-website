<?php
/**
 * NoAway theme — shared UI helpers (guide TOC, mobile sticky buy bar).
 *
 * @package NoAway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extract TOC entries from rendered guide HTML (every <h2 id="...">).
 * Labels come from the headings themselves, so no copy is duplicated.
 *
 * @param string $html Rendered body HTML.
 * @return array<int,array{id:string,label:string}>
 */
function noaway_guide_toc_items_from_html( $html ) {
	$items = array();
	if ( ! is_string( $html ) || $html === '' ) {
		return $items;
	}
	if ( ! preg_match_all( '#<h2\b[^>]*\bid="([^"]+)"[^>]*>(.*?)</h2>#is', $html, $m, PREG_SET_ORDER ) ) {
		return $items;
	}
	foreach ( $m as $row ) {
		$label = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $row[2] ) ) );
		if ( $label === '' ) {
			continue;
		}
		$items[] = array(
			'id'    => $row[1],
			'label' => html_entity_decode( $label, ENT_QUOTES, 'UTF-8' ),
		);
	}
	return $items;
}

/**
 * Render the guide body + sticky TOC / mini buy card layout.
 *
 * @param string               $body_html Already-escaped body markup.
 * @param array<string,mixed>  $args      buy_url, buy_label, tracked (bool), position.
 */
function noaway_render_guide_layout( $body_html, $args = array() ) {
	$args = is_array( $args ) ? $args : array();
	$args['body_html'] = (string) $body_html;
	get_template_part( 'template-parts/guide-toc', null, $args );
}

/**
 * Mobile-only sticky Buy bar. Same label + URL as the page's hero buy button;
 * checkout URLs get a "-sticky" ref suffix for attribution.
 *
 * @param array{label:string,url?:string,lang?:string} $args
 */
function noaway_render_sticky_buy_bar( $args = array() ) {
	$args  = is_array( $args ) ? $args : array();
	$label = isset( $args['label'] ) ? (string) $args['label'] : '';
	if ( $label === '' ) {
		return;
	}
	$tracked = true;
	if ( isset( $args['url'] ) && is_string( $args['url'] ) && $args['url'] !== '' ) {
		$url = $args['url'];
		if ( isset( $args['tracked'] ) ) {
			$tracked = (bool) $args['tracked'];
		} else {
			$tracked = false !== strpos( $url, 'create-checkout-session' ) || ( defined( 'NOAWAY_STRIPE_CHECKOUT_URL' ) && 0 === strpos( $url, NOAWAY_STRIPE_CHECKOUT_URL ) );
		}
	} else {
		$url = noaway_checkout_url();
	}
	if ( $tracked ) {
		$url = noaway_checkout_url( array( 'ref' => noaway_current_landing_slug() . '-sticky' ) );
	}
	wp_enqueue_script( 'noaway-sticky-buy' );
	?>
	<div class="noaway-sticky-buy" data-noaway-sticky-buy aria-hidden="true">
		<a href="<?php echo esc_url( $url ); ?>" class="na-btn-primary noaway-sticky-buy__btn text-base"<?php echo $tracked ? noaway_buy_cta_attrs( 'sticky' ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $label ); ?></a>
	</div>
	<?php
}

/**
 * Capture a "Before you buy" horizontal block as a string (for cta-final / wrappers).
 *
 * @param string $lang Language code.
 * @return string
 */
function noaway_capture_before_you_buy( $lang = 'en', $variant = 'horizontal' ) {
	ob_start();
	noaway_render_before_you_buy( $lang, $variant );
	return (string) ob_get_clean();
}

/**
 * Capture the mobile "email me the link" box (on primary background).
 *
 * @param bool $on_primary Style for use on the primary-colour CTA card.
 * @return string
 */
function noaway_capture_mobile_email_box( $on_primary = true ) {
	if ( ! function_exists( 'noaway_render_mobile_email_link_box' ) ) {
		return '';
	}
	ob_start();
	echo '<div class="max-w-md mx-auto mt-4 text-left md:hidden">';
	noaway_render_mobile_email_link_box( array( 'on_primary' => (bool) $on_primary ) );
	echo '</div>';
	return (string) ob_get_clean();
}

/**
 * Landing copy with i18n tokens resolved but NOT escaped (for components that escape themselves).
 *
 * @param string $text Copy with tokens.
 * @return string
 */
function noaway_i18n_raw( $text ) {
	if ( function_exists( 'noaway_i18n_tokens' ) ) {
		return strtr( (string) $text, noaway_i18n_tokens() );
	}
	return (string) $text;
}
