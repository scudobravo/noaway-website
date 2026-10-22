<?php
/**
 * Template Name: How it works NoAway
 * Pagina How it works - Come funziona NoAway, processo in 3 step, performance, sicurezza
 */
get_header();
?>
<main class="w-full">
  <!-- Hero Section -->
  <section class="relative py-20 px-6 overflow-hidden" data-noaway-sticky-after>
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
      <h1 class="na-h1 mb-6">
        How NoAway works
      </h1>
      <p class="na-lead max-w-2xl mx-auto">
        Install it once, enable it when needed, and your computer stays active automatically. No complicated setup and no hidden settings.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 max-w-2xl mx-auto text-left" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
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

  <!-- Process: 3 steps + First setup -->
  <section class="py-12 md:py-24 px-6 bg-white dark:bg-slate-900/50" id="process">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-10">
        <h2 class="na-h2 mb-4">The 3-Step Process</h2>
        <p class="text-slate-600 dark:text-slate-400">From installation to staying active in seconds.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-6 md:gap-8 relative mb-16">
        <div class="hidden md:block absolute top-8 left-[16%] right-[16%] h-px bg-slate-200 dark:bg-slate-700" aria-hidden="true"></div>
        <div class="flex flex-col items-center text-center relative z-10">
          <div class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 border border-primary/20">
            <span class="material-symbols-outlined text-2xl">download_for_offline</span>
          </div>
          <h3 class="na-h3 mb-2">1. Install</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Download the application and install it like any normal desktop app on macOS or Windows.</p>
        </div>
        <div class="flex flex-col items-center text-center relative z-10">
          <div class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 border border-primary/20">
            <span class="material-symbols-outlined text-2xl">ads_click</span>
          </div>
          <h3 class="na-h3 mb-2">2. Enable</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Open NoAway and enable the “Keep Active” mode from the tray or menu bar.</p>
        </div>
        <div class="flex flex-col items-center text-center relative z-10">
          <div class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4 border border-primary/20">
            <span class="material-symbols-outlined text-2xl">bolt</span>
          </div>
          <h3 class="na-h3 mb-2">3. Stay Active</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">Your computer will remain active while NoAway is running, preventing the system from entering an idle state during long tasks.</p>
        </div>
      </div>
      <?php noaway_render_first_setup( noaway_help_page_url() . '#troubleshooting', true ); ?>
    </div>
  </section>

  <?php noaway_render_app_screenshots(); ?>

  <!-- Under the Hood -->
  <section class="py-12 md:py-24 px-6">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-start">
      <div>
        <h2 class="na-h2 mb-6">Designed to stay out of your way</h2>
        <p class="na-lead mb-10">
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
      <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 aspect-video bg-slate-100">
        <?php
        noaway_picture(
          'landing-hero-section',
          'Desktop with the NoAway window open',
          array(
            'class'   => 'w-full h-full object-cover',
            'width'   => 1200,
            'height'  => 630,
            'loading' => 'lazy',
            'widths'  => array( 600, 640, 960, 1200 ),
            'sizes'   => '(min-width: 1024px) 28rem, calc(100vw - 3rem)',
          )
        );
        ?>
      </div>
    </div>
  </section>

  <!-- Security & Privacy -->
  <section class="py-12 md:py-24 px-6">
    <div class="na-dark-section p-10 md:p-16 text-center">
      <div class="size-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-8">
        <span class="material-symbols-outlined text-primary text-3xl">shield_lock</span>
      </div>
      <h2 class="na-h2 text-white mb-6">Security and privacy first</h2>
      <p class="text-slate-300 text-lg leading-relaxed mb-8 max-w-3xl mx-auto">
        <?php echo esc_html( noaway_fact( 'data_sent.full' ) ); ?><br>
        The application simply prevents your computer from entering an idle state when the feature is enabled.
      </p>
      <div class="flex flex-wrap justify-center gap-6">
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          No keystrokes, screen, chats, or files
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          License checks may include limited usage fields
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-300">
          <span class="material-symbols-outlined text-emerald-400 text-sm">check_circle</span>
          Keep Active runs locally on your device
        </div>
      </div>
    </div>
  </section>

  <?php
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'title'        => 'Ready to stay active?',
      'button_url'   => noaway_checkout_url(),
      'button_label' => 'Buy NoAway – ' . noaway_price_label(),
      'meta'         => 'Mac & Windows · one-time payment · instant download after purchase',
      'cta_position' => 'footer-cta',
      'before_button_html' => ( function () {
        ob_start();
        echo '<div class="max-w-md mx-auto mt-4 text-left md:hidden">';
        noaway_render_mobile_email_link_box();
        echo '</div>';
        return ob_get_clean();
      } )(),
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
