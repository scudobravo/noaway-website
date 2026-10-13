<?php
/**
 * Template Name: Features NoAway
 * Pagina Features - Dettaglio funzionalità e confronto
 */
get_header();
?>
<main>
  <!-- Hero Section -->
  <section class="py-20 px-6 max-w-7xl mx-auto text-center">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
      <span class="material-symbols-outlined text-sm">settings_suggest</span>
      Powerful Simplicity
    </div>
    <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight">Built to stay out of <br><span class="text-primary">your way.</span></h1>
    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
      NoAway is designed to solve one problem simply: keeping your computer active when you need it, with minimal setup and no unnecessary complexity. Read our guides to <a href="<?php echo esc_url( noaway_prevent_computer_sleep_page_url() ); ?>" class="text-primary font-semibold hover:underline">prevent computer sleep</a>, <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a>, and <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Slack active</a>.
    </p>
  </section>

  <!-- Deep Dive Features -->
  <section class="py-20 px-6 max-w-7xl mx-auto" aria-labelledby="features-heading">
    <h2 id="features-heading" class="sr-only">Features</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">dock_to_bottom</span>
        <h3 class="text-xl font-bold mb-3">Lightweight Tray App</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          NoAway lives in your menu bar on macOS and in your system tray on Windows, so it's always available without interrupting your workflow.
        </p>
      </div>
      <!-- Feature 2 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">devices</span>
        <h3 class="text-xl font-bold mb-3">Mac &amp; Windows</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          NoAway works on both macOS and Windows, giving you the same simple experience across your devices.
        </p>
      </div>
      <!-- Feature 3 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">memory</span>
        <h3 class="text-xl font-bold mb-3">Minimal Resource Usage</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          NoAway runs quietly in the background and is designed to use very little CPU and memory during normal use.
        </p>
      </div>
      <!-- Feature 4 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">verified_user</span>
        <h3 class="text-xl font-bold mb-3">Simple Setup</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          Install it, activate it, and turn it on. No complicated setup, no hidden system menus, and no need to constantly adjust power settings.
        </p>
      </div>
      <!-- Feature 5 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">rocket_launch</span>
        <h3 class="text-xl font-bold mb-3">Automatic Startup</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          Launch NoAway automatically when your computer starts, so it's ready whenever you need to stay active.
        </p>
      </div>
      <!-- Feature 6 -->
      <div class="p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-colors">
        <span class="material-symbols-outlined text-primary text-4xl mb-4">timer</span>
        <h3 class="text-xl font-bold mb-3">Scheduled Wake</h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
          Keep your computer active for a fixed amount of time — perfect for downloads, builds, presentations, or long-running tasks.
        </p>
      </div>
    </div>
  </section>

  <!-- Technical Specs Section -->
  <section class="py-20 bg-slate-100 dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
      <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-video bg-slate-800" data-alt="Visual representing light resource usage">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="text-center p-6 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
            <div class="text-xl font-bold text-white mb-1">Light on system resources</div>
            <div class="text-white/70 text-sm">Designed to run quietly in the background</div>
          </div>
        </div>
      </div>
      <div>
        <h2 class="text-3xl font-bold mb-6">Built for real work</h2>
        <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
          NoAway is built for people who spend long hours at their computer and need a simple way to prevent idle interruptions during important work. It stays out of the way, starts quickly, and fits naturally into everyday workflows.
        </p>
        <ul class="space-y-4">
          <li class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <span>Runs quietly in the background</span>
          </li>
          <li class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <span>Simple tray-first design</span>
          </li>
          <li class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <span>Designed for long work sessions</span>
          </li>
          <li class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">check_circle</span>
            <span>Works across macOS and Windows</span>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Comparison Table -->
  <section class="py-24 px-6 max-w-5xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold mb-4">How it compares</h2>
      <p class="text-slate-600 dark:text-slate-400">Why use NoAway instead of changing system sleep settings manually?</p>
    </div>
    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-slate-50 dark:bg-slate-900">
            <th class="p-6 font-bold border-b border-slate-200 dark:border-slate-800">Feature</th>
            <th class="p-6 font-bold border-b border-slate-200 dark:border-slate-800">Standard OS Settings</th>
            <th class="p-6 font-bold border-b border-slate-200 dark:border-slate-800 text-primary">NoAway</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
          <tr>
            <td class="p-6">Activation</td>
            <td class="p-6 text-slate-500">Requires opening system settings</td>
            <td class="p-6 font-semibold">One click from the tray or menu bar</td>
          </tr>
          <tr>
            <td class="p-6">Temporary usage</td>
            <td class="p-6 text-slate-500">Manual changes you need to remember to undo</td>
            <td class="p-6 font-semibold">Scheduled Wake presets for fixed durations</td>
          </tr>
          <tr>
            <td class="p-6">Visibility</td>
            <td class="p-6 text-slate-500">Often hidden inside system menus</td>
            <td class="p-6 font-semibold">Always accessible while you work</td>
          </tr>
          <tr>
            <td class="p-6">Startup</td>
            <td class="p-6 text-slate-500">Usually needs manual adjustment</td>
            <td class="p-6 font-semibold">Optional automatic startup</td>
          </tr>
          <tr>
            <td class="p-6">Daily workflow</td>
            <td class="p-6 text-slate-500">Built for system-wide settings</td>
            <td class="p-6 font-semibold">Built for work sessions, downloads, and long tasks</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Workflow Integration -->
  <section class="py-20 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold mb-4">Fits your daily routine</h2>
      <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Whether you're working remotely, building software, presenting, or downloading large files, NoAway helps you stay uninterrupted.</p>
    </div>
    <div class="grid md:grid-cols-2 gap-12">
      <div class="flex gap-6 items-start">
        <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-primary">code</span>
        </div>
        <div>
          <h4 class="text-xl font-bold mb-2">Long Builds &amp; Renders</h4>
          <p class="text-slate-600 dark:text-slate-400">Keep your computer active while builds, exports, or rendering jobs run in the background.</p>
        </div>
      </div>
      <div class="flex gap-6 items-start">
        <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-primary">present_to_all</span>
        </div>
        <div>
          <h4 class="text-xl font-bold mb-2">Presentations &amp; Meetings</h4>
          <p class="text-slate-600 dark:text-slate-400">Prevent your computer from going idle during webinars, presentations, or long calls.</p>
        </div>
      </div>
      <div class="flex gap-6 items-start">
        <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-primary">cloud_download</span>
        </div>
        <div>
          <h4 class="text-xl font-bold mb-2">Large Downloads &amp; Transfers</h4>
          <p class="text-slate-600 dark:text-slate-400">Let downloads and large file transfers finish without your computer going idle at the wrong time.</p>
        </div>
      </div>
      <div class="flex gap-6 items-start">
        <div class="size-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-primary">monitoring</span>
        </div>
        <div>
          <h4 class="text-xl font-bold mb-2">Remote Work Sessions</h4>
          <p class="text-slate-600 dark:text-slate-400">Stay active and avoid unnecessary interruptions while you work through long tasks at your desk.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA -->
  <section class="py-24 px-6">
    <div class="max-w-4xl mx-auto rounded-3xl bg-primary p-12 text-center text-white relative overflow-hidden shadow-2xl">
      <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
      <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl -ml-32 -mb-32"></div>
      <h2 class="text-4xl font-black mb-6 relative z-10">Stay active when it matters most.</h2>
      <p class="text-primary-100 text-lg mb-6 max-w-xl mx-auto opacity-90 relative z-10">
        A simple tool for keeping your computer active during work, meetings, downloads, and long-running tasks.
      </p>
      <p class="text-white/90 text-base mb-8 relative z-10">Launch price <?php echo esc_html( noaway_price_label() ); ?> — Regular price <?php echo esc_html( noaway_regular_price_label() ); ?></p>
      <div class="flex flex-col items-center justify-center gap-3 relative z-10">
        <div class="max-w-md mx-auto mb-4 text-left">
          <?php noaway_render_mobile_email_link_box(); ?>
        </div>
        <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-slate-100 transition-colors shadow-xl inline-block text-center"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
          Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
        </a>
        <p class="text-white/80 text-sm">Mac &amp; Windows · one-time payment · instant download after purchase</p>
      </div>
      <p class="mt-8 text-white/60 text-sm">One-time purchase. <?php echo esc_html( noaway_fact( 'license.lifetime_updates_short' ) ); ?></p>
    </div>
  </section>
</main>
<?php get_footer(); ?>
