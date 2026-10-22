<?php
/**
 * Guide layout shell: article body column + sticky TOC / mini buy card (lg+).
 * TOC entries are generated from the body's <h2 id="..."> headings (no new copy).
 *
 * @package NoAway
 *
 * @var array{
 *   body_html?:string,
 *   buy_url?:string,
 *   buy_label?:string,
 *   tracked?:bool,
 *   position?:string
 * } $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args       = ( isset( $args ) && is_array( $args ) ) ? $args : array();
$body_html  = isset( $args['body_html'] ) ? (string) $args['body_html'] : '';
$buy_url    = isset( $args['buy_url'] ) ? (string) $args['buy_url'] : '';
$buy_label  = isset( $args['buy_label'] ) ? (string) $args['buy_label'] : '';
$tracked    = ! empty( $args['tracked'] );
$position   = isset( $args['position'] ) ? (string) $args['position'] : 'guide-toc';
$toc_items  = function_exists( 'noaway_guide_toc_items_from_html' ) ? noaway_guide_toc_items_from_html( $body_html ) : array();

wp_enqueue_script( 'noaway-guide-toc' );
?>
<div class="grid grid-cols-1 lg:grid-cols-[minmax(0,720px)_260px] gap-10 lg:gap-16 lg:justify-center items-start">
	<div class="min-w-0 na-guide-body">
		<?php echo $body_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped template output. ?>
	</div>
	<aside class="hidden lg:block lg:sticky lg:top-28 self-start">
		<?php if ( $toc_items ) : ?>
		<?php // TODO(Andrea): visible "On this page" heading for the TOC (aria-label only for now). ?>
		<nav class="mb-6" aria-label="Table of contents" data-noaway-guide-toc>
			<ul class="list-none m-0 p-0 flex flex-col gap-0.5">
				<?php foreach ( $toc_items as $item ) : ?>
				<li><a href="#<?php echo esc_attr( $item['id'] ); ?>" class="na-toc-link"><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php endif; ?>
		<?php if ( $buy_label !== '' && $buy_url !== '' ) : ?>
		<div class="na-card p-4">
			<a href="<?php echo esc_url( $buy_url ); ?>" class="na-btn-primary w-full text-center text-sm"<?php echo $tracked ? noaway_buy_cta_attrs( $position ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $buy_label ); ?></a>
		</div>
		<?php endif; ?>
	</aside>
</div>
