<?php
/**
 * Template Name: Compare NoAway
 * Reusable comparison landing — data from inc/noaway-comparisons.php (keyed by page slug).
 */
get_header();

$download_url = noaway_downloads_page_url();
$cmp          = function_exists( 'noaway_get_comparison_for_current_page' ) ? noaway_get_comparison_for_current_page() : null;

if ( ! is_array( $cmp ) ) {
	// Fallback if the WP page slug is not registered in noaway_comparisons().
	$cmp = array(
		'competitor_name'  => 'this alternative',
		'competitor_short' => 'Alternative',
		'badge'            => 'Comparison',
		'h1'               => 'NoAway comparison',
		'intro'            => 'This comparison page is not configured yet. Add the page slug to inc/noaway-comparisons.php.',
		'verdict'          => 'Comparison data is missing for this URL. Use a registered slug such as noaway-vs-powertoys-awake.',
		'rows'             => array(),
		'when_competitor'  => array(
			'heading' => 'When to use the alternative',
			'intro'   => '',
			'points'  => array(),
		),
		'when_noaway'      => array(
			'heading' => 'When to use NoAway',
			'intro'   => '',
			'points'  => array(),
		),
		'faqs'             => array(),
	);
}

$competitor_name  = isset( $cmp['competitor_name'] ) ? $cmp['competitor_name'] : 'Alternative';
$competitor_short = isset( $cmp['competitor_short'] ) ? $cmp['competitor_short'] : $competitor_name;
$verdict_words    = str_word_count( wp_strip_all_tags( isset( $cmp['verdict'] ) ? $cmp['verdict'] : '' ) );
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider"><?php echo esc_html( isset( $cmp['badge'] ) ? $cmp['badge'] : 'Comparison' ); ?></span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        <?php echo esc_html( isset( $cmp['h1'] ) ? $cmp['h1'] : 'NoAway comparison' ); ?>
      </h1>
      <?php if ( ! empty( $cmp['intro'] ) ) : ?>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        <?php echo esc_html( $cmp['intro'] ); ?>
      </p>
      <?php endif; ?>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="Verdict">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Verdict</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          <?php echo esc_html( isset( $cmp['verdict'] ) ? $cmp['verdict'] : '' ); ?>
        </p>
        <?php if ( $verdict_words > 0 && ( $verdict_words < 40 || $verdict_words > 60 ) ) : ?>
        <!-- TODO: Trim or expand verdict to ~50 words (currently <?php echo (int) $verdict_words; ?>). -->
        <?php endif; ?>
      </div>
    </header>

    <?php if ( ! empty( $cmp['rows'] ) && is_array( $cmp['rows'] ) ) : ?>
    <section class="mb-16" aria-labelledby="table-heading">
      <h2 id="table-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Quick comparison</h2>
      <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60">
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Feature</th>
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700"><?php echo esc_html( $competitor_short ); ?></th>
              <th class="p-4 font-bold text-primary border-b border-slate-200 dark:border-slate-700">NoAway</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <?php foreach ( $cmp['rows'] as $row ) : ?>
            <tr>
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200 align-top"><?php echo esc_html( isset( $row['label'] ) ? $row['label'] : '' ); ?></td>
              <td class="p-4 text-slate-600 dark:text-slate-400 align-top">
                <?php if ( ! empty( $row['competitor_todo'] ) ) : ?>
                <!-- TODO: <?php echo esc_html( (string) $row['competitor_todo'] ); ?> -->
                <?php endif; ?>
                <?php echo esc_html( isset( $row['competitor'] ) ? $row['competitor'] : '' ); ?>
              </td>
              <td class="p-4 text-slate-700 dark:text-slate-300 font-medium align-top"><?php echo esc_html( isset( $row['noaway'] ) ? $row['noaway'] : '' ); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
    <?php endif; ?>

    <?php
    $when_c = isset( $cmp['when_competitor'] ) && is_array( $cmp['when_competitor'] ) ? $cmp['when_competitor'] : array();
    $when_n = isset( $cmp['when_noaway'] ) && is_array( $cmp['when_noaway'] ) ? $cmp['when_noaway'] : array();
    ?>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="when-competitor-heading">
      <h2 id="when-competitor-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">
        <?php echo esc_html( isset( $when_c['heading'] ) ? $when_c['heading'] : 'When to use ' . $competitor_name ); ?>
      </h2>
      <?php if ( ! empty( $when_c['intro'] ) ) : ?>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4"><?php echo esc_html( $when_c['intro'] ); ?></p>
      <?php endif; ?>
      <?php if ( ! empty( $when_c['points'] ) && is_array( $when_c['points'] ) ) : ?>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <?php foreach ( $when_c['points'] as $point ) :
          $text = is_array( $point ) ? ( isset( $point['text'] ) ? $point['text'] : '' ) : (string) $point;
          $todo = is_array( $point ) && ! empty( $point['todo'] ) ? (string) $point['todo'] : '';
          ?>
        <li>
          <?php if ( $todo !== '' ) : ?>
          <!-- TODO: <?php echo esc_html( $todo ); ?> -->
          <?php endif; ?>
          <?php echo esc_html( $text ); ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="when-noaway-heading">
      <h2 id="when-noaway-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">
        <?php echo esc_html( isset( $when_n['heading'] ) ? $when_n['heading'] : 'When to use NoAway' ); ?>
      </h2>
      <?php if ( ! empty( $when_n['intro'] ) ) : ?>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4"><?php echo esc_html( $when_n['intro'] ); ?></p>
      <?php endif; ?>
      <?php if ( ! empty( $when_n['points'] ) && is_array( $when_n['points'] ) ) : ?>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <?php foreach ( $when_n['points'] as $point ) :
          $text = is_array( $point ) ? ( isset( $point['text'] ) ? $point['text'] : '' ) : (string) $point;
          ?>
        <li><?php echo esc_html( $text ); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </section>

    <?php
    $faqs = isset( $cmp['faqs'] ) && is_array( $cmp['faqs'] ) ? $cmp['faqs'] : array();
    if ( $faqs ) :
      ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions</h2>
      <div class="space-y-4">
        <?php foreach ( $faqs as $faq ) : ?>
        <?php if ( ! empty( $faq['competitor_todo'] ) ) : ?>
        <!-- TODO: <?php echo esc_html( (string) $faq['competitor_todo'] ); ?> -->
        <?php endif; ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/40 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <span><?php echo esc_html( isset( $faq['name'] ) ? $faq['name'] : '' ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400">
            <p class="text-sm leading-relaxed"><?php echo esc_html( isset( $faq['text'] ) ? $faq['text'] : '' ); ?></p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <section class="rounded-2xl bg-primary/5 dark:bg-primary/10 border border-primary/20 p-8 lg:p-12 text-center" aria-labelledby="cta-heading">
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Prefer the NoAway approach?</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto">
        <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Download NoAway</a>
        for Mac and Windows — or read
        <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
      </p>
      <div class="max-w-md mx-auto mb-4 text-left">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
      <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
        Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
      </a>
    </section>
  </article>
</main>
<?php get_footer(); ?>
