<?php
/**
 * Shared final CTA card (primary background).
 *
 * @package NoAway
 *
 * @var array{
 *   title?:string,
 *   subtitle?:string,
 *   lines?:array<int,string>,
 *   button_url?:string,
 *   button_label?:string,
 *   meta?:string,
 *   secondary_html?:string,
 *   section_id?:string,
 *   cta_position?:string,  (use 'none' for non-checkout links: no buy tracking attrs)
 *   before_button_html?:string
 * } $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = ( isset( $args ) && is_array( $args ) ) ? $args : array();

$title         = isset( $args['title'] ) ? (string) $args['title'] : '';
$subtitle      = isset( $args['subtitle'] ) ? (string) $args['subtitle'] : '';
$lines         = ( ! empty( $args['lines'] ) && is_array( $args['lines'] ) ) ? $args['lines'] : array();
$button_url    = isset( $args['button_url'] ) ? (string) $args['button_url'] : ( function_exists( 'noaway_checkout_url' ) ? noaway_checkout_url() : '#' );
$button_label  = isset( $args['button_label'] ) ? (string) $args['button_label'] : '';
$meta          = isset( $args['meta'] ) ? (string) $args['meta'] : '';
$secondary     = isset( $args['secondary_html'] ) ? (string) $args['secondary_html'] : '';
$section_id    = isset( $args['section_id'] ) ? (string) $args['section_id'] : 'download';
$cta_position  = isset( $args['cta_position'] ) ? (string) $args['cta_position'] : 'footer-cta';
$before_button = isset( $args['before_button_html'] ) ? (string) $args['before_button_html'] : '';
$allow_html_title = ! empty( $args['title_allow_html'] );
?>
<section class="py-12 md:py-24 px-6" id="<?php echo esc_attr( $section_id ); ?>" data-noaway-final-cta>
	<div class="max-w-5xl mx-auto">
		<div class="bg-primary rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden shadow-2xl shadow-primary/40">
			<div class="relative z-10">
				<?php if ( $title !== '' ) : ?>
					<h2 class="text-3xl md:text-5xl font-black mb-6"><?php echo $allow_html_title ? wp_kses_post( $title ) : esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $subtitle !== '' ) : ?>
					<p class="text-lg md:text-xl text-white/80 mb-4 max-w-2xl mx-auto"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<?php foreach ( $lines as $line ) : ?>
					<?php if ( is_string( $line ) && $line !== '' ) : ?>
						<p class="text-white/90 mb-2"><?php echo wp_kses_post( $line ); ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php
				if ( $before_button !== '' ) {
					echo $before_button; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- caller-escaped HTML.
				}
				?>
				<?php if ( $button_label !== '' ) : ?>
					<div class="flex flex-col items-center gap-4 mt-6 mb-4">
						<a href="<?php echo esc_url( $button_url ); ?>" class="na-btn-on-primary px-10 text-lg"<?php echo ( 'none' !== $cta_position && function_exists( 'noaway_buy_cta_attrs' ) ) ? noaway_buy_cta_attrs( $cta_position ) : ''; ?>><?php echo esc_html( $button_label ); ?></a>
						<?php if ( $meta !== '' ) : ?>
							<p class="text-white/80 text-sm"><?php echo esc_html( $meta ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<?php
				if ( $secondary !== '' ) {
					echo '<div class="mt-4 text-sm text-white/80">' . $secondary . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
	</div>
</section>
