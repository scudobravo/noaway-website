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
  <section class="relative overflow-hidden pt-16 pb-24 lg:pt-32 lg:pb-40 px-6 lg:px-20">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10">
      <div class="flex flex-col gap-8">
        <?php noaway_i18n_language_switcher( 'teams', 'header' ); ?>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
          </span>
          <span class="text-primary text-xs font-bold uppercase tracking-wider"><?php echo noaway_i18n_plain( $t['badge'] ); ?></span>
        </div>
        <div class="flex flex-col gap-4">
          <h1 class="text-5xl lg:text-7xl font-black leading-[1.1] tracking-tight text-slate-900 dark:text-slate-100">
            <?php echo noaway_i18n_plain( $t['h1'] ); ?>
          </h1>
          <?php noaway_i18n_language_switcher( 'teams', 'under-title' ); ?>
          <p class="text-lg lg:text-xl text-slate-600 dark:text-slate-400 max-w-xl leading-relaxed">
            <?php echo noaway_i18n_plain( $t['lead'] ); ?>
          </p>
          <div class="mt-2 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 max-w-xl" role="complementary" aria-label="<?php echo esc_attr( $t['aria_brief'] ); ?>">
            <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><?php echo noaway_i18n_plain( $t['brief_label'] ); ?></p>
            <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
              <?php echo noaway_i18n_plain( $t['brief'] ); ?>
            </p>
          </div>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-4 mt-4 w-full max-w-xl">
          <div class="w-full sm:w-auto flex flex-col gap-3">
            <?php noaway_render_mobile_email_link_box(); ?>
            <a href="<?php echo esc_url( $checkout_url ); ?>" class="w-full sm:w-auto text-center bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all"<?php echo noaway_buy_cta_attrs( 'hero' ); ?>>
              <?php echo noaway_i18n_plain( $t['buy'] ); ?>
            </a>
            <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo noaway_refund_near_price_html( $noaway_landing_lang ); ?></p>
            <?php noaway_render_before_you_buy( $noaway_landing_lang ); ?>
          </div>
          <div class="flex flex-col gap-1 text-slate-600 dark:text-slate-400 text-sm">
            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-primary">check_circle</span> <?php echo noaway_i18n_plain( $t['onetime'] ); ?></span>
            <span class="font-semibold text-slate-700 dark:text-slate-300"><?php echo noaway_i18n_plain( $t['stress'] ); ?></span>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="absolute -inset-4 bg-primary/20 blur-3xl rounded-full opacity-30"></div>
        <div class="relative rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-4 shadow-2xl">
          <div class="aspect-video rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center relative group">
            <div class="absolute top-4 right-4 flex items-center gap-2 bg-white/80 dark:bg-slate-900/80 backdrop-blur px-3 py-1.5 rounded-full border border-green-500/30">
              <div class="size-2 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e]"></div>
              <span class="text-[10px] font-bold text-green-500 uppercase"><?php echo noaway_i18n_plain( $t['hero_status'] ); ?></span>
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
					'widths'         => array( 640, 960, 1200 ),
					'sizes'          => '(min-width: 1024px) 36rem, calc(100vw - 3rem)',
				)
			);
			?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-24 px-6 lg:px-20 bg-slate-50 dark:bg-slate-900/30" id="features">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-col gap-4 mb-12 max-w-2xl">
        <h2 class="text-primary text-sm font-bold uppercase tracking-widest"><?php echo noaway_i18n_plain( $t['problem_kicker'] ); ?></h2>
        <h3 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100"><?php echo noaway_i18n_plain( $t['problem_h'] ); ?></h3>
        <p class="text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['problem_p'] ); ?></p>
      </div>
      <div class="mb-16 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-xl">
        <?php
		noaway_picture(
			'landing-problem-section',
			$t['problem_alt'],
			array(
				'class'   => 'w-full h-auto object-cover',
				'width'   => 1200,
				'height'  => 630,
				'loading' => 'lazy',
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

  <section class="py-24 px-6 lg:px-20" id="solution">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-20 items-center">
      <div class="order-2 lg:order-1 relative">
        <div class="rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-2xl">
          <?php
			noaway_picture(
				'landing-solution-section',
				$t['solution_alt'],
				array(
					'class'   => 'w-full h-auto object-cover',
					'width'   => 1200,
					'height'  => 630,
					'loading' => 'lazy',
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

  <section class="py-24 px-6 lg:px-20 bg-slate-50 dark:bg-slate-900/30">
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

  <section class="py-24 px-6 lg:px-20" id="faq">
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
      <p class="mt-8 text-center text-slate-500 text-sm">
        <?php echo noaway_i18n_html( $t['faq_more'] ); ?>
      </p>
    </div>
  </section>

  <section class="py-20 px-6 lg:px-20">
    <div class="max-w-7xl mx-auto rounded-[2rem] bg-gradient-to-br from-primary via-primary/90 to-slate-900 dark:to-background-dark p-1 shadow-2xl overflow-hidden">
      <div class="bg-white dark:bg-slate-900 rounded-[1.9rem] px-8 py-20 lg:py-32 flex flex-col items-center text-center gap-8">
        <h2 class="text-4xl lg:text-6xl font-black text-slate-900 dark:text-slate-100 tracking-tight"><?php echo noaway_i18n_plain( $t['cta_h'] ); ?></h2>
        <p class="text-slate-600 dark:text-slate-400 text-lg max-w-xl"><?php echo noaway_i18n_plain( $t['cta_p'] ); ?></p>
        <div class="flex flex-col gap-6 items-center">
          <a href="<?php echo esc_url( $checkout_url ); ?>" class="bg-primary text-white px-12 py-5 rounded-2xl text-xl font-black hover:scale-105 transition-all shadow-xl shadow-primary/20"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
            <?php echo noaway_i18n_plain( $t['buy'] ); ?>
          </a>
          <p class="text-slate-600 dark:text-slate-400 font-semibold"><?php echo noaway_i18n_plain( $t['stress'] ); ?></p>
          <div class="flex flex-wrap justify-center gap-8">
            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400 text-sm">
              <span class="material-symbols-outlined text-primary">update</span>
              <?php echo noaway_i18n_plain( $t['perk_updates'] ); ?>
            </div>
            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400 text-sm">
              <span class="material-symbols-outlined text-primary">payments</span>
              <?php echo noaway_i18n_plain( $t['perk_purchase'] ); ?>
            </div>
            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400 text-sm">
              <span class="material-symbols-outlined text-primary">devices</span>
              <?php echo noaway_i18n_plain( $t['perk_devices'] ); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
