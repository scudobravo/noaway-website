<?php
/**
 * Market price comparison for /compare/.
 * Data: inc/noaway-market-compare.php. FAQ from noaway_seo_faq_schema_entities() (compare flag).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$download_url = function_exists( 'noaway_downloads_page_url' ) ? noaway_downloads_page_url() : home_url( '/downloads/' );
$table        = function_exists( 'noaway_market_compare_table' ) ? noaway_market_compare_table() : array( 'headers' => array(), 'rows' => array() );
$sources      = function_exists( 'noaway_market_compare_sources' ) ? noaway_market_compare_sources() : array();
$guidance     = function_exists( 'noaway_market_compare_guidance' ) ? noaway_market_compare_guidance() : array();
$checked      = defined( 'NOAWAY_MARKET_COMPARE_CHECKED' ) ? NOAWAY_MARKET_COMPARE_CHECKED : '';
$badge        = isset( $table['highlight_badge'] ) ? (string) $table['highlight_badge'] : '';

$compare_faqs = array();
if ( function_exists( 'noaway_seo_faq_schema_entities' ) ) {
	foreach ( noaway_seo_faq_schema_entities() as $faq ) {
		if ( ! empty( $faq['compare'] ) ) {
			$compare_faqs[] = $faq;
		}
	}
}

get_header();
?>
<main>
  <article class="max-w-6xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12 max-w-4xl">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Price comparison</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        Keep your status active for €4.99, once
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        An objective look at NoAway next to Slack Green, NotAway, Idle Pilot, and generic USB mouse jigglers. Figures below are taken from each competitor’s public site where available; otherwise we write <em>not stated</em>.
      </p>
      <?php if ( $checked !== '' ) : ?>
      <p class="mt-4 text-sm font-medium text-slate-600 dark:text-slate-400">Prices checked on <?php echo esc_html( $checked ); ?></p>
      <?php endif; ?>
    </header>

    <?php if ( ! empty( $table['rows'] ) ) : ?>
    <section class="mb-16" aria-labelledby="detail-table-heading">
      <h2 id="detail-table-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Detailed comparison</h2>
      <div class="noaway-compare-scroll relative overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
        <table class="w-full text-left text-sm min-w-[720px]">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60">
              <th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700 sticky left-0 z-10 bg-slate-50 dark:bg-slate-900 shadow-[2px_0_8px_-2px_rgba(15,23,42,0.12)]">Feature</th>
              <?php foreach ( $table['headers'] as $i => $header ) : ?>
              <th class="p-4 font-bold border-b border-slate-200 dark:border-slate-700 align-bottom <?php echo $i === 0 ? 'text-primary bg-primary/5 dark:bg-primary/10' : 'text-slate-900 dark:text-slate-100'; ?>">
                <?php if ( $i === 0 && $badge !== '' ) : ?>
                <span class="mb-2 inline-block whitespace-nowrap rounded-full bg-primary px-3 py-1 text-[11px] font-bold uppercase leading-none tracking-wide text-white"><?php echo esc_html( $badge ); ?></span>
                <span class="block"><?php echo esc_html( $header ); ?></span>
                <?php else : ?>
                <?php echo esc_html( $header ); ?>
                <?php endif; ?>
              </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <?php foreach ( $table['rows'] as $row ) :
              $emphasize = ! empty( $row['emphasize'] );
              ?>
            <tr class="<?php echo $emphasize ? 'bg-slate-50/80 dark:bg-slate-900/40' : ''; ?>">
              <td class="p-4 font-semibold text-slate-800 dark:text-slate-200 align-top sticky left-0 z-10 bg-white dark:bg-slate-900 shadow-[2px_0_8px_-2px_rgba(15,23,42,0.12)] <?php echo $emphasize ? 'text-base bg-slate-50/80 dark:bg-slate-900/40' : ''; ?>"><?php echo esc_html( $row['label'] ); ?></td>
              <?php foreach ( $row['cells'] as $i => $cell ) :
                $cell_class = $i === 0
                  ? 'text-slate-800 dark:text-slate-200 font-medium bg-primary/5 dark:bg-primary/10'
                  : 'text-slate-600 dark:text-slate-400';
                if ( $emphasize ) {
                  $cell_class .= $i === 0
                    ? ' text-base font-bold text-slate-900 dark:text-slate-100'
                    : ' text-base font-semibold text-slate-800 dark:text-slate-200';
                }
                ?>
              <td class="p-4 align-top <?php echo esc_attr( $cell_class ); ?>">
                <?php
                $cell_str = (string) $cell;
                if ( 0 === stripos( $cell_str, 'Yes' ) ) {
                  echo '<span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-emerald-600 text-base" aria-hidden="true">check_circle</span>' . esc_html( $cell_str ) . '</span>';
                } elseif ( 0 === stripos( $cell_str, 'No' ) ) {
                  echo '<span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-slate-400 text-base" aria-hidden="true">cancel</span>' . esc_html( $cell_str ) . '</span>';
                } else {
                  echo esc_html( $cell_str );
                }
                ?>
              </td>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if ( $sources ) : ?>
      <p class="mt-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
        <span class="font-semibold text-slate-600 dark:text-slate-300">Sources:</span>
        <?php
        $source_parts = array();
        foreach ( $sources as $source ) {
          $name = esc_html( $source['name'] );
          if ( ! empty( $source['url'] ) ) {
            $source_parts[] = $name . ' — <a href="' . esc_url( $source['url'] ) . '" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank">' . esc_html( $source['label'] ) . '</a>';
          } else {
            $source_parts[] = $name . ' — ' . esc_html( $source['label'] );
          }
        }
        echo implode( ' · ', $source_parts );
        ?>
      </p>
      <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php
    $when_n = isset( $guidance['choose_noaway'] ) ? $guidance['choose_noaway'] : array();
    $when_c = isset( $guidance['choose_cloud'] ) ? $guidance['choose_cloud'] : array();
    ?>
    <div class="grid gap-8 lg:grid-cols-2 mb-16">
      <?php if ( $when_n ) : ?>
      <section class="rounded-2xl border border-primary/30 bg-primary/5 dark:bg-primary/10 p-6 lg:p-8" aria-labelledby="choose-noaway-heading">
        <h2 id="choose-noaway-heading" class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo esc_html( $when_n['heading'] ); ?></h2>
        <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-0">
          <?php foreach ( $when_n['points'] as $point ) : ?>
          <li><?php echo esc_html( $point ); ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
      <?php endif; ?>
      <?php if ( $when_c ) : ?>
      <section class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/40 p-6 lg:p-8" aria-labelledby="choose-cloud-heading">
        <h2 id="choose-cloud-heading" class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo esc_html( $when_c['heading'] ); ?></h2>
        <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
          <?php foreach ( $when_c['points'] as $point ) : ?>
          <li><?php echo esc_html( $point ); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php if ( ! empty( $when_c['note'] ) ) : ?>
        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-0">
          <?php echo esc_html( $when_c['note'] ); ?>
          <?php if ( ! empty( $when_c['note_url'] ) ) : ?>
          <a href="<?php echo esc_url( $when_c['note_url'] ); ?>" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank"><?php echo esc_html( isset( $when_c['note_label'] ) ? $when_c['note_label'] : 'Source' ); ?></a>
          <?php endif; ?>
        </p>
        <?php endif; ?>
      </section>
      <?php endif; ?>
    </div>

    <?php if ( $compare_faqs ) : ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions</h2>
      <div class="space-y-4">
        <?php foreach ( $compare_faqs as $faq ) : ?>
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
      <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">
        More questions:
        <a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a>
      </p>
    </section>
    <?php endif; ?>

    <section class="rounded-2xl bg-primary/5 dark:bg-primary/10 border border-primary/20 p-8 lg:p-12 text-center" aria-labelledby="cta-heading">
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Prefer a local app you pay for once?</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto">
        <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Download NoAway</a>
        for Mac and Windows — or read
        <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>
        and
        <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Slack active</a>.
      </p>
      <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
        Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
      </a>
      <div class="max-w-md mx-auto mt-4 text-left md:hidden">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
    </section>
  </article>
</main>
<?php
get_footer();
