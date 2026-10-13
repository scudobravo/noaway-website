<?php
/**
 * Template Name: Keep Slack Active SEO
 * SEO page: Keep Slack Active – Prevent Slack away status
 *
 * Localized variants set $noaway_landing_lang before including this file.
 */
if ( ! isset( $noaway_landing_lang ) || ! is_string( $noaway_landing_lang ) || $noaway_landing_lang === '' ) {
	$noaway_landing_lang = 'en';
}
$noaway_landing_lang = function_exists( 'noaway_i18n_normalize_lang' ) ? noaway_i18n_normalize_lang( $noaway_landing_lang ) : 'en';
$GLOBALS['noaway_landing_family'] = 'slack';
$GLOBALS['noaway_landing_lang']   = $noaway_landing_lang;
$t = noaway_i18n_landing_copy( 'slack', $noaway_landing_lang );
get_header();
?>
<main>
  <?php noaway_i18n_render_locale_banner( 'slack', $noaway_landing_lang ); ?>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <?php noaway_i18n_language_switcher( 'slack', 'header' ); ?>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider"><?php echo noaway_i18n_plain( $t['badge'] ); ?></span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-2">
        <?php echo noaway_i18n_plain( $t['h1'] ); ?>
      </h1>
      <?php noaway_i18n_language_switcher( 'slack', 'under-title' ); ?>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        <?php echo noaway_i18n_plain( $t['lead'] ); ?>
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="<?php echo esc_attr( $t['aria_brief'] ); ?>">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><?php echo noaway_i18n_plain( $t['brief_label'] ); ?></p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          <?php echo noaway_i18n_html( $t['brief'] ); ?>
        </p>
        <?php noaway_render_last_reviewed( 'page-keep-slack-active.php' ); ?>
      </div>
    </header>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['problem_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_plain( $t['problem_p'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="why-heading">
      <h2 id="why-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['why_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_plain( $t['why_p'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="how-long-heading">
      <h2 id="how-long-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['how_long_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
        <?php echo noaway_i18n_plain( $t['how_long_p'] ); ?>
      </p>
      <div class="not-prose overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 mb-6">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60">
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700"><?php echo noaway_i18n_plain( $t['table_client'] ); ?></th>
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700"><?php echo noaway_i18n_plain( $t['table_trigger'] ); ?></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <tr>
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200"><?php echo noaway_i18n_plain( $t['row_desktop'] ); ?></td>
              <td class="p-4 text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['row_desktop_v'] ); ?></td>
            </tr>
            <tr>
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200"><?php echo noaway_i18n_plain( $t['row_mobile'] ); ?></td>
              <td class="p-4 text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['row_mobile_v'] ); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
        <?php echo noaway_slack_presence_source_html( $noaway_landing_lang ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses'd in the helper. ?>
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_stay'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_stay'] ); ?>
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_inactive'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_inactive'] ); ?>
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_duration'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_duration'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="solutions-heading">
      <h2 id="solutions-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['solutions_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_html( $t['solutions_p'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="mac-heading">
      <h2 id="mac-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['mac_h'] ); ?></h2>
      <ol class="list-decimal pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <?php foreach ( $t['mac_steps'] as $step ) : ?>
        <li><?php echo noaway_i18n_html( $step ); ?></li>
        <?php endforeach; ?>
      </ol>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_html( $t['mac_note'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="windows-heading">
      <h2 id="windows-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['win_h'] ); ?></h2>
      <ol class="list-decimal pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <?php foreach ( $t['win_steps'] as $step ) : ?>
        <li><?php echo noaway_i18n_html( $step ); ?></li>
        <?php endforeach; ?>
      </ol>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_html( $t['win_note'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="status-types-heading">
      <h2 id="status-types-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['status_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_plain( $t['status_intro'] ); ?>
      </p>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <?php foreach ( $t['status_items'] as $item ) : ?>
        <li><?php echo noaway_i18n_html( $item ); ?></li>
        <?php endforeach; ?>
      </ul>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_plain( $t['status_close'] ); ?>
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['noaway_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php echo noaway_i18n_html( $t['noaway_p'] ); ?>
      </p>
    </section>

    <section class="mb-16" aria-labelledby="noaway-controls-heading">
      <?php noaway_render_controls_note( $noaway_landing_lang ); ?>
    </section>

    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8"><?php echo noaway_i18n_plain( $t['faq_h'] ); ?></h2>
      <div class="space-y-4">
        <?php foreach ( $t['faqs'] as $faq ) : ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/40 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400">
            <p class="text-sm leading-relaxed"><?php echo esc_html( $faq['text'] ); ?></p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="rounded-2xl bg-primary/5 dark:bg-primary/10 border border-primary/20 p-8 lg:p-12 text-center" aria-labelledby="cta-heading">
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo noaway_i18n_plain( $t['cta_h'] ); ?></h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto"><?php echo noaway_i18n_html( $t['cta_p'] ); ?></p>
      <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
        <?php echo noaway_i18n_plain( $t['buy'] ); ?>
      </a>
      <div class="max-w-md mx-auto mt-4 text-left md:hidden">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
      <p class="mt-3 text-sm text-slate-500 dark:text-slate-400"><?php echo noaway_refund_near_price_html( $noaway_landing_lang ); ?></p>
      <div class="max-w-md mx-auto mt-2 text-left">
        <?php noaway_render_before_you_buy( $noaway_landing_lang ); ?>
      </div>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline"><?php echo noaway_i18n_plain( $t['faq_link'] ); ?></a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline"><?php echo noaway_i18n_plain( $t['help_link'] ); ?></a> · <a href="<?php echo esc_url( function_exists( 'noaway_market_compare_page_url' ) ? noaway_market_compare_page_url() : home_url( '/compare/' ) ); ?>" class="text-primary font-semibold hover:underline">Compare prices</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
