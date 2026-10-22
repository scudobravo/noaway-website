<?php
/**
 * Template Name: Features NoAway
 * Pagina Features - Dettaglio funzionalità e confronto
 */
get_header();
?>
<main>
  <!-- Hero Section -->
  <section class="py-12 md:py-20 px-6 max-w-7xl mx-auto" data-noaway-sticky-after>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
      <div class="text-left">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
          <span class="material-symbols-outlined text-sm">settings_suggest</span>
          Powerful Simplicity
        </div>
        <h1 class="na-h1 mb-6" style="text-wrap:balance">Built to stay out of <br><span class="text-primary">your way.</span></h1>
        <p class="na-lead">
      NoAway is designed to solve one problem simply: keeping your computer active when you need it, with minimal setup and no unnecessary complexity. Read our guides to <a href="<?php echo esc_url( noaway_prevent_computer_sleep_page_url() ); ?>" class="text-primary font-semibold hover:underline">prevent computer sleep</a>, <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Teams active</a>, and <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">keep Slack active</a>.
        </p>
      </div>
      <div class="relative rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-3 sm:p-4 shadow-2xl">
        <div class="aspect-[1408/768] rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800">
          <?php
          $noaway_features_copy = function_exists( 'noaway_i18n_landing_copy' ) ? noaway_i18n_landing_copy( 'teams', 'en' ) : array();
          noaway_picture(
            'landing-solution-section',
            isset( $noaway_features_copy['solution_alt'] ) ? $noaway_features_copy['solution_alt'] : 'NoAway Keep Active window on desktop',
            array(
              'class'         => 'w-full h-full object-cover',
              'width'         => 1200,
              'height'        => 655,
              'fetchpriority' => 'high',
              'widths'        => array( 600, 1200 ),
              'sizes'         => '(min-width: 1024px) 36rem, calc(100vw - 3rem)',
            )
          );
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Deep Dive Features -->
  <section class="py-20 px-6 max-w-7xl mx-auto" aria-labelledby="features-heading">
    <h2 id="features-heading" class="sr-only">Features</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Feature 1 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">dock_to_bottom</span></span>
        <h3 class="na-h3 mb-3">Lightweight Tray App</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          NoAway lives in your menu bar on macOS and in your system tray on Windows, so it's always available without interrupting your workflow.
        </p>
      </div>
      <!-- Feature 2 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">devices</span></span>
        <h3 class="na-h3 mb-3">Mac &amp; Windows</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          NoAway works on both macOS and Windows, giving you the same simple experience across your devices.
        </p>
      </div>
      <!-- Feature 3 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">memory</span></span>
        <h3 class="na-h3 mb-3">Minimal Resource Usage</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          NoAway runs quietly in the background and is designed to use very little CPU and memory during normal use.
        </p>
      </div>
      <!-- Feature 4 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">verified_user</span></span>
        <h3 class="na-h3 mb-3">Simple Setup</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          Install it, activate it, and turn it on. No complicated setup, no hidden system menus, and no need to constantly adjust power settings.
        </p>
      </div>
      <!-- Feature 5 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">rocket_launch</span></span>
        <h3 class="na-h3 mb-3">Automatic Startup</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          Launch NoAway automatically when your computer starts, so it's ready whenever you need to stay active.
        </p>
      </div>
      <!-- Feature 6 -->
      <div class="p-6 sm:p-8 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary/40 transition-colors">
        <span class="na-icon-box mb-5"><span class="material-symbols-outlined" style="font-size:24px" aria-hidden="true">timer</span></span>
        <h3 class="na-h3 mb-3">Scheduled Wake</h3>
        <p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed">
          Keep your computer active for a fixed amount of time — perfect for downloads, builds, presentations, or long-running tasks.
        </p>
      </div>
    </div>
  </section>

  <!-- Technical Specs Section -->
  <section class="py-20 bg-slate-100 dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
      <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-video bg-slate-100">
        <?php
        noaway_picture(
          'how-it-works-hero-section',
          'NoAway Keep Active window on desktop',
          array(
            'class'   => 'w-full h-full object-cover',
            'width'   => 1200,
            'height'  => 675,
            'loading' => 'lazy',
            'widths'  => array( 600, 640, 960, 1200 ),
            'sizes'   => '(min-width: 1024px) 36rem, calc(100vw - 3rem)',
          )
        );
        ?>
        <div class="absolute bottom-4 left-4 px-3 py-2 rounded-lg bg-white/95 dark:bg-slate-900/90 shadow-md border border-slate-200 dark:border-slate-700">
          <div class="text-sm font-bold text-slate-900 dark:text-white">Light on system resources</div>
          <div class="text-slate-600 dark:text-slate-300 text-xs mt-0.5">Designed to run quietly in the background</div>
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
  <section class="py-12 md:py-24 px-6 max-w-5xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold mb-4">How it compares</h2>
      <p class="text-slate-600 dark:text-slate-400">Why use NoAway instead of changing system sleep settings manually?</p>
    </div>
    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
      <table class="w-full text-left">
        <thead>
          <tr class="bg-slate-50 dark:bg-slate-900">
            <th class="p-4 sm:p-6 font-bold border-b border-slate-200 dark:border-slate-800">Feature</th>
            <th class="p-4 sm:p-6 font-bold border-b border-slate-200 dark:border-slate-800">Standard OS Settings</th>
            <th class="p-4 sm:p-6 font-bold border-b border-slate-200 dark:border-slate-800 text-primary">NoAway</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
          <tr class="bg-white dark:bg-slate-900/20">
            <td class="p-4 sm:p-6">Activation</td>
            <td class="p-4 sm:p-6 text-slate-600">Requires opening system settings</td>
            <td class="p-4 sm:p-6 font-semibold">One click from the tray or menu bar</td>
          </tr>
          <tr class="bg-slate-50/70 dark:bg-slate-800/30">
            <td class="p-4 sm:p-6">Temporary usage</td>
            <td class="p-4 sm:p-6 text-slate-600">Manual changes you need to remember to undo</td>
            <td class="p-4 sm:p-6 font-semibold">Scheduled Wake presets for fixed durations</td>
          </tr>
          <tr class="bg-white dark:bg-slate-900/20">
            <td class="p-4 sm:p-6">Visibility</td>
            <td class="p-4 sm:p-6 text-slate-600">Often hidden inside system menus</td>
            <td class="p-4 sm:p-6 font-semibold">Always accessible while you work</td>
          </tr>
          <tr class="bg-slate-50/70 dark:bg-slate-800/30">
            <td class="p-4 sm:p-6">Daily workflow</td>
            <td class="p-4 sm:p-6 text-slate-600">Built for system-wide settings</td>
            <td class="p-4 sm:p-6 font-semibold">Built for work sessions, downloads, and long tasks</td>
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

  <?php
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'title'        => 'Stay active when it matters most.',
      'subtitle'     => 'A simple tool for keeping your computer active during work, meetings, downloads, and long-running tasks.',
      'lines'        => array(
        'Launch price ' . esc_html( noaway_price_label() ) . ' — Regular price ' . esc_html( noaway_regular_price_label() ),
        'One-time purchase. ' . esc_html( noaway_fact( 'license.lifetime_updates_short' ) ),
      ),
      'button_url'   => noaway_checkout_url(),
      'button_label' => 'Buy NoAway – ' . noaway_price_label(),
      'meta'         => 'Mac & Windows · one-time payment · instant download after purchase',
      'cta_position' => 'footer-cta',
      'before_button_html' => ( function_exists( 'noaway_render_mobile_email_link_box' ) ? ( function () {
        ob_start();
        echo '<div class="max-w-md mx-auto mt-4 text-left md:hidden">';
        noaway_render_mobile_email_link_box( array( 'on_primary' => true ) );
        echo '</div>';
        return ob_get_clean();
      } )() : '' ),
    )
  );
  ?>
</main>
<?php
if ( function_exists( 'noaway_render_sticky_buy_bar' ) ) {
	noaway_render_sticky_buy_bar( array( 'label' => function_exists( 'noaway_i18n_buy_cta_label' ) ? noaway_i18n_buy_cta_label() : ( 'Buy NoAway – ' . noaway_price_label() ) ) );
}
?>
<?php get_footer(); ?>
