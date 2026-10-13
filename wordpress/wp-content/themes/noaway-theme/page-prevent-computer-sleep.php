<?php
/**
 * Template Name: Prevent Computer Sleep SEO
 * SEO page: Prevent Computer Sleep – Keep computer awake on Mac and Windows
 */
get_header();
$download_url = noaway_downloads_page_url();
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Mac &amp; Windows</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        How to Prevent Computer Sleep and Keep Your Computer Awake
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Prevent computer sleep and keep your computer awake on Mac and Windows during long downloads, builds, or remote work. Learn why the system goes idle, what does not work, and how a small app keeps your machine active so Teams, Slack, and other apps show you as available.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          To prevent computer sleep on Mac or Windows, keep the system active with a small background app rather than only changing power settings. <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">NoAway</a> prevents idle at the OS level, which also keeps Teams, Slack, and Zoom showing Available during long tasks.
        </p>
      </div>
    </header>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">The problem: your computer goes idle or "sleeps" and apps think you are away</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        After a period without keyboard or mouse input, your Mac or Windows PC is considered idle. The display may dim or turn off, and apps that use activity to determine presence—like Microsoft Teams or Slack—switch your status to Away. Long downloads, compilations, or video calls where you are not touching the keyboard can trigger this. To keep your computer awake and prevent computer sleep from affecting your presence, you need the system to stay active without constant manual input.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="why-heading">
      <h2 id="why-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Why the computer goes idle: how Mac and Windows detect inactivity</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Both macOS and Windows use keyboard and mouse activity to decide if the user is present. No input for a set time means the system is "idle." That drives display sleep, optional system sleep, and—for apps like Teams and Slack—presence status. There is no single "keep computer awake forever" setting that fits every workflow: power settings control when the display or disk sleeps, but they do not necessarily keep the system from being treated as idle for presence. To keep computer awake on Mac or keep computer awake on Windows in a way that also keeps you "available" in collaboration apps, you need something that prevents idle at the system level.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="solutions-heading">
      <h2 id="solutions-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Common solutions that do not work well</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Turning off display sleep or system sleep in Settings helps with power but may not stop collaboration apps from marking you away, because they still see no user input. Putting a weight on the keyboard or wiggling the mouse is unreliable and gets in the way of real work. Scripts that simulate key presses can break after OS updates or be blocked by security. The reliable way to prevent computer sleep from affecting your presence is a lightweight utility that keeps the system active without opening extra windows or requiring admin rights.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">How NoAway keeps your computer awake on Mac and Windows</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        NoAway runs in the menu bar (Mac) or system tray (Windows) and prevents your computer from going idle. It does not change your power settings; it keeps the system active so that your display and presence-based apps stay "on." One click and your computer stays awake during long builds, downloads, or deep work—and <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams away status</a>, <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams</a>, <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Slack</a>, and similar apps read that activity signal. <?php echo esc_html( noaway_fact( 'benefit.full' ) ); ?> <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">See Help</a>. <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Get NoAway</a> on both <strong>keep computer awake Mac</strong> and <strong>keep computer awake Windows</strong> with a single purchase. No subscription, no browser window, minimal resources.
      </p>
    </section>

    <?php
    $faqs = function_exists( 'noaway_seo_landing_faq_items' ) ? noaway_seo_landing_faq_items( 'page-prevent-computer-sleep.php' ) : array();
    if ( ! is_array( $faqs ) ) {
      $faqs = array();
    }
    ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions about preventing computer sleep</h2>
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

    <section class="rounded-2xl bg-primary/5 dark:bg-primary/10 border border-primary/20 p-8 lg:p-12 text-center" aria-labelledby="cta-heading">
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Prevent computer sleep and keep your computer awake</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto"><a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Get NoAway for Mac and Windows</a> — one-time purchase, lifetime updates.</p>
      <div class="max-w-md mx-auto mb-4 text-left">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
      <a href="<?php echo esc_url( $download_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all">
        Download NoAway
      </a>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
