<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased min-h-screen' ); ?>>
<?php wp_body_open(); ?>
<header class="sticky top-0 z-50 border-b border-slate-200/80 dark:border-slate-800 bg-white/90 dark:bg-slate-950/90 backdrop-blur-md noaway-site-header" data-noaway-header>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 h-16 md:h-20 noaway-header-inner">
		<div class="shrink-0">
			<?php
			$args = array( 'extra_class' => 'noaway-brand-mark--header' );
			include get_template_directory() . '/template-parts/brand-mark.php';
			?>
		</div>
		<button
			type="button"
			class="noaway-menu-toggle"
			data-noaway-menu-toggle
			aria-expanded="false"
			aria-controls="noaway-mobile-menu"
			aria-label="<?php esc_attr_e( 'Toggle menu', 'noaway' ); ?>"
		>
			<span class="noaway-menu-toggle__line"></span>
			<span class="noaway-menu-toggle__line"></span>
			<span class="noaway-menu-toggle__line"></span>
		</button>
		<div class="noaway-header-links" id="noaway-mobile-menu">
			<nav class="noaway-primary-nav text-sm font-semibold text-slate-600 dark:text-slate-300" aria-label="Primary">
				<a href="<?php echo esc_url( noaway_features_page_url() ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Features', 'noaway' ); ?></a>
				<a href="<?php echo esc_url( noaway_how_it_works_page_url() ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'How it works', 'noaway' ); ?></a>
				<a href="<?php echo esc_url( noaway_downloads_page_url() ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Download', 'noaway' ); ?></a>
				<a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'FAQ', 'noaway' ); ?></a>
				<a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Help', 'noaway' ); ?></a>
			</nav>
			<div class="noaway-header-cta">
				<a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-primary"><?php esc_html_e( 'Contact', 'noaway' ); ?></a>
				<a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-bold tracking-wide text-white shadow-sm hover:opacity-95 transition-opacity"<?php echo noaway_buy_cta_attrs( 'header' ); ?>><?php
					printf(
						/* translators: %s: launch price, e.g. €4.99. */
						esc_html__( 'Buy NoAway – %s', 'noaway' ),
						esc_html( noaway_price_label() )
					);
				?></a>
			</div>
		</div>
	</div>
</header>
<div class="sticky top-16 md:top-20 z-40 w-full text-center py-2 px-3 sm:px-4 text-xs sm:text-sm font-bold tracking-wide shadow-sm" style="background-color:#ff5a00;color:#ffffff;">
	<?php
	echo esc_html(
		sprintf(
			/* translators: 1: launch price, 2: regular price. */
			__( 'Launch price %1$s · one-time, no subscription · regular price %2$s soon', 'noaway' ),
			noaway_price_label(),
			noaway_regular_price_label()
		)
	);
	?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const header = document.querySelector('[data-noaway-header]');
	const toggle = header ? header.querySelector('[data-noaway-menu-toggle]') : null;
	const menu = header ? header.querySelector('#noaway-mobile-menu') : null;

	if (!header || !toggle || !menu) {
		return;
	}

	const closeMenu = function () {
		header.classList.remove('is-open');
		toggle.setAttribute('aria-expanded', 'false');
	};

	toggle.addEventListener('click', function () {
		const isOpen = header.classList.toggle('is-open');
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});

	menu.querySelectorAll('a').forEach(function (link) {
		link.addEventListener('click', closeMenu);
	});

	window.addEventListener('resize', function () {
		if (window.innerWidth >= 768) {
			closeMenu();
		}
	});
});
</script>
