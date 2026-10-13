<?php
/**
 * Template Name: How it works NoAway
 * Pagina How it works - Come funziona NoAway, processo in 3 step, performance, sicurezza
 */
get_header();
?>
<main class="w-full">
  <!-- Hero Section -->
  <section class="relative py-20 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
      <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-6 bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-primary to-slate-900 dark:from-white dark:via-primary dark:to-white">
        How NoAway works
      </h1>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
        Install it once, enable it when needed, and your computer stays active automatically. No complicated setup and no hidden settings.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 max-w-2xl mx-auto text-left" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          NoAway is a tray app for Mac and Windows. Install it, enable Keep Active, and it prevents your computer from going idle. <?php echo esc_html( noaway_fact( 'benefit.full' ) ); ?> <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">See Help for the full list of conditions.</a> It does not open or modify Teams or Slack, and it does not access your files or messages.
        </p>
        <?php noaway_render_last_reviewed( 'page-how-it-works.php' ); ?>
      </div>
      <div class="mt-12 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xl">
        <div class="w-full aspect-video bg-slate-100 dark:bg-slate-900 flex items-center justify-center relative">
          <?php
			noaway_picture(
				'how-it-works-hero-section',
				'How NoAway works: system tray icon and Keep Active control on desktop',
				array(
					'class'   => 'object-cover w-full h-full',
					'width'   => 1200,
					'height'  => 630,
					'loading' => 'eager',
					'widths'  => array( 640, 960, 1200 ),
					'sizes'   => '(min-width: 1024px) 56rem, calc(100vw - 3rem)',
				)
			);
			?>
        </div>
      </div>
    </div>
  </section>

  <!-- The 3-Step Process -->
  <section class="py-24 px-6 bg-white dark:bg-slate-900/50">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold mb-4">The 3-Step Process</h2>
        <p class="text-slate-600 dark:text-slate-400">From installation to staying active in seconds.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-12 relative">
        <!-- Step 1 -->
        <div class="flex flex-col items-center text-center group">
          <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 border border-primary/20 group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <span class="material-symbols-outlined text-3xl">download_for_offline</span>
          </div>
          <h3 class="text-xl font-bold mb-3">1. Install</h3>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Download the application and install it like any normal desktop app on macOS or Windows.</p>
        </div>
        <!-- Step 2 -->
        <div class="flex flex-col items-center text-center group">
          <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 border border-primary/20 group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <span class="material-symbols-outlined text-3xl">ads_click</span>
          </div>
          <h3 class="text-xl font-bold mb-3">2. Enable</h3>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Open NoAway and enable the “Keep Active” mode from the tray or menu bar.</p>
        </div>
        <!-- Step 3 -->
        <div class="flex flex-col items-center text-center group">
          <div class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 border border-primary/20 group-hover:bg-primary group-hover:text-white transition-all duration-300">
            <span class="material-symbols-outlined text-3xl">bolt</span>
          </div>
          <h3 class="text-xl font-bold mb-3">3. Stay Active</h3>
          <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Your computer will remain active while NoAway is running, preventing the system from entering an idle state during long tasks.</p>
        </div>
      </div>
    </div>
  </section>

  <?php noaway_render_app_screenshots(); ?>

  <?php noaway_render_first_setup( noaway_help_page_url() . '#troubleshooting' ); ?>

  <!-- Under the Hood -->
  <section class="py-24 px-6">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl font-bold mb-6">Designed to stay out of your way</h2>
      <p class="text-lg text-slate-600 dark:text-slate-400 mb-10 leading-relaxed">
        NoAway runs quietly in the background and focuses on doing one thing well: preventing your computer from going idle when you need it to stay active.
      </p>
      <ul class="space-y-4 text-slate-600 dark:text-slate-400">
        <li class="flex items-center gap-3">
          <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
          Lightweight background operation
        </li>
        <li class="flex items-center gap-3">
          <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
          Simple tray-based controls
        </li>
        <li class="flex items-center gap-3">
          <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
          Compatible with macOS and Windows
        </li>
        <li class="flex items-center gap-3">
          <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
          Designed for long work sessions
        </li>
      </ul>
    </div>
  </section>

  <!-- Security & Privacy -->
  <section class="py-24 px-6 bg-slate-900 text-white rounded-t-[3rem] -mb-10">
    <div class="max-w-4xl mx-auto text-center">
      <div class="size-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-8">
        <span class="material-symbols-outlined text-primary text-3xl">shield_lock</span>
      </div>
      <h2 class="text-3xl font-bold mb-6">Security and privacy first</h2>
      <p class="text-slate-400 text-lg leading-relaxed mb-8">
        <?php echo esc_html( noaway_fact( 'data_sent.full' ) ); ?><br>
        The application simply prevents your computer from entering an idle state when the feature is enabled.
      </p>
      <div class="flex flex-wrap justify-center gap-6">
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          No activity or usage data sent
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          Only network request: license check (key + device id)
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          Works locally on your device
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA -->
  <section class="py-32 px-6 relative z-10 bg-background-light dark:bg-background-dark rounded-t-[3rem]">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-4xl md:text-5xl font-black mb-8">Ready to stay active?</h2>
      <div class="flex flex-col items-center gap-3">
        <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="bg-primary text-white px-8 py-4 rounded-xl font-bold inline-flex items-center justify-center gap-3 hover:scale-105 transition-transform"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
          Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
        </a>
        <div class="max-w-md mx-auto mt-4 text-left md:hidden">
          <?php noaway_render_mobile_email_link_box(); ?>
        </div>
        <p class="text-sm text-slate-500">Mac &amp; Windows · one-time payment · instant download after purchase</p>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
