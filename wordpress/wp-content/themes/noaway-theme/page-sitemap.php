<?php
/**
 * Template Name: Sitemap NoAway
 * Pagina Sitemap - Elenco delle pagine principali del sito
 */
get_header();
?>
<main class="flex-1 px-6 md:px-10 lg:px-20 py-12 md:py-20">
  <div class="max-w-7xl mx-auto">
    <div class="mb-10 max-w-3xl">
      <h1 class="na-h1 mb-4">Sitemap</h1>
      <p class="text-primary font-medium mb-4">Navigate the site</p>
      <h2 class="na-h3 mb-2">Overview</h2>
      <p class="text-slate-700 dark:text-slate-300 leading-relaxed mb-0">
        Quick access to all main pages of the NoAway website. Use the links below to find what you need.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-slate-700 dark:text-slate-300">
      <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
        <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
          <span class="material-symbols-outlined text-primary">home</span>
          Main
        </h2>
        <ul class="pl-0 space-y-1 list-none m-0">
          <li>
            <a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home (Landing)</a>
          </li>
        </ul>
      </section>
      <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
        <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
          <span class="material-symbols-outlined text-primary">widgets</span>
          Product
        </h2>
        <ul class="pl-0 space-y-1 list-none m-0">
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_features_page_url() ); ?>">Features</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_how_it_works_page_url() ); ?>">How it works</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( function_exists( 'noaway_market_compare_page_url' ) ? noaway_market_compare_page_url() : home_url( '/compare/' ) ); ?>">Compare prices</a></li>
          <li>
            <a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>">Keep Teams Active</a>
            — <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'de' ) ); ?>">Deutsch</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'es' ) ); ?>">Español</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'pt-br' ) ); ?>">Português</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'fr' ) ); ?>">Français</a>
          </li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_help_page_url() ); ?>">Help Center</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_sitemap_page_url() ); ?>">Sitemap</a></li>
        </ul>
      </section>
      <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
        <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
          <span class="material-symbols-outlined text-primary">menu_book</span>
          Guides
        </h2>
        <ul class="pl-0 space-y-1 list-none m-0">
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>">Why Teams Shows Away</a></li>
          <li>
            <a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>">Keep Slack Active</a>
            — <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'de' ) ); ?>">Deutsch</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'es' ) ); ?>">Español</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'pt-br' ) ); ?>">Português</a>,
            <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'fr' ) ); ?>">Français</a>
          </li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_prevent_computer_sleep_page_url() ); ?>">Prevent Computer Sleep</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_is_noaway_safe_page_url() ); ?>">Is NoAway Safe?</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_releases_page_url() ); ?>">Releases</a></li>
        </ul>
      </section>
      <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
        <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
          <span class="material-symbols-outlined text-primary">download</span>
          Download
        </h2>
        <ul class="pl-0 space-y-1 list-none m-0">
          <li>
            <a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_downloads_page_url() ); ?>">Download NoAway</a> — macOS &amp; Windows
          </li>
        </ul>
      </section>
      <section class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
        <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
          <span class="material-symbols-outlined text-primary">business_center</span>
          Company
        </h2>
        <ul class="pl-0 space-y-1 list-none m-0">
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_faq_page_url() ); ?>">FAQ</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( noaway_contact_page_url() ); ?>">Contacts</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
          <li><a class="text-primary hover:underline font-medium inline-flex items-center min-h-[44px]" href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of Service</a></li>
        </ul>
      </section>
    </div>
  </div>
</main>
<?php get_footer(); ?>
