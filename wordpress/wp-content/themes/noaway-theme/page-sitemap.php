<?php
/**
 * Template Name: Sitemap NoAway
 * Pagina Sitemap - Elenco delle pagine principali del sito
 */
get_header();
?>
<main class="flex-1 px-6 md:px-10 lg:px-40 py-12 md:py-20">
  <div class="max-w-[800px] mx-auto">
    <div class="mb-16">
      <h1 class="text-slate-900 dark:text-slate-100 text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Sitemap</h1>
      <p class="text-primary font-medium">Navigate the site</p>
    </div>
    <div class="prose-custom dark:prose-invert text-slate-700 dark:text-slate-300">
      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">Overview</h2>
        <p class="leading-relaxed mb-0">
          Quick access to all main pages of the NoAway website. Use the links below to find what you need.
        </p>
      </section>
      <h2 class="flex items-center gap-2 mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">
        <span class="material-symbols-outlined text-primary">home</span>
        Main
      </h2>
      <ul class="pl-6 mb-12 space-y-3 list-disc">
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( home_url( '/' ) ); ?>">Home (Landing)</a>
        </li>
      </ul>
      <h2 class="mt-2 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">widgets</span>
        Product
      </h2>
      <ul class="pl-6 mb-12 space-y-3 list-disc">
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_features_page_url() ); ?>">Features</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_how_it_works_page_url() ); ?>">How it works</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>">Keep Teams Active</a>
          — <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'de' ) ); ?>">Deutsch</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'es' ) ); ?>">Español</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'pt-br' ) ); ?>">Português</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'teams', 'fr' ) ); ?>">Français</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_help_page_url() ); ?>">Help Center</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_sitemap_page_url() ); ?>">Sitemap</a>
        </li>
      </ul>
      <h2 class="mt-2 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">menu_book</span>
        Guides
      </h2>
      <ul class="pl-6 mb-12 space-y-3 list-disc">
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>">Why Teams Shows Away</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>">Keep Slack Active</a>
          — <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'de' ) ); ?>">Deutsch</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'es' ) ); ?>">Español</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'pt-br' ) ); ?>">Português</a>,
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_i18n_landing_url( 'slack', 'fr' ) ); ?>">Français</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_prevent_computer_sleep_page_url() ); ?>">Prevent Computer Sleep</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_is_noaway_safe_page_url() ); ?>">Is NoAway Safe?</a>
        </li>
      </ul>
      <h2 class="mt-2 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">download</span>
        Download
      </h2>
      <ul class="pl-6 mb-12 space-y-3 list-disc">
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_downloads_page_url() ); ?>">Download NoAway</a> — macOS &amp; Windows
        </li>
      </ul>
      <h2 class="mt-2 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">business_center</span>
        Company
      </h2>
      <ul class="pl-6 mb-12 space-y-3 list-disc">
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_faq_page_url() ); ?>">FAQ</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( noaway_contact_page_url() ); ?>">Contacts</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
        </li>
        <li class="leading-relaxed">
          <a class="text-primary hover:underline font-medium" href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of Service</a>
        </li>
      </ul>
    </div>
  </div>
</main>
<?php get_footer(); ?>
