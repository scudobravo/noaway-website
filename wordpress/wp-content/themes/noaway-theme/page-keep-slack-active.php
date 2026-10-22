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
  <article class="max-w-6xl mx-auto px-6 pt-12 lg:pt-20 pb-12" itemscope itemtype="https://schema.org/Article">
    <header class="max-w-3xl mb-12 lg:mb-16" data-noaway-sticky-after>
      <?php noaway_i18n_language_switcher( 'slack', 'header' ); ?>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="na-eyebrow"><?php echo noaway_i18n_plain( $t['badge'] ); ?></span>
      </div>
      <h1 class="na-h1 mb-4" style="text-wrap:balance">
        <?php echo noaway_i18n_plain( $t['h1'] ); ?>
      </h1>
      <?php noaway_i18n_language_switcher( 'slack', 'under-title' ); ?>
      <p class="na-lead">
        <?php echo noaway_i18n_plain( $t['lead'] ); ?>
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="<?php echo esc_attr( $t['aria_brief'] ); ?>">
        <p class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2"><?php echo noaway_i18n_plain( $t['brief_label'] ); ?></p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          <?php echo noaway_i18n_html( $t['brief'] ); ?>
        </p>
        <?php noaway_render_last_reviewed( 'page-keep-slack-active.php' ); ?>
      </div>
    </header>

    <?php ob_start(); ?>
    <section class="mb-14" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['problem_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_plain( $t['problem_p'] ); ?>
      </p>
    </section>

    <section class="mb-14" aria-labelledby="why-heading">
      <h2 id="why-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['why_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_plain( $t['why_p'] ); ?>
      </p>
    </section>

    <section class="mb-14" aria-labelledby="how-long-heading">
      <h2 id="how-long-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['how_long_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-6">
        <?php echo noaway_i18n_plain( $t['how_long_p'] ); ?>
      </p>
      <div class="not-prose overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/40 mb-6">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60">
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700"><?php echo noaway_i18n_plain( $t['table_client'] ); ?></th>
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700"><?php echo noaway_i18n_plain( $t['table_trigger'] ); ?></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <tr class="bg-white dark:bg-slate-900/20">
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200"><?php echo noaway_i18n_plain( $t['row_desktop'] ); ?></td>
              <td class="p-4 text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['row_desktop_v'] ); ?></td>
            </tr>
            <tr class="bg-slate-50/70 dark:bg-slate-800/30">
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200"><?php echo noaway_i18n_plain( $t['row_mobile'] ); ?></td>
              <td class="p-4 text-slate-600 dark:text-slate-400"><?php echo noaway_i18n_plain( $t['row_mobile_v'] ); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
        <?php echo noaway_slack_presence_source_html( $noaway_landing_lang ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses'd in the helper. ?>
      </p>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_stay'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_stay'] ); ?>
      </p>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_inactive'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_inactive'] ); ?>
      </p>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <strong><?php echo noaway_i18n_plain( $t['q_duration'] ); ?></strong> <?php echo noaway_i18n_plain( $t['a_duration'] ); ?>
      </p>
    </section>

    <section class="mb-14" aria-labelledby="solutions-heading">
      <h2 id="solutions-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['solutions_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_html( $t['solutions_p'] ); ?>
      </p>
    </section>

    <?php
    $noaway_slack_platforms = array(
      array(
        'section_id' => 'mac-heading',
        'heading'    => $t['mac_h'],
        'steps'      => $t['mac_steps'],
        'note'       => $t['mac_note'],
      ),
      array(
        'section_id' => 'windows-heading',
        'heading'    => $t['win_h'],
        'steps'      => $t['win_steps'],
        'note'       => $t['win_note'],
      ),
    );
    foreach ( $noaway_slack_platforms as $platform ) :
      ?>
    <section class="mb-14" aria-labelledby="<?php echo esc_attr( $platform['section_id'] ); ?>">
      <h2 id="<?php echo esc_attr( $platform['section_id'] ); ?>" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $platform['heading'] ); ?></h2>
      <ol class="list-none p-0 m-0 mb-6 flex flex-col gap-4">
        <?php foreach ( $platform['steps'] as $i => $step ) : ?>
        <li class="na-card p-5 flex items-start gap-4">
          <span class="size-9 shrink-0 rounded-full bg-primary text-white font-bold flex items-center justify-center" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
          <p class="m-0 pt-1 text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed"><?php echo noaway_i18n_html( $step ); ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
      <div class="flex items-start gap-3 rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-950/30 dark:border-amber-700/60 p-4 sm:p-5" role="note">
        <span class="material-symbols-outlined text-amber-700 dark:text-amber-400 shrink-0" aria-hidden="true">info</span>
        <p class="m-0 text-[15px] text-amber-900 dark:text-amber-100 leading-relaxed">
          <?php echo noaway_i18n_html( $platform['note'] ); ?>
        </p>
      </div>
    </section>
    <?php endforeach; ?>

    <section class="mb-14" aria-labelledby="status-types-heading">
      <h2 id="status-types-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['status_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_plain( $t['status_intro'] ); ?>
      </p>
      <ul class="list-disc pl-5 text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] space-y-3 mb-4">
        <?php foreach ( $t['status_items'] as $item ) : ?>
        <li><?php echo noaway_i18n_html( $item ); ?></li>
        <?php endforeach; ?>
      </ul>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_plain( $t['status_close'] ); ?>
      </p>
    </section>

    <section class="mb-14" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['noaway_h'] ); ?></h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        <?php echo noaway_i18n_html( $t['noaway_p'] ); ?>
      </p>
    </section>

    <section class="mb-14" aria-labelledby="noaway-controls-heading">
      <?php noaway_render_controls_note( $noaway_landing_lang ); ?>
    </section>

    <section class="mb-6" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="na-guide-h2 !mt-0"><?php echo noaway_i18n_plain( $t['faq_h'] ); ?></h2>
      <div class="space-y-4">
        <?php foreach ( $t['faqs'] as $faq ) : ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/40 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 sm:p-6 min-h-[44px] list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-5 sm:px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400">
            <p class="text-sm leading-relaxed"><?php echo esc_html( $faq['text'] ); ?></p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </section>
    <?php
    $noaway_guide_body = ob_get_clean();
    $noaway_checkout_url = noaway_checkout_url();
    noaway_render_guide_layout(
      $noaway_guide_body,
      array(
        'buy_url'   => $noaway_checkout_url,
        'buy_label' => 'Buy NoAway – ' . noaway_price_label(),
        'tracked'   => true,
        'position'  => 'guide-toc',
      )
    );
    ?>
  </article>

  <?php
  $noaway_cta_link_class = 'text-white font-semibold underline underline-offset-2 hover:no-underline inline-flex items-center min-h-[44px]';
  $noaway_compare_url    = function_exists( 'noaway_market_compare_page_url' ) ? noaway_market_compare_page_url() : home_url( '/compare/' );
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'section_id'         => 'download',
      'title'              => noaway_i18n_raw( $t['cta_h'] ),
      'lines'              => array( noaway_i18n_html( $t['cta_p'] ) ),
      'button_url'         => $noaway_checkout_url,
      'button_label'       => noaway_i18n_raw( $t['buy'] ),
      'cta_position'       => 'footer-cta',
      'before_button_html' => noaway_capture_mobile_email_box( true ),
      'secondary_html'     => '<p class="mb-2">' . noaway_refund_near_price_html( $noaway_landing_lang, true ) . '</p><p class="flex flex-wrap justify-center items-center gap-x-2"><a href="' . esc_url( noaway_faq_page_url() ) . '" class="' . $noaway_cta_link_class . '">' . noaway_i18n_plain( $t['faq_link'] ) . '</a> <span aria-hidden="true">·</span> <a href="' . esc_url( noaway_help_page_url() ) . '" class="' . $noaway_cta_link_class . '">' . noaway_i18n_plain( $t['help_link'] ) . '</a> <span aria-hidden="true">·</span> <a href="' . esc_url( $noaway_compare_url ) . '" class="' . $noaway_cta_link_class . '">Compare prices</a></p>',
    )
  );
  ?>
  <section class="px-6 pb-12 md:pb-16">
    <div class="max-w-5xl mx-auto">
      <?php noaway_render_before_you_buy( $noaway_landing_lang, 'horizontal' ); ?>
    </div>
  </section>
</main>
<?php
if ( function_exists( 'noaway_render_sticky_buy_bar' ) ) {
  noaway_render_sticky_buy_bar(
    array(
      'label' => noaway_i18n_raw( $t['buy'] ),
      'url'   => $noaway_checkout_url,
    )
  );
}
get_footer();
