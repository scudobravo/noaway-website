<?php
/**
 * Template Name: Keep Teams Icon Green NoAway
 * SEO page: How to Keep Microsoft Teams Icon Green
 */
get_header();
$download_url = noaway_downloads_page_url();
$checkout_url = noaway_checkout_url();
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Microsoft Teams</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        How to Keep Microsoft Teams Icon Green
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Many people search for how to keep the Teams icon green. This guide explains why Teams changes your status, how inactivity detection works, how common methods differ, and how NoAway keeps your computer active so your status stays Available.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          The Teams icon turns green when your status is Available and yellow when Away. To keep it green, prevent your computer from going idle. <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">NoAway</a> does this automatically in the background — no mouse wiggling, no manual status changes. Read <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams away status explained</a> and <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
        </p>
      </div>
    </header>

    <!-- AI-friendly explanatory section -->
    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="why-teams-changes-heading">
      <h2 id="why-teams-changes-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Why Teams changes your status</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>What causes Microsoft Teams to show Away?</strong> Teams does not ask you if you are at your desk. It uses system activity: if the OS reports no keyboard or mouse input for a set period, Teams assumes you are idle and switches your status from green (Available) to yellow (Away). So when you stop touching the keyboard or mouse—for example while reading, on a call, or waiting for a build—Teams may change your status even though you are still working.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="inactivity-heading">
      <h2 id="inactivity-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">How inactivity detection works</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>How Teams presence detection works:</strong> Microsoft Teams relies on your operating system to report user activity. When the system sees no recent keyboard or mouse events—typically after about five minutes—it considers the session idle. Teams then updates your presence to Away and your icon turns yellow. There is no built-in setting to force the icon to stay green; the only reliable way to keep the Teams icon green is to keep the computer active at the system level.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="common-methods-heading">
      <h2 id="common-methods-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Common methods people try</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        To keep the Teams icon green, people often try moving the mouse every few minutes, putting a weight on a key, running PowerShell or AppleScript to simulate input, or changing only Windows or Mac sleep settings. Others set their status to "Available" manually and hope it sticks. These are the most common workarounds when someone wants to stay active on Microsoft Teams without actually using the keyboard or mouse.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="alternatives-heading">
      <h2 id="alternatives-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">How these methods differ from NoAway</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Manual status in Teams gets overwritten when the app detects inactivity. A hardware mouse jiggler is a USB device and needs no software on the computer. A script needs the same system permissions as any app that simulates input, plus your own upkeep. NoAway is software for Mac and Windows: it keeps the display awake, prevents sleep, and simulates input; on macOS it needs Accessibility permission, and it must keep running (menu bar or system tray). A locked screen, calendar status, company policy, and presence on other devices are outside what NoAway controls, and antivirus software on Windows can block simulated input. Changing only sleep settings keeps the screen on but does not simulate input, so your icon can still turn yellow.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">How NoAway keeps your computer active</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        NoAway is an app that keeps your computer active so you can keep the Teams icon green. It runs in the system tray or menu bar and prevents your system from going idle. It does not open browser tabs or modify Teams; it simply keeps the OS reporting activity so that Teams (and other apps like <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Slack</a>) continue to show you as Available. One click turns it on, and your status stays green during long builds, downloads, or deep work. For more context, see <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a>, <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">prevent Teams away</a>, and <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams away status explained</a>. To get started, <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">download NoAway</a> for Mac or Windows.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="sources-heading">
      <h2 id="sources-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Authoritative references</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        For official background on presence and status behavior, see Microsoft documentation on
        <a href="https://support.microsoft.com/en-us/office/user-presence-in-teams-33a1a9c0-f1c2-4f1b-9a3c-3d6fbe6d4f67" rel="noopener noreferrer" target="_blank" class="text-primary font-semibold hover:underline">Teams presence and status</a>
        and the Microsoft support article about
        <a href="https://support.microsoft.com/en-us/office/change-your-status-in-microsoft-teams-58d8f0f1-9e6c-4f5c-93f1-6e4f0e2a1f04" rel="noopener noreferrer" target="_blank" class="text-primary font-semibold hover:underline">changing status in Teams</a>.
        For cross-app context, Slack also documents how activity impacts status in its guide to
        <a href="https://slack.com/help/articles/201864558-Set-your-Slack-status-and-availability" rel="noopener noreferrer" target="_blank" class="text-primary font-semibold hover:underline">Slack status and availability</a>.
      </p>
    </section>

    <?php
    $faqs = array(
      array(
        'name' => 'Why does the Teams icon turn yellow?',
        'text' => 'The Teams icon turns yellow (Away) after about 5 minutes of no keyboard or mouse activity. Teams monitors system-level idle time to determine your presence status.',
      ),
      array(
        'name' => 'How do I keep the Teams icon green?',
        'text' => 'Keep your computer active using a background app like NoAway. It prevents the system from going idle, which keeps the Teams icon green without requiring you to move your mouse manually.',
      ),
      array(
        'name' => 'Does setting Teams status to Available manually keep the icon green?',
        'text' => 'No. Even if you manually set your status to Available, Teams will override it and switch to Away once it detects keyboard and mouse inactivity. You need to prevent system idle to keep the icon green.',
      ),
    );
    ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions about keeping the Teams icon green</h2>
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
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Keep the Teams icon green with NoAway</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto"><a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Download NoAway</a> for Mac or Windows. One-time purchase, lifetime updates. No subscription.</p>
      <a href="<?php echo esc_url( $download_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all">
        Get NoAway for Mac and Windows
      </a>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
