<?php
/**
 * Logo + NoAway wordmark (No / Away colors). Optional tagline (e.g. footer).
 *
 * @package NoAway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * get_template_part( ..., $args ) uses load_template() → extract( $args ).
 * Variables become $tagline, $extra_class — $args is not always set as an array here.
 * include() from header/footer passes a real $args array — merge both.
 */
$p = isset( $args ) && is_array( $args ) ? $args : array();
if ( isset( $tagline ) ) {
	$p['tagline'] = (string) $tagline;
}
if ( isset( $extra_class ) ) {
	$p['extra_class'] = (string) $extra_class;
}
$p = wp_parse_args(
	$p,
	array(
		'tagline'     => '',
		'extra_class' => '',
	)
);
$tagline     = (string) $p['tagline'];
$extra_class = (string) $p['extra_class'];
?>
<div class="noaway-brand-mark <?php echo esc_attr( trim( $extra_class ) ); ?>">
	<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
		<div class="noaway-site-logo">
			<?php the_custom_logo(); ?>
		</div>
	<?php else : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="noaway-header-logo-link flex items-center gap-2 shrink-0" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>"
				width="36"
				height="36"
				alt=""
				class="noaway-header-logo-img shrink-0"
				decoding="async"
				aria-hidden="true"
			/>
			<span class="font-logo font-extrabold text-xl tracking-tight">
				<span class="text-slate-900 dark:text-white">No</span><span class="text-primary">Away</span>
			</span>
		</a>
	<?php endif; ?>
	<?php if ( $tagline !== '' ) : ?>
		<p class="noaway-brand-tagline mt-3 text-sm leading-relaxed text-slate-500 dark:text-slate-400 max-w-xs">
			<?php echo esc_html( $tagline ); ?>
		</p>
	<?php endif; ?>
</div>
