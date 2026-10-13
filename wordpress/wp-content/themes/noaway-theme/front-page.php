<?php
/**
 * Template Name: Homepage NoAway
 * Front Page - Corrispondente al template home.html
 */
get_header();
?>
    <!-- Hero Section -->
    <section class="relative pt-8 pb-16 lg:pt-10 overflow-hidden">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">
          <div class="flex-1 text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold mb-4 border border-primary/20">
              <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
              </span>
              Anti-idle engine v2.0
            </div>
            <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight mb-4">Keep Teams and Slack from going Away</h1>
            <p class="text-lg lg:text-xl font-medium text-slate-700 dark:text-slate-300 mb-5">NoAway for Mac and Windows. One-time <?php echo esc_html( noaway_price_label() ); ?> (regular <?php echo esc_html( noaway_regular_price_label() ); ?>) — keeps this computer from going idle so Teams and Slack are less likely to show Away.</p>
            <p class="text-slate-600 dark:text-slate-400 text-sm mb-5"><?php echo esc_html( noaway_fact( 'benefit.full' ) ); ?> <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a></p>
            <div class="flex flex-col items-start gap-3 w-full max-w-md">
              <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="bg-primary text-white px-8 py-4 rounded-xl font-bold inline-flex items-center gap-3 hover:scale-105 transition-transform shadow-lg shadow-primary/25"<?php echo noaway_buy_cta_attrs( 'hero' ); ?>>
                Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
              </a>
              <?php noaway_render_mobile_email_link_box(); ?>
              <p class="text-slate-500 dark:text-slate-400 text-sm">Mac &amp; Windows · one-time payment · instant download after purchase</p>
              <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo noaway_refund_near_price_html( 'en' ); ?></p>
              <?php noaway_render_before_you_buy( 'en' ); ?>
            </div>
            <p class="text-slate-600 dark:text-slate-400 text-base mt-4">See <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Teams</a>, <a href="<?php echo esc_url( noaway_teams_away_status_page_url() ); ?>" class="text-primary font-semibold hover:underline">why Teams shows Away</a>, <a href="<?php echo esc_url( noaway_keep_slack_active_page_url() ); ?>" class="text-primary font-semibold hover:underline">Slack</a>, or <a href="<?php echo esc_url( noaway_prevent_computer_sleep_page_url() ); ?>" class="text-primary font-semibold hover:underline">sleep</a>.</p>
          </div>
          <div class="flex-1 relative w-full">
            <div class="absolute -inset-4 bg-primary/20 blur-3xl rounded-full opacity-30"></div>
            <div class="relative rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-4 shadow-2xl">
              <div class="aspect-video rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800 flex items-center justify-center relative">
                <div class="absolute top-4 right-4 flex items-center gap-2 bg-white/80 dark:bg-slate-900/80 backdrop-blur px-3 py-1.5 rounded-full border border-green-500/30">
                  <div class="size-2 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e]"></div>
                  <span class="text-[10px] font-bold text-green-500 uppercase">Available</span>
                </div>
                <?php
				noaway_picture(
					'landing-hero-section',
					'Desktop with the NoAway window open and a green Available indicator in the corner',
					array(
						'class'         => 'w-full h-full object-cover',
						'width'         => 1200,
						'height'        => 630,
						'fetchpriority' => 'high',
						'widths'        => array( 640, 960, 1200 ),
						'sizes'         => '(min-width: 1024px) 36rem, calc(100vw - 3rem)',
					)
				);
				?>
              </div>
            </div>
            <div class="absolute -z-10 -top-20 -right-20 w-64 h-64 bg-primary/20 blur-3xl rounded-full"></div>
            <div class="absolute -z-10 -bottom-20 -left-20 w-64 h-64 bg-indigo-500/10 blur-3xl rounded-full"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="pb-12 px-6">
      <div class="max-w-3xl mx-auto">
        <?php noaway_render_controls_note( 'en' ); ?>
      </div>
    </section>

    <!-- Why people use NoAway (situations, not reviews) -->
    <section class="py-16 px-6" id="why-people-use-noaway" aria-labelledby="why-people-use-noaway-heading">
      <div class="max-w-6xl mx-auto">
        <h2 id="why-people-use-noaway-heading" class="text-3xl font-black mb-10 text-center">Why people use NoAway</h2>
        <?php
        $noaway_situations = array(
          array( 'icon' => 'coffee',        'text' => 'Coffee break without the green-dot anxiety.' ),
          array( 'icon' => 'description',   'text' => 'Reading a long doc without Teams thinking you left.' ),
          array( 'icon' => 'terminal',      'text' => 'The 4-hour build finishes while you\'re in another meeting.' ),
          array( 'icon' => 'lunch_dining',  'text' => 'Lunch is lunch. Your status stays put.' ),
          array( 'icon' => 'mouse',         'text' => 'No more wiggling the mouse every few minutes.' ),
        );
        ?>
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 list-none p-0 m-0">
          <?php foreach ( $noaway_situations as $noaway_situation ) : ?>
          <li class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex flex-col gap-3">
            <span class="material-symbols-outlined text-primary text-3xl" aria-hidden="true"><?php echo esc_html( $noaway_situation['icon'] ); ?></span>
            <p class="text-slate-700 dark:text-slate-300 font-medium leading-snug m-0"><?php echo esc_html( $noaway_situation['text'] ); ?></p>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>

    <?php
    // Real customer reviews: add verified entries only. Empty array = nothing is rendered.
    // Each item: array( 'name' => '', 'role' => '', 'context' => '', 'date' => 'YYYY-MM-DD', 'text' => '' ).
    $noaway_real_reviews = array();
    if ( ! empty( $noaway_real_reviews ) ) :
    ?>
    <section class="py-12 px-6" id="customer-reviews" aria-labelledby="customer-reviews-heading">
      <div class="max-w-5xl mx-auto">
        <h2 id="customer-reviews-heading" class="text-2xl font-black mb-8 text-center">What customers say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <?php foreach ( $noaway_real_reviews as $noaway_review ) : ?>
          <figure class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
            <blockquote class="text-slate-700 dark:text-slate-300 leading-relaxed m-0"><?php echo esc_html( isset( $noaway_review['text'] ) ? $noaway_review['text'] : '' ); ?></blockquote>
            <figcaption class="mt-4 text-sm text-slate-500 dark:text-slate-400">
              <span class="font-semibold text-slate-700 dark:text-slate-300"><?php echo esc_html( isset( $noaway_review['name'] ) ? $noaway_review['name'] : '' ); ?></span>
              <?php if ( ! empty( $noaway_review['role'] ) ) : ?>, <?php echo esc_html( $noaway_review['role'] ); ?><?php endif; ?>
              <?php if ( ! empty( $noaway_review['context'] ) ) : ?><span class="block"><?php echo esc_html( $noaway_review['context'] ); ?></span><?php endif; ?>
              <?php if ( ! empty( $noaway_review['date'] ) ) : ?><time class="block" datetime="<?php echo esc_attr( $noaway_review['date'] ); ?>"><?php echo esc_html( $noaway_review['date'] ); ?></time><?php endif; ?>
            </figcaption>
          </figure>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- Social Proof -->
    <section class="py-12 border-y border-slate-200/60 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50">
      <style>
        .noaway-testimonials-scroll { height: 3.5rem; overflow: hidden; }
        .noaway-testimonials-inner { animation: noaway-scroll-up 28s linear infinite; }
        .noaway-testimonials-inner:hover { animation-play-state: paused; }
        .noaway-testimonial-line { height: 3.5rem; display: flex; align-items: center; justify-content: center; }
        @keyframes noaway-scroll-up { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }
      </style>
      <div class="max-w-7xl mx-auto px-6 flex flex-col items-center gap-6">
        <h2 class="text-slate-400 dark:text-slate-500 text-sm font-bold tracking-widest uppercase">Trusted by developers, remote workers and professionals worldwide</h2>
        <div class="noaway-testimonials-scroll w-full max-w-2xl mx-auto">
          <div class="noaway-testimonials-inner">
            <div class="noaway-testimonials-set">
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Slack stayed green while I reviewed a long spec on the other screen."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"That 4-hour build actually finished. No more 3am wake-ups."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Teams stayed Available through the render. I was on a call on my phone."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Download didn't die at 97%. Faith in humanity restored."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Screen stayed on during the whole demo. MVP material."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Set it and forget it. My laptop gets it."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"The only app that reliably keeps my long ML builds running overnight."</div>
            </div>
            <div class="noaway-testimonials-set" aria-hidden="true">
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Slack stayed green while I reviewed a long spec on the other screen."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"That 4-hour build actually finished. No more 3am wake-ups."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Teams stayed Available through the render. I was on a call on my phone."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Download didn't die at 97%. Faith in humanity restored."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Screen stayed on during the whole demo. MVP material."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"Set it and forget it. My laptop gets it."</div>
              <div class="noaway-testimonial-line text-slate-600 dark:text-slate-400 italic text-sm md:text-base">"The only app that reliably keeps my long ML builds running overnight."</div>
            </div>
          </div>
        </div>
        <div class="flex items-center gap-4 flex-wrap justify-center">
          <div class="flex -space-x-4">
            <div class="size-12 rounded-full border-4 border-background-light bg-slate-200 flex items-center justify-center overflow-hidden"><img alt="NoAway user avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZBf-V0UjD4P7svoeD_vhm_mEokdZCdO1YshvlowtFAho2gabwDvqOPq-mQD3vW7UjTqEQ7VMTnTSZgGA8uiXCcKY4sJyICjjVw4Oh2IUkOIbVP0DTs5jgd5YltaI2YdHku4cx9TTc8zrcEKXDSSymWoV34-xvktsbFjT1_1Nfh0uL0WtgHntAmUEVqr_VjHBhEGQB5ijJqylvW4u4JK40QT659da2EC7WoYcpxpSqeQ6k29KBtTQncBP5G2amXcy_36PfHIz6Df4f" width="48" height="48" loading="lazy"></div>
            <div class="size-12 rounded-full border-4 border-background-light bg-slate-200 flex items-center justify-center overflow-hidden"><img alt="NoAway user avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlNTErBvvt5f6kh7hDwn9R6v8LJxuDtVCdyf4-5uYhLI6VYyp7YSnzzyt1s-1Wa5fz86pAqSbwnyOozgueyl8rxx1iDjRaB_WT4e0TvZY6MoDyT-UNwq672mspTmjuaxUr9JKY3r7XFb0x86zyej8YpQqQ-W5N1_ufXxYdUEK4ZKvBo01bTZhW5rkCV4oUSVyRNfxvi6AHnZRSqcDfibHlYnazNd8ZC7FY0F_OGK6_ajnBbrL3dYUoFIVWKeJhIzmeNhhzLgTfglla" width="48" height="48" loading="lazy"></div>
            <div class="size-12 rounded-full border-4 border-background-light bg-slate-200 flex items-center justify-center overflow-hidden"><img alt="NoAway user avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHA57Yx1wwOOyVCm1R8vD_AihR6L2e5WkURSnVkVuoYq1SWVfXdThYdgWeddP_LNuJl_TWYDc-7DB69XfhMcGTogLez7rJV9XvidBIdLEfDNgbnkdgZutrwkWPuxbgxYEQnKSsASOmtM2jSkhlVnWwOBNe91Iw9m_zkUMM5ElrIHpu8vWOMHBURqDjYdQA51Nssn3PkSdkuA9bF9bzL9UmsvUmhBVyTgm7NjaHqp7PpLSTqpcMiWxg2p6pbWSBsO1_1MiW_JzTShCq" width="48" height="48" loading="lazy"></div>
            <div class="size-12 rounded-full border-4 border-background-light bg-slate-200 flex items-center justify-center overflow-hidden"><img alt="NoAway user avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD5YrcaPYa-xFCaZw5BAhzjuiJXBcmSjcXkuqouxbme8vh_U1SG68isujWy6eMzXwB1kQycZddvAo7rcoqcBXDWahnqEzGkkYo14QZxlQwOzCTG_om2zBZUIBD2VWciDqEDk9xfXk4d5tGL8HZ8-QTgdRaPe7WPO2NhJf_c3gmzqAu7Btq5M6TYnIrH2XsR1A8CnFAEwGvdtIVVhEypr5Nf9R7Xj0qqZLpED-HP6-vLPwLR1FYeFJ3w6BG4J-kJjeTE7QPsBuoo_PqD" width="48" height="48" loading="lazy"></div>
          </div>
          <p class="text-slate-600 dark:text-slate-400 font-medium">Used by remote workers, developers and IT pros<?php
            $noaway_social_proof = noaway_social_proof_label();
            if ( $noaway_social_proof !== '' ) {
              echo '<span class="block text-sm font-normal mt-1">' . esc_html( $noaway_social_proof ) . '</span>';
            }
          ?></p>
        </div>
      </div>
    </section>

    <!-- Problem Section -->
    <section class="py-32" id="features">
      <div class="max-w-7xl mx-auto px-6">
        <div class="mb-20 text-center">
          <h2 class="text-4xl font-black mb-4">Why your status suddenly turns Away—and how to keep Teams active</h2>
          <p class="text-slate-500 text-lg">Standard power settings can make your computer idle at the worst possible moment. Learn how to <a href="<?php echo esc_url( noaway_keep_teams_active_page_url() ); ?>" class="text-primary font-medium hover:underline">keep Teams active</a> and <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-medium hover:underline">get help</a> with setup.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow group">
            <span class="material-symbols-outlined text-primary text-3xl mb-4 group-hover:scale-110 transition-transform">download_for_offline</span>
            <h3 class="text-xl font-bold mb-2">Large Downloads</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Downloading files can take minutes or hours. Your computer goes idle — and your status turns Away.</p>
          </div>
          <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow group">
            <span class="material-symbols-outlined text-primary text-3xl mb-4 group-hover:scale-110 transition-transform">terminal</span>
            <h3 class="text-xl font-bold mb-2">Software Builds</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Developers often wait for builds and tests. Your machine is busy, but your status says you're inactive.</p>
          </div>
          <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow group">
            <span class="material-symbols-outlined text-primary text-3xl mb-4 group-hover:scale-110 transition-transform">home_work</span>
            <h3 class="text-xl font-bold mb-2">Remote Work</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">During remote work, appearing Away can create unnecessary stress or misunderstandings.</p>
          </div>
          <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow group">
            <span class="material-symbols-outlined text-primary text-3xl mb-4 group-hover:scale-110 transition-transform">co_present</span>
            <h3 class="text-xl font-bold mb-2">Presentations</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">While preparing slides or reading documentation, inactivity can change your status unexpectedly.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Solution/Features Section -->
    <section class="py-32 bg-slate-900 text-white rounded-[3rem] mx-4 overflow-hidden">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-20">
          <div class="lg:w-1/3">
            <h2 class="text-4xl lg:text-5xl font-black mb-8 leading-tight">Stay Active on Teams and Slack—automatically</h2>
            <p class="text-slate-400 text-lg mb-12">A lightweight app that runs in the background so your computer stays active while you work. No mouse jiggling and no scripts—set it during a build, a render, or a large download.</p>
            <a href="<?php echo esc_url( noaway_features_page_url() ); ?>" class="bg-primary text-white px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity inline-block">Explore all features</a>
          </div>
          <div class="lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div class="flex gap-4">
              <div class="size-12 shrink-0 bg-white/10 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined text-primary">flight</span></div>
              <div>
                <h3 class="font-bold text-lg mb-1">Ultra Lightweight</h3>
                <p class="text-slate-400 text-sm">Uses almost no CPU or memory and runs silently in the background.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="size-12 shrink-0 bg-white/10 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined text-primary">touch_app</span></div>
              <div>
                <h3 class="font-bold text-lg mb-1">Stays awake while you work</h3>
                <p class="text-slate-400 text-sm">Keeps your computer from going idle during long builds, renders, and large downloads, so your status does not flip to Away.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="size-12 shrink-0 bg-white/10 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined text-primary">visibility</span></div>
              <div>
                <h3 class="font-bold text-lg mb-1">Works with Teams, Slack and more</h3>
                <p class="text-slate-400 text-sm">Teams, Slack, and similar apps read that activity signal.</p>
              </div>
            </div>
            <div class="flex gap-4">
              <div class="size-12 shrink-0 bg-white/10 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined text-primary">power_settings_new</span></div>
              <div>
                <h3 class="font-bold text-lg mb-1">Auto Start</h3>
                <p class="text-slate-400 text-sm">Automatically runs when your computer boots.</p>
              </div>
            </div>
            <div class="flex gap-4 sm:col-span-2">
              <div class="size-12 shrink-0 bg-white/10 rounded-xl flex items-center justify-center"><span class="material-symbols-outlined text-primary">devices</span></div>
              <div>
                <h3 class="font-bold text-lg mb-1">Mac &amp; Windows</h3>
                <p class="text-slate-400 text-sm">Fully compatible with macOS and Windows.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- How it Works -->
    <section class="py-32" id="how-it-works">
      <div class="max-w-7xl mx-auto px-6">
        <div class="mb-20 text-center">
          <h2 class="text-4xl font-black mb-4">How it works</h2>
          <p class="text-slate-500 text-lg">Install → Enable → Stay Available.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
          <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-0.5 border-t border-dashed border-slate-300"></div>
          <div class="flex flex-col items-center text-center relative">
            <div class="size-24 rounded-3xl bg-white border-2 border-slate-100 flex items-center justify-center mb-8 shadow-sm z-10"><span class="material-symbols-outlined text-4xl text-primary">download</span></div>
            <h3 class="text-xl font-bold mb-3">1. Install</h3>
            <p class="text-slate-500 text-sm">Download for Mac or Windows and install in a few clicks.</p>
          </div>
          <div class="flex flex-col items-center text-center relative">
            <div class="size-24 rounded-3xl bg-white border-2 border-slate-100 flex items-center justify-center mb-8 shadow-sm z-10"><span class="material-symbols-outlined text-4xl text-primary">toggle_on</span></div>
            <h3 class="text-xl font-bold mb-3">2. Enable</h3>
            <p class="text-slate-500 text-sm">Turn on NoAway from the menu bar or system tray. One click.</p>
          </div>
          <div class="flex flex-col items-center text-center relative">
            <div class="size-24 rounded-3xl bg-white border-2 border-slate-100 flex items-center justify-center mb-8 shadow-sm z-10"><span class="material-symbols-outlined text-4xl text-primary">verified_user</span></div>
            <h3 class="text-xl font-bold mb-3">3. Keep this computer active</h3>
            <p class="text-slate-500 text-sm">Teams and Slack are less likely to show Away while you are still working. Calendar, a locked screen, and other devices can still change presence.</p>
          </div>
        </div>
      </div>
    </section>

    <?php noaway_render_app_screenshots(); ?>

    <!-- Perfect for -->
    <section class="py-32 bg-white dark:bg-slate-900">
      <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-black mb-16">Perfect for</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="flex flex-col items-center">
            <div class="size-16 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4"><span class="material-symbols-outlined">code</span></div>
            <h3 class="font-bold">Developers</h3>
          </div>
          <div class="flex flex-col items-center">
            <div class="size-16 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4"><span class="material-symbols-outlined">home_work</span></div>
            <h3 class="font-bold">Remote Workers</h3>
          </div>
          <div class="flex flex-col items-center">
            <div class="size-16 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4"><span class="material-symbols-outlined">palette</span></div>
            <h3 class="font-bold">Designers</h3>
          </div>
          <div class="flex flex-col items-center">
            <div class="size-16 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-4"><span class="material-symbols-outlined">school</span></div>
            <h3 class="font-bold">Students</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- SEO Section -->
    <section class="py-32 bg-slate-50 dark:bg-slate-900/50" id="teams-status">
      <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-black mb-8">How to keep Microsoft Teams active and keep the Teams icon green</h2>
        <div class="prose prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-400">
          <p class="mb-4">Many remote workers ask how to keep Teams active and prevent Teams away. Microsoft Teams automatically changes your status to Away after a few minutes of inactivity—so learning how to keep the Teams icon green matters.</p>
          <p class="mb-4">This can happen while you are:</p>
          <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>downloading files</li>
            <li>waiting for builds</li>
            <li>reading documentation</li>
            <li>attending meetings</li>
            <li>watching presentations</li>
          </ul>
          <p class="mb-4">Even though you are still working, your status may appear as inactive.</p>
          <p class="mb-4">NoAway prevents this by keeping your computer active automatically. Keep Teams Web App status as Active and follow the best practice for staying active: prevent your system from going idle.</p>
          <p class="mb-4">As long as NoAway is running, your system does not enter an idle state, helping apps like Microsoft Teams or Slack show Away less often.</p>
          <p class="mb-4">This simple tool removes the stress of unexpectedly appearing Away during important work.</p>
          <p>If you're searching for how to keep your status always online in Microsoft Teams or how you actually set Teams to always available, NoAway provides a simple one-click solution.</p>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="py-32" id="faq">
      <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-black mb-12 text-center">Frequently Asked Questions</h2>
        <div class="space-y-4">
          <?php foreach ( noaway_front_page_faqs() as $faq ) : ?>
          <details class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <summary class="flex cursor-pointer items-center justify-between p-6 list-none">
              <span class="font-bold"><?php echo esc_html( $faq['name'] ); ?></span>
              <span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
            </summary>
            <div class="px-6 pb-6 text-slate-500 dark:text-slate-400 text-sm leading-relaxed"><?php echo wp_kses_post( $faq['text'] ); ?></div>
          </details>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="py-32" id="download">
      <div class="max-w-7xl mx-auto px-6">
        <div class="bg-primary rounded-[3rem] p-12 lg:p-24 text-center text-white relative overflow-hidden shadow-2xl shadow-primary/40">
          <div class="absolute -top-24 -left-24 size-64 bg-white/10 blur-3xl rounded-full"></div>
          <div class="absolute -bottom-24 -right-24 size-96 bg-indigo-400/20 blur-3xl rounded-full"></div>
          <div class="relative z-10">
            <h2 class="text-4xl lg:text-6xl font-black mb-8">Stay Active on Teams.<br />Stay Available.</h2>
            <p class="text-xl text-white/80 mb-6 max-w-2xl mx-auto">A small tool that removes the stress of going Away during work.</p>
            <p class="text-white/90 font-bold">Launch price <?php echo esc_html( noaway_price_label() ); ?> — Regular price <?php echo esc_html( noaway_regular_price_label() ); ?>.</p>
            <p class="text-white/95 font-semibold mb-2">Kill the stress—it's just five bucks!</p>
            <p class="text-white mb-8">One-time purchase. <?php echo esc_html( noaway_fact( 'license.lifetime_updates_short' ) ); ?></p>
            <div class="flex flex-col items-center gap-4 mb-8">
              <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="bg-white text-primary px-10 py-5 rounded-2xl font-black text-lg hover:scale-105 transition-transform inline-flex items-center gap-3"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
                Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
              </a>
              <p class="text-white/80 text-sm">Mac &amp; Windows · one-time payment · instant download after purchase</p>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php get_footer(); ?>
