<?php
/**
 * Footer: 4-column layout (brand, product, download, company).
 */
$checkout = noaway_checkout_url();
$tagline  = __( 'Stay active on Teams and Slack during long tasks, builds, and remote work.', 'noaway' );
?>
<footer class="border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 mt-auto">
	<style id="noaway-footer-critical">
		.noaway-footer-grid{display:grid;gap:2.5rem 2rem;grid-template-columns:1fr;align-items:start}
		@media(min-width:768px){.noaway-footer-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
		@media(min-width:1024px){.noaway-footer-grid{grid-template-columns:minmax(0,1.15fr) repeat(3,minmax(0,1fr));gap:3rem 2rem}}
		.noaway-footer-heading{margin:0 0 1rem;font-size:.75rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8}
		.noaway-footer-links{list-style:none;margin:0;padding:0}
		.noaway-footer-links li+li{margin-top:.75rem}
		.noaway-footer-links a{font-size:.875rem;font-weight:500;color:#334155;text-decoration:none}
		.noaway-footer-links a:hover{color:#5851ec}
		.dark .noaway-footer-heading{color:#64748b}
		.dark .noaway-footer-links a{color:#cbd5e1}
		.dark .noaway-footer-links a:hover{color:#a5b4fc}
	</style>
	<div class="max-w-7xl mx-auto px-6 py-12">
		<div class="noaway-footer-grid">
			<!-- Brand -->
			<div class="noaway-footer-col">
				<?php
				$args = array(
					'tagline'     => $tagline,
					'extra_class' => 'noaway-brand-mark--footer',
				);
				include get_template_directory() . '/template-parts/brand-mark.php';
				?>
			</div>

			<!-- Product -->
			<div class="noaway-footer-col">
				<p class="noaway-footer-heading"><?php esc_html_e( 'Product', 'noaway' ); ?></p>
				<ul class="noaway-footer-links" role="list">
					<li><a href="<?php echo esc_url( noaway_features_page_url() ); ?>"><?php esc_html_e( 'Features', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_how_it_works_page_url() ); ?>"><?php esc_html_e( 'How it works', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_is_noaway_safe_page_url() ); ?>"><?php esc_html_e( 'Is NoAway safe?', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>"><?php esc_html_e( 'FAQ', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_help_page_url() ); ?>"><?php esc_html_e( 'Help', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_releases_page_url() ); ?>"><?php esc_html_e( 'Releases', 'noaway' ); ?></a></li>
				</ul>
			</div>

			<!-- Download -->
			<div class="noaway-footer-col">
				<p class="noaway-footer-heading"><?php esc_html_e( 'Download', 'noaway' ); ?></p>
				<ul class="noaway-footer-links" role="list">
					<li><a href="<?php echo esc_url( noaway_downloads_page_url() ); ?>"><?php esc_html_e( 'macOS', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_downloads_page_url() ); ?>"><?php esc_html_e( 'Windows', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( $checkout ); ?>"<?php echo noaway_buy_cta_attrs( 'footer' ); ?>><?php
						echo esc_html( function_exists( 'noaway_i18n_buy_cta_label' ) ? noaway_i18n_buy_cta_label() : ( 'Buy NoAway – ' . noaway_price_label() ) );
					?></a></li>
				</ul>
			</div>

			<!-- Company -->
			<div class="noaway-footer-col">
				<p class="noaway-footer-heading"><?php esc_html_e( 'Company', 'noaway' ); ?></p>
				<ul class="noaway-footer-links" role="list">
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'noaway' ); ?></a></li>
					<li><a href="#" class="noaway-cookie-settings-link" data-cookie-settings><?php esc_html_e( 'Cookie Settings', 'noaway' ); ?></a></li>
					<li><a href="<?php echo esc_url( noaway_contact_page_url() ); ?>"><?php esc_html_e( 'Contact', 'noaway' ); ?></a></li>
				</ul>
			</div>
		</div>

		<p class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 text-center text-xs text-slate-400 max-w-4xl mx-auto">
			© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — <?php esc_html_e( 'VAT NUMBER 02045420490', 'noaway' ); ?>
		</p>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
