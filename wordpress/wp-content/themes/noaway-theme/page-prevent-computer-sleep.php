<?php
/**
 * Template Name: Prevent Computer Sleep SEO
 * SEO page: Prevent Computer Sleep – Keep computer awake on Mac and Windows
 */
get_header();
$download_url = noaway_downloads_page_url();
?>
<main>
  <article class="max-w-6xl mx-auto px-6 pt-12 lg:pt-20 pb-12" itemscope itemtype="https://schema.org/Article">
    <header class="max-w-3xl mb-12 lg:mb-16" data-noaway-sticky-after>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="na-eyebrow">Mac &amp; Windows</span>
      </div>
      <h1 class="na-h1 mb-6" style="text-wrap:balance">
        How to Prevent Computer Sleep and Keep Your Computer Awake
      </h1>
      <p class="na-lead">
        Prevent computer sleep and keep your computer awake on Mac and Windows during long downloads, builds, or remote work. Learn why the system goes idle, what does not work, and how a small app keeps your machine active so Teams, Slack, and other apps show you as available.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          To prevent computer sleep on Mac or Windows, keep the system active with a small background app rather than only changing power settings. <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">NoAway</a> prevents idle at the OS level, which also keeps Teams, Slack, and Zoom showing Available during long tasks.
        </p>
      </div>
    </header>

    <?php ob_start(); ?>
    <section class="mb-14" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="na-guide-h2 !mt-0">The problem: your computer goes idle or "sleeps" and apps think you are away</h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        After a period without keyboard or mouse input, your Mac or Windows PC is considered idle. The display may dim or turn off, and apps that use activity to determine presence—like Microsoft Teams or Slack—switch your status to Away. Long downloads, compilations, or video calls where you are not touching the keyboard can trigger this. To keep your computer awake and prevent computer sleep from affecting your presence, you need the system to stay active without constant manual input.
      </p>
    </section>
    <section class="mb-14" aria-labelledby="why-heading">
      <h2 id="why-heading" class="na-guide-h2 !mt-0">Why the computer goes idle: how Mac and Windows detect inactivity</h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        Both macOS and Windows use keyboard and mouse activity to decide if the user is present. No input for a set time means the system is "idle." That drives display sleep, optional system sleep, and—for apps like Teams and Slack—presence status. There is no single "keep computer awake forever" setting that fits every workflow: power settings control when the display or disk sleeps, but they do not necessarily keep the system from being treated as idle for presence. To keep computer awake on Mac or keep computer awake on Windows in a way that also keeps you "available" in collaboration apps, you need something that prevents idle at the system level.
      </p>
    </section>
    <section class="mb-14" aria-labelledby="solutions-heading">
      <h2 id="solutions-heading" class="na-guide-h2 !mt-0">Common approaches compared</h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        Turning off display sleep or system sleep in Settings helps with power but may not stop collaboration apps from marking you away, because they still see no user input. A hardware mouse jiggler is a USB device and needs no software on the computer. A script needs the same system permissions as any app that simulates input, plus your own upkeep. NoAway is software for Mac and Windows: it keeps the display awake, prevents sleep, and simulates input; on macOS it needs Accessibility permission, and it must keep running (menu bar or system tray). A locked screen, calendar status, company policy, and presence on other devices are outside what NoAway controls, and antivirus software on Windows can block simulated input.
      </p>
    </section>
    <section class="mb-14" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="na-guide-h2 !mt-0">How NoAway keeps your computer awake on Mac and Windows</h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        NoAway runs in the menu bar (Mac) or system tray (Windows) and prevents your computer from going idle. It does not change your power settings; it keeps the system active so that your display and presence-based apps stay "on." One click and your computer stays awake during long builds, downloads, or deep work—and <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams away status</a>, <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams</a>, <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Slack</a>, and similar apps read that activity signal. <?php echo esc_html( noaway_fact( 'benefit.full' ) ); ?> <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">See Help</a>. <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Get NoAway</a> on both <strong>keep computer awake Mac</strong> and <strong>keep computer awake Windows</strong> with a single purchase. No subscription, no browser window, minimal resources.
      </p>
    </section>

    <?php
    $faqs = function_exists( 'noaway_seo_landing_faq_items' ) ? noaway_seo_landing_faq_items( 'page-prevent-computer-sleep.php' ) : array();
    if ( ! is_array( $faqs ) ) {
      $faqs = array();
    }
    ?>
    <section class="mb-6" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="na-guide-h2 !mt-0">Frequently asked questions about preventing computer sleep</h2>
      <div class="space-y-4">
        <?php foreach ( $faqs as $faq ) : ?>
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
    // TOC mini-card matches the page CTA (downloads), not checkout; sticky Buy bar below uses checkout (Prompt K).
    noaway_render_guide_layout(
      $noaway_guide_body,
      array(
        'buy_url'   => $download_url,
        'buy_label' => 'Download NoAway',
        'tracked'   => false,
        'position'  => 'guide-toc',
      )
    );
    ?>
  </article>

  <?php
  $noaway_cta_link_class = 'text-white font-semibold underline underline-offset-2 hover:no-underline inline-flex items-center min-h-[44px]';
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'section_id'         => 'download',
      'title'              => 'Prevent computer sleep and keep your computer awake',
      'lines'              => array(
        '<a href="' . esc_url( $download_url ) . '" class="text-white font-semibold underline underline-offset-2 hover:no-underline">Get NoAway for Mac and Windows</a> — one-time purchase, lifetime updates.',
      ),
      'button_url'         => $download_url,
      'button_label'       => 'Download NoAway',
      'cta_position'       => 'none',
      'before_button_html' => noaway_capture_mobile_email_box( true ),
      'secondary_html'     => '<p class="flex flex-wrap justify-center items-center gap-x-2"><a href="' . esc_url( noaway_faq_page_url() ) . '" class="' . $noaway_cta_link_class . '">FAQ</a> <span aria-hidden="true">·</span> <a href="' . esc_url( noaway_help_page_url() ) . '" class="' . $noaway_cta_link_class . '">Help</a></p>',
    )
  );
  ?>
  <section class="px-6 pb-12 md:pb-16">
    <div class="max-w-5xl mx-auto">
      <?php noaway_render_before_you_buy( 'en', 'horizontal' ); ?>
    </div>
  </section>
</main>
<?php
if ( function_exists( 'noaway_render_sticky_buy_bar' ) ) {
  noaway_render_sticky_buy_bar( array( 'label' => 'Buy NoAway – ' . noaway_price_label() ) );
}
get_footer();
