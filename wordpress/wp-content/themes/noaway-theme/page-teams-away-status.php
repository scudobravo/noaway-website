<?php
/**
 * Template Name: Teams Away Status SEO
 * Diagnosis page: why Teams shows Away while you are working.
 * Selling stays on /keep-teams-active/.
 */
get_header();
$faqs = function_exists( 'noaway_seo_landing_faq_items' ) ? noaway_seo_landing_faq_items( 'page-teams-away-status.php' ) : array();
if ( ! is_array( $faqs ) ) {
	$faqs = array();
}
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Microsoft Teams</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        Why Teams shows Away while you're working
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Teams can show Away even when you are at the desk. The usual causes are a locked screen, a calendar event or a call, and different rules on desktop, the web, and mobile. Sleep settings alone do not keep you Available.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          On the desktop app, Teams can switch to Away after about five minutes without keyboard or mouse input. That interval is not a setting you change. A locked screen, a meeting, or the mobile and web clients can change presence for other reasons. If you want to keep this computer from going idle, the steps are on <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
        </p>
      </div>
    </header>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="lock-heading">
      <h2 id="lock-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">A locked screen looks idle</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        When the screen locks, the system stops seeing keyboard and mouse input. Teams treats that like any other idle stretch and can switch this device to Away, even if you are still in the room or on a call from your phone.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="away-offline-heading">
      <h2 id="away-offline-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Away is not Offline</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>Away</strong> means you are signed in and Teams treats the session as idle. The presence dot is yellow. <strong>Offline</strong> means Teams is quit, you are signed out, or that client has no connection. Keeping the computer awake does not change Offline.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="calendar-heading">
      <h2 id="calendar-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Calendar and calls set their own status</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        A meeting on the calendar can set In a meeting, Busy, or Out of office. An active call can change presence too. Those states come from the calendar and the call, not from the idle timer. Nothing that only keeps the computer awake overrides them.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="clients-heading">
      <h2 id="clients-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Desktop, web, and mobile do not share one timer</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        The desktop app uses the computer’s idle timer, about five minutes without keyboard or mouse input. The web app follows the browser session. The mobile app can go Away when you leave it or the phone locks. Activity on one device does not keep the others Available.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="sleep-heading">
      <h2 id="sleep-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Why sleep settings alone are not enough</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Power and sleep settings decide when the display or the machine sleeps. Teams still looks for recent keyboard and mouse input. A computer that is awake but idle can still show Away. The same limit is in the <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help Center</a>.
      </p>
    </section>

    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Questions about Teams presence</h2>
      <div class="space-y-4">
        <?php foreach ( $faqs as $faq ) : ?>
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

    <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
      The steps for keeping this computer from going idle are on <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
    </p>
  </article>
</main>
<?php get_footer(); ?>
