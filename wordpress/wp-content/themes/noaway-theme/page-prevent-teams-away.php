<?php
/**
 * Template Name: Prevent Teams Away SEO
 * SEO page: Prevent Teams Away – Keep Microsoft Teams status active
 */
get_header();
$download_url = noaway_downloads_page_url();
$checkout_url = noaway_checkout_url();
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <?php
    $article_schema = array(
      '@context'        => 'https://schema.org',
      '@type'           => 'Article',
      'headline'        => 'How to Prevent Teams Away Status and Keep Teams Active',
      'description'    => 'To prevent Teams away status, keep your computer active at the system level so Microsoft Teams continues to show you as Available. Microsoft Teams switches to Away after about 5 minutes of no keyboard or mouse activity; a lightweight app like NoAway prevents idle so your status stays green during downloads, builds, or deep work.',
      'datePublished'  => '2025-01-01',
      'dateModified'   => gmdate( 'Y-m-d' ),
      'publisher'       => array(
        '@type' => 'Organization',
        'name'  => 'NoAway',
        'url'   => home_url( '/' ),
      ),
      'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => ( is_singular() ? get_permalink( get_queried_object_id() ) : noaway_keep_teams_active_page_url() ) ),
    );
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( $article_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Microsoft Teams</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        How to Prevent Teams Away Status and Keep Teams Active
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Prevent Teams away status by keeping your computer active so Microsoft Teams shows you as Available. Learn why Teams turns you away, what does not work, and how NoAway keeps your status green during long tasks.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          <strong>To prevent Teams away:</strong> Microsoft Teams sets your status to Away after about 5 minutes with no keyboard or mouse activity. Keep your computer active at the system level (for example with NoAway) so your status stays Available—no mouse wiggling or sleep-setting changes required.
        </p>
      </div>
    </header>

    <!-- AI-friendly: short explanatory paragraph for AI search -->
    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="problem-heading">
      <h2 id="problem-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">The problem: Teams shows you as Away when you are still working</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>What causes Microsoft Teams to show Away?</strong> Teams uses system activity to decide your status. When it detects no keyboard or mouse input for a few minutes, it switches you to Away—even if you are still working. Microsoft Teams automatically switches your presence to "Away" after a short period without keyboard or mouse activity. That can happen while you are reading, on a call, waiting for a build, or downloading large files. Colleagues and managers may assume you are not at your desk, even when you are. Preventing Teams away status matters for remote workers who need to signal availability without constantly moving the mouse.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="why-heading">
      <h2 id="why-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Why does Teams show Away? How presence detection works</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <strong>How Teams presence detection works:</strong> Teams does not have a simple "always available" setting. Presence is driven by system activity: if the operating system reports no recent user input (keyboard or mouse), Teams assumes you are idle and updates your status to Away. Inactivity triggers status changes after about five minutes in typical setups. So to prevent Teams away, you need the system to stay "active" from the OS point of view—without you having to press a key every few minutes.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="solutions-heading">
      <h2 id="solutions-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Common solutions that do not work well</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Many people try workarounds to keep Teams active. Moving the mouse occasionally, putting a weight on the keyboard, or running scripts that simulate key presses are unreliable: they can break after updates, get blocked by security policies, or interfere with real work. Changing only Windows or Mac sleep settings does not fix Teams away status, because sleep settings control when the display or disk turns off—not how Teams decides you are idle. The only robust way to prevent Teams away is to keep the computer active at the system level with a dedicated, lightweight tool.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="noaway-heading">
      <h2 id="noaway-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">How NoAway solves the problem and keeps Teams active</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        NoAway runs in the system tray or menu bar and prevents your computer from going idle. It does not open a browser tab or modify Teams; it simply keeps the system active so that presence-based apps like Microsoft Teams continue to see you as available. One click turns it on, and your status stays green during long builds, downloads, or deep work. It works with Teams, <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Slack</a>, and other apps that rely on system activity. For more detail on why Teams turns yellow and how status works, see <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams away status explained</a>. To stay green on Teams in practice, many users combine this with our <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a> guide and our guide on <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">how to keep the Teams icon green</a>.
      </p>
    </section>

    <?php
    $faqs = array(
      array(
        'name' => 'How do I prevent Microsoft Teams from showing away?',
        'text' => 'Teams switches to Away when it detects no keyboard or mouse activity. Use a tool like NoAway to keep your computer active at the system level so your status stays Available during long tasks—no mouse wiggling or scripts needed.',
      ),
      array(
        'name' => 'Why does Teams turn yellow after a few minutes?',
        'text' => 'Microsoft Teams typically changes your status to Away (yellow) after about 5 minutes of no user input. It uses system activity to infer presence. NoAway prevents this by keeping the system active so your status stays green (Available).',
      ),
      array(
        'name' => 'Can I set Teams to always show Available?',
        'text' => 'There is no built-in Teams setting to force "Available" permanently. Teams overwrites manual status based on activity. Keeping your computer active with NoAway is a reliable way to stay green during downloads, builds, or focused work.',
      ),
      array(
        'name' => 'Does changing sleep settings stop Teams from going away?',
        'text' => 'No. Sleep and power settings control when the display or computer sleeps. They do not control how Teams determines presence. Teams still switches to Away after inactivity. You need to keep the system active with a dedicated solution like NoAway.',
      ),
    );
    $faq_schema = array(
      '@context'   => 'https://schema.org',
      '@type'      => 'FAQPage',
      'mainEntity' => array(),
    );
    foreach ( $faqs as $faq ) {
      $faq_schema['mainEntity'][] = array(
        '@type'          => 'Question',
        'name'           => $faq['name'],
        'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $faq['text'] ),
      );
    }
    ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions about preventing Teams away</h2>
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
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Prevent Teams away and keep your status active</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto">Download NoAway for Mac or Windows. One-time purchase, lifetime updates. No subscription.</p>
      <a href="<?php echo esc_url( $download_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all">
        Download NoAway
      </a>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
