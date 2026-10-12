<?php
/**
 * Template Name: Teams Away Status SEO
 * SEO page: Teams Away Status – What it is and how to fix it
 */
get_header();
$download_url = noaway_downloads_page_url();
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Microsoft Teams</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        Why Teams Shows Away, and After How Long
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Teams away status is the yellow presence Microsoft Teams shows when it thinks the computer is idle. This page explains what triggers that change and how long it takes. To keep the status Available, use the <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a> guide.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          Microsoft Teams switches to Away after approximately 5 minutes of no keyboard or mouse activity. That interval is not a setting you can change. Teams infers presence from the operating system, and it has no mode that forces Available. The practical steps for staying Available are in <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
        </p>
      </div>
    </header>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">The problem: your Teams status turns yellow (Away) when you are still there</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        In Microsoft Teams, "Away" is the status shown when the app detects no recent activity on your device. Your status turns yellow and colleagues may assume you are not at your desk. In reality you might be reading, on a video call, or waiting for a long-running task. Teams away status is a common frustration for remote workers who want to signal availability without constantly touching the keyboard or mouse.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="why-heading">
      <h2 id="why-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">What causes Teams away status? Why inactivity triggers status changes</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>What causes Microsoft Teams to show Away?</strong> Teams does not ask you directly if you are at your desk. <strong>How Teams presence detection works:</strong> It relies on system activity—keyboard and mouse input. If the operating system reports no user input for a set period—usually around five minutes—Teams assumes you are idle and switches your status to Away. There is no official "always available" option; the app is designed to reflect inferred activity. Reading, a call, or a build with no keystrokes all look the same to that check. How to stay Available is in the <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a> guide.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="next-heading">
      <h2 id="next-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Where to keep Teams Available</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        A manual Available status, a change to sleep settings, or a mouse jiggler does not change the five-minute idle check described above. The steps for Mac and Windows, including how to keep the icon green, are in <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
      </p>
    </section>

    <?php
    $faqs = array(
      array(
        'name' => 'How long before Teams shows Away?',
        'text' => 'Microsoft Teams switches your status to Away after approximately 5 minutes of keyboard and mouse inactivity. This cannot be changed in Teams settings.',
      ),
      array(
        'name' => 'Why does Teams show Away when I am still working?',
        'text' => 'Teams does not ask if you are at your desk. It reads keyboard and mouse activity from the operating system. Reading, a long call, or a build with no input looks idle, so the status turns Away.',
      ),
      array(
        'name' => 'Can Teams be set to stay Available permanently?',
        'text' => 'No. Teams has no setting that forces Available. It overwrites a manual status when it detects inactivity. How to keep the status Available is covered in the keep Teams active guide.',
      ),
    );
    ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions about Teams away status</h2>
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
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Keep reading: how to stay Available</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto">The timing above is why the status flips. The <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a> guide covers Mac, Windows, and the green icon. Or <a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">download NoAway</a>.</p>
      <div class="max-w-md mx-auto mb-4 text-left">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
      <a href="<?php echo esc_url( $download_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all">
        Get NoAway for Mac and Windows
      </a>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
