<?php
/**
 * Template Name: Keep Teams Active NoAway
 * Landing page: Never Go Away on Teams Again
 *
 * Localized variants set $noaway_landing_lang before including this file.
 */
if ( ! isset( $noaway_landing_lang ) || ! is_string( $noaway_landing_lang ) || $noaway_landing_lang === '' ) {
	$noaway_landing_lang = 'en';
}
$noaway_landing_lang = function_exists( 'noaway_i18n_normalize_lang' ) ? noaway_i18n_normalize_lang( $noaway_landing_lang ) : 'en';
$GLOBALS['noaway_landing_family'] = 'teams';
$GLOBALS['noaway_landing_lang']   = $noaway_landing_lang;
$t            = noaway_i18n_landing_copy( 'teams', $noaway_landing_lang );
$checkout_url = noaway_checkout_url();
get_header();
?>
<main>
  <?php noaway_i18n_render_locale_banner( 'teams', $noaway_landing_lang ); ?>
  <section class="relative overflow-hidden pt-12 pb-12 lg:pt-24 lg:pb-16 px-6 lg:px-20" data-noaway-hero>
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-10 lg:gap-12 items-start relative z-10">
      <div class="flex flex-col gap-6 lg:col-span-7 order-1">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
          </span>
          <span class="text-primary text-xs font-bold uppercase tracking-wider"><?php echo noaway_i18n_plain( $t['badge'] ); ?></span>
        </div>
        <div class="flex flex-col gap-4">
          <h1 class="na-h1">
            <?php echo noaway_i18n_plain( $t['h1'] ); ?>
          </h1>
          <?php noaway_i18n_language_switcher( 'teams', 'under-title' ); ?>
          <p class="na-lead max-w-xl">
            <?php echo noaway_i18n_plain( $t['lead'] ); ?>
          </p>
          <div class="mt-2 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 max-w-xl" role="complementary" aria-label="<?php echo esc_attr( $t['aria_brief'] ); ?>">
            <p class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2"><?php echo noaway_i18n_plain( $t['brief_label'] ); ?></p>
            <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
              <?php echo noaway_i18n_plain( $t['brief'] ); ?>
            </p>
            <?php noaway_render_last_reviewed( 'page-keep-teams-active.php' ); ?>
          </div>
        </div>
        <div class="flex flex-col gap-3 mt-2 w-full max-w-xl">
          <a href="<?php echo esc_url( $checkout_url ); ?>" class="na-btn-primary w-full sm:w-auto text-center" data-noaway-hero-buy<?php echo noaway_buy_cta_attrs( 'hero' ); ?>>
            <?php echo noaway_i18n_plain( $t['buy'] ); ?>
          </a>
          <?php noaway_render_mobile_email_link_box(); ?>
          <p class="text-sm text-slate-600 dark:text-slate-400 min-h-[44px] flex items-center"><?php echo noaway_refund_near_price_html( $noaway_landing_lang ); ?></p>
          <div class="flex flex-col gap-1 text-slate-600 dark:text-slate-400 text-sm">
            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check_circle</span> <?php echo noaway_i18n_plain( $t['onetime'] ); ?></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300"><?php echo noaway_i18n_plain( $t['stress'] ); ?></span>
          </div>
        </div>
      </div>
      <div class="relative lg:col-span-5 order-2 lg:sticky lg:top-28">
        <div class="absolute -inset-4 bg-primary/20 blur-3xl rounded-full opacity-30"></div>
        <div class="relative rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-4 shadow-2xl">
          <div class="aspect-video rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center relative group">
            <div class="absolute top-4 right-4 flex items-center gap-2 bg-white dark:bg-slate-900/80 backdrop-blur px-3 py-1.5 rounded-full border border-green-700/30">
              <div class="size-2 rounded-full bg-green-700 shadow-[0_0_8px_#15803d]"></div>
              <span class="text-[11px] font-semibold text-green-700 uppercase"><?php echo noaway_i18n_plain( $t['hero_status'] ); ?></span>
            </div>
            <?php
			noaway_picture(
				'landing-hero-section',
				$t['hero_alt'],
				array(
					'class'          => 'w-full h-full object-cover',
					'width'          => 1200,
					'height'         => 630,
					'fetchpriority'  => 'high',
					'widths'         => array( 600, 640, 960, 1200 ),
					'sizes'          => '(min-width: 1024px) 28rem, calc(100vw - 3rem)',
				)
			);
			?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="px-6 lg:px-20 pb-12">
    <div class="max-w-7xl mx-auto">
      <?php noaway_render_before_you_buy( $noaway_landing_lang, 'horizontal' ); ?>
    </div>
  </section>

  <section class="py-12 md:py-24 px-6 lg:px-20 bg-slate-50 dark:bg-slate-900/30" id="features">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col gap-4 mb-12 max-w-2xl">
        <h2 class="text-primary text-sm font-bold uppercase tracking-widest"><?php echo noaway_i18n_plain( $t['problem_kicker'] ); ?></h2>
        <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100"><?php echo noaway_i18n_plain( $t['problem_h'] ); ?></h3>
        <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['problem_p'] ); ?></p>
      </div>
      <div class="mb-16 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-xl aspect-[1408/768] bg-slate-100">
        <?php
		noaway_picture(
			'landing-problem-section',
			$t['problem_alt'],
			array(
				'class'   => 'w-full h-full object-cover',
				'width'   => 1200,
				'height'  => 655,
				'loading' => 'lazy',
				'widths'  => array( 600, 1200 ),
				'sizes'   => '(min-width: 1024px) 64rem, calc(100vw - 3rem)',
			)
		);
		?>
      </div>

      <div class="max-w-4xl mx-auto space-y-12 mb-16">
        <div>
          <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['why_h'] ); ?></h2>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_html( $t['why_p'] ); ?></p>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['detect_h'] ); ?></h2>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_html( $t['detect_p'] ); ?></p>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['tricks_h'] ); ?></h2>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_html( $t['tricks_p'] ); ?></p>
        </div>
        <div>
          <h2 id="keep-teams-icon-green" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['icon_h'] ); ?></h2>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4"><?php echo noaway_i18n_plain( $t['icon_p1'] ); ?></p>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_html( $t['icon_p2'] ); ?></p>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 hover:border-primary/40 transition-all group">
          <span class="material-symbols-outlined text-primary text-4xl mb-6 group-hover:scale-110 transition-transform">download_for_offline</span>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3"><?php echo noaway_i18n_plain( $t['card1_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_plain( $t['card1_p'] ); ?></p>
        </div>
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 hover:border-primary/40 transition-all group">
          <span class="material-symbols-outlined text-primary text-4xl mb-6 group-hover:scale-110 transition-transform">terminal</span>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3"><?php echo noaway_i18n_plain( $t['card2_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_plain( $t['card2_p'] ); ?></p>
        </div>
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 hover:border-primary/40 transition-all group">
          <span class="material-symbols-outlined text-primary text-4xl mb-6 group-hover:scale-110 transition-transform">menu_book</span>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3"><?php echo noaway_i18n_plain( $t['card3_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo noaway_i18n_plain( $t['card3_p'] ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-12 md:py-24 px-6 lg:px-20" id="solution">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-20 items-start">
      <div class="order-2 lg:order-1 relative">
        <div class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-2xl aspect-[1408/768] bg-slate-100">
          <?php
			noaway_picture(
				'landing-solution-section',
				$t['solution_alt'],
				array(
					'class'   => 'w-full h-full object-cover',
					'width'   => 1200,
					'height'  => 655,
					'loading' => 'lazy',
					'widths'  => array( 600, 1200 ),
					'sizes'   => '(min-width: 1024px) 28rem, calc(100vw - 3rem)',
				)
			);
			?>
        </div>
      </div>
      <div class="order-1 lg:order-2 flex flex-col gap-6">
        <h2 class="text-primary text-sm font-bold uppercase tracking-widest"><?php echo noaway_i18n_plain( $t['solution_kicker'] ); ?></h2>
        <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100 leading-tight"><?php echo noaway_i18n_plain( $t['solution_h'] ); ?></h3>
        <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
          <?php echo noaway_i18n_plain( $t['solution_p'] ); ?>
        </p>
        <ul class="flex flex-col gap-4 mt-4">
          <?php foreach ( $t['bullets'] as $bullet ) : ?>
          <li class="flex items-center gap-3">
            <div class="size-6 rounded-full bg-primary/10 flex items-center justify-center">
              <span class="material-symbols-outlined text-primary text-sm">check</span>
            </div>
            <span class="text-slate-700 dark:text-slate-300"><?php echo noaway_i18n_plain( $bullet ); ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-8">
          <?php noaway_render_controls_note( $noaway_landing_lang ); ?>
        </div>
      </div>
    </div>
  </section>

  <section class="py-12 md:py-24 px-6 lg:px-20 bg-slate-50 dark:bg-slate-900/30">
    <div class="max-w-3xl mx-auto text-center mb-16">
      <h3 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['steps_h'] ); ?></h3>
      <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['steps_p'] ); ?></p>
    </div>
    <div class="max-w-lg mx-auto relative">
      <div class="absolute left-6 top-0 bottom-0 w-px bg-slate-200 dark:bg-slate-700"></div>
      <div class="flex flex-col gap-16">
        <div class="relative pl-16">
          <div class="absolute left-3.5 -translate-x-1/2 flex items-center justify-center size-6 rounded-full bg-primary border-4 border-background-light dark:border-background-dark"></div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2"><?php echo noaway_i18n_plain( $t['step1_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['step1_p'] ); ?></p>
        </div>
        <div class="relative pl-16">
          <div class="absolute left-3.5 -translate-x-1/2 flex items-center justify-center size-6 rounded-full bg-primary border-4 border-background-light dark:border-background-dark"></div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2"><?php echo noaway_i18n_plain( $t['step2_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['step2_p'] ); ?></p>
        </div>
        <div class="relative pl-16">
          <div class="absolute left-3.5 -translate-x-1/2 flex items-center justify-center size-6 rounded-full bg-primary border-4 border-background-light dark:border-background-dark"></div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-2"><?php echo noaway_i18n_plain( $t['step3_h'] ); ?></h4>
          <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['step3_p'] ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-12 md:py-24 px-6 lg:px-20" id="faq">
    <?php
    $faq_schema = array(
      '@context'   => 'https://schema.org',
      '@type'      => 'FAQPage',
      'mainEntity' => array(),
    );
    if ( $noaway_landing_lang !== 'en' ) {
      $faq_schema['inLanguage'] = noaway_i18n_bcp47( $noaway_landing_lang );
    }
    foreach ( $t['faqs'] as $faq ) {
      $faq_schema['mainEntity'][] = array(
        '@type'          => 'Question',
        'name'           => $faq['name'],
        'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['text'] ),
      );
    }
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
    <div class="max-w-4xl mx-auto">
      <h3 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-12 text-center"><?php echo noaway_i18n_plain( $t['faq_h'] ); ?></h3>
      <div class="space-y-4">
        <?php foreach ( $t['faqs'] as $faq ) : ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/40 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400 border-t-0">
            <p class="text-sm leading-relaxed"><?php echo esc_html( $faq['text'] ); ?></p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
      <p class="mt-8 text-center text-slate-600 text-sm">
        <?php echo noaway_i18n_html( $t['faq_more'] ); ?>
      </p>
    </div>
  </section>

  <?php
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'title'        => $t['cta_h'],
      'subtitle'     => $t['cta_p'],
      'lines'        => array(
        '<span class="font-semibold">' . esc_html( $t['stress'] ) . '</span>',
        esc_html( $t['perk_updates'] ) . ' · ' . esc_html( $t['perk_purchase'] ) . ' · ' . esc_html( $t['perk_devices'] ),
      ),
      'button_url'   => $checkout_url,
      'button_label' => $t['buy'],
      'cta_position' => 'footer-cta',
    )
  );
  ?>
</main>
<?php
if ( function_exists( 'noaway_render_sticky_buy_bar' ) ) {
	noaway_render_sticky_buy_bar( array( 'label' => isset( $t['buy'] ) ? $t['buy'] : ( 'Buy NoAway – ' . noaway_price_label() ), 'url' => isset( $checkout_url ) ? $checkout_url : '' ) );
}
get_footer();
