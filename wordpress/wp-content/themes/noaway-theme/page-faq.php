<?php
/**
 * Template Name: FAQ NoAway
 * Pagina FAQ - Domande frequenti con accordion (click per aprire/chiudere)
 * Schema FAQPage: emesso una sola volta in wp_head da inc/noaway-seo.php (evita "Campo duplicato FAQPage").
 */
get_header();

$faq_schema_entities = function_exists( 'noaway_seo_faq_schema_entities' ) ? noaway_seo_faq_schema_entities() : array();
// Sections are chosen by each entry's `group` key, so the visible list and JSON-LD always come from the same array.
$noaway_faq_group = function ( $group ) use ( $faq_schema_entities ) {
	return array_values(
		array_filter(
			$faq_schema_entities,
			function ( $faq ) use ( $group ) {
				return isset( $faq['group'] ) && $faq['group'] === $group;
			}
		)
	);
};
?>
<main>
  <section class="relative pt-16 pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
        <span class="material-symbols-outlined text-sm">help</span>
        FAQ
      </div>
      <h1 class="text-5xl md:text-6xl font-black tracking-tight mb-6">
        Frequently Asked Questions
      </h1>
      <p class="text-slate-600 dark:text-slate-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
        Quick answers about NoAway, how to keep your status always online in Microsoft Teams, and the best practice for staying active. What helps, and how common workarounds differ.
      </p>
      <p class="mt-6 text-slate-600 dark:text-slate-400 text-base max-w-2xl mx-auto leading-relaxed">
        Asking about privacy or IT policy? Read <a href="<?php echo esc_url( noaway_is_noaway_safe_page_url() ); ?>" class="text-primary font-semibold hover:underline">Is NoAway safe?</a> for what the app does and does not do.
        Comparing prices with Slack Green, NotAway, Idle Pilot, or a USB mouse jiggler?
        See <a href="<?php echo esc_url( function_exists( 'noaway_market_compare_page_url' ) ? noaway_market_compare_page_url() : home_url( '/compare/' ) ); ?>" class="text-primary font-semibold hover:underline">Compare</a>.
      </p>
    </div>
    <div class="absolute -top-24 -right-24 size-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 -left-24 size-64 bg-primary/10 rounded-full blur-3xl"></div>
  </section>

  <nav class="sticky top-16 md:top-20 z-30 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur border-b border-slate-200/80 dark:border-slate-800 md:static md:bg-transparent md:border-0 md:backdrop-blur-none" aria-label="FAQ categories">
    <div class="max-w-4xl mx-auto px-6 py-3 flex flex-wrap gap-2 justify-center md:justify-start">
      <a href="#faq-search" class="inline-flex items-center min-h-[44px] px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:border-primary/40 hover:text-primary">What people ask: how to stop Teams showing Away</a>
      <a href="#faq-about" class="inline-flex items-center min-h-[44px] px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:border-primary/40 hover:text-primary">About NoAway</a>
      <a href="#faq-privacy" class="inline-flex items-center min-h-[44px] px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:border-primary/40 hover:text-primary">Privacy, detection &amp; compliance</a>
      <a href="#faq-teams" class="inline-flex items-center min-h-[44px] px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:border-primary/40 hover:text-primary">Why Teams shows Away, and how common workarounds compare</a>
    </div>
  </nav>

  <section class="max-w-4xl mx-auto px-6 pb-24" aria-labelledby="faq-heading">
    <h2 id="faq-heading" class="sr-only">Common questions</h2>

    <!-- What people search for (Google / Reddit – SEO) -->
    <div class="mb-12" id="faq-search">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">What people ask: how to stop Teams showing Away</h3>
      <div class="space-y-4">
        <?php
        $search_faqs = $noaway_faq_group( 'search' );
        foreach ( $search_faqs as $faq ) :
          ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t-0">
            <?php echo esc_html( $faq['text'] ); ?>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- About NoAway -->
    <div class="mb-12" id="faq-about">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">About NoAway</h3>
      <div class="space-y-4">
        <?php
        $about_faqs = $noaway_faq_group( 'about' );
        foreach ( $about_faqs as $faq ) :
          ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t-0">
            <?php echo esc_html( $faq['text'] ); ?>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Privacy, detection & compliance -->
    <div class="mb-12" id="faq-privacy">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">Privacy, detection &amp; compliance</h3>
      <div class="space-y-4">
        <?php
        $privacy_faqs = $noaway_faq_group( 'privacy' );
        foreach ( $privacy_faqs as $faq ) :
          ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t-0">
            <?php echo esc_html( $faq['text'] ); ?>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Why common Teams "stay active" tricks don't work -->
    <div id="faq-teams">
      <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-6">Why Teams shows Away, and how common workarounds compare</h3>
      <div class="space-y-4">
        <?php
        $teams_faqs = $noaway_faq_group( 'teams' );
        foreach ( $teams_faqs as $faq ) :
          ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400 text-sm leading-relaxed border-t-0">
            <?php echo esc_html( $faq['text'] ); ?>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mt-12 text-center">
      <p class="text-slate-600 mb-4">Still didn't find what you're looking for?</p>
      <a class="inline-flex items-center gap-2 font-bold text-primary group" href="<?php echo esc_url( noaway_contact_page_url() ); ?>">
        Contact support
        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
      </a>
    </div>
  </section>
</main>
<?php get_footer(); ?>
