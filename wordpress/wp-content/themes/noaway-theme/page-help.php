<?php
/**
 * Template Name: Help NoAway
 * Pagina Help Center - Documentazione rapida, installazione, attivazione, troubleshooting, contatto supporto
 */
get_header();
$downloads_url = noaway_downloads_page_url();
$contact_url = noaway_contact_page_url();
?>
<main class="w-full">
  <!-- Hero -->
  <section class="relative py-20 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
      <h1 class="text-5xl md:text-6xl font-black tracking-tight mb-6 text-slate-900 dark:text-white">
        Help Center
      </h1>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
        Find quick answers about installing, activating, and using NoAway.
      </p>
    </div>
  </section>

  <!-- Quick Help - 3 cards -->
  <section class="py-12 px-6">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-2xl font-bold mb-8 text-center text-slate-900 dark:text-white">Quick help</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <!-- Card 1: Install NoAway -->
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow flex flex-col">
          <div class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-2xl">download_for_offline</span>
          </div>
          <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">Install NoAway</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 flex-1">
            Download the installer for your operating system and follow the simple installation steps. NoAway works on both macOS and Windows.
          </p>
          <a href="#installation" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary text-white px-5 py-3 text-sm font-bold hover:opacity-90 transition-opacity">
            View installation guide
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
          </a>
        </div>
        <!-- Card 2: Activate your license -->
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow flex flex-col">
          <div class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-2xl">vpn_key</span>
          </div>
          <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">Activate your license</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 flex-1">
            Enter your license key the first time you launch NoAway to unlock the full version.
          </p>
          <a href="#license-activation" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary text-white px-5 py-3 text-sm font-bold hover:opacity-90 transition-opacity">
            Activation instructions
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
          </a>
        </div>
        <!-- Card 3: Troubleshooting -->
        <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow flex flex-col">
          <div class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-2xl">build</span>
          </div>
          <h3 class="text-xl font-bold mb-2 text-slate-900 dark:text-white">Troubleshooting</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 flex-1">
            If NoAway doesn't behave as expected, check common solutions for typical issues.
          </p>
          <a href="#troubleshooting" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary text-white px-5 py-3 text-sm font-bold hover:opacity-90 transition-opacity">
            Troubleshooting guide
            <span class="material-symbols-outlined text-lg">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Requirements (compatibility check before purchase) -->
  <section id="requirements" class="py-16 px-6 scroll-mt-24">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Requirements</h2>
      <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400 mb-6">
        <li><?php echo esc_html( noaway_fact( 'requirements.macos_min' ) ); ?></li>
        <li><?php echo esc_html( noaway_fact( 'requirements.windows_min' ) ); ?></li>
        <li><?php echo esc_html( noaway_fact( 'requirements.accessibility' ) ); ?></li>
        <li><?php echo esc_html( noaway_fact( 'requirements.process' ) ); ?></li>
      </ul>
      <?php
		$limits = noaway_fact( 'requirements.known_limits', array() );
		if ( is_array( $limits ) && $limits ) :
			?>
      <p class="font-semibold text-slate-900 dark:text-white mb-2">Known limits</p>
      <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400">
			<?php foreach ( $limits as $limit ) : ?>
        <li><?php echo esc_html( $limit ); ?></li>
			<?php endforeach; ?>
      </ul>
		<?php endif; ?>
    </div>
  </section>

  <!-- Installation Guide -->
  <section id="installation" class="py-16 px-6 bg-white dark:bg-slate-900/50 scroll-mt-24">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-3xl font-bold mb-8 text-slate-900 dark:text-white">Installing NoAway</h2>

      <div class="grid md:grid-cols-2 gap-6">
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
          <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-slate-900 dark:text-white">
            <span class="material-symbols-outlined text-primary">desktop_mac</span>
            macOS
          </h3>
          <ol class="list-decimal list-inside space-y-2 text-slate-600 dark:text-slate-400">
            <li>After purchase, download the .dmg from your confirmation email or the thank-you page (or start from the <a class="text-primary font-medium hover:underline" href="<?php echo esc_url( $downloads_url ); ?>">Download page</a> → Buy).</li>
            <li>Drag NoAway into your Applications folder.</li>
            <li>Open the app and allow it if macOS shows a security prompt.</li>
            <li>The icon will appear in your menu bar.</li>
          </ol>
        </div>

        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
          <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-slate-900 dark:text-white">
            <span class="material-symbols-outlined text-primary">window</span>
            Windows
          </h3>
          <ol class="list-decimal list-inside space-y-2 text-slate-600 dark:text-slate-400">
            <li>After purchase, download the .exe from your confirmation email or the thank-you page (or start from the <a class="text-primary font-medium hover:underline" href="<?php echo esc_url( $downloads_url ); ?>">Download page</a> → Buy).</li>
            <li>Run the installer and follow the setup wizard.</li>
            <li>Launch NoAway from the Start menu.</li>
            <li>The app will appear in your system tray.</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- License Activation -->
  <section id="license-activation" class="py-16 px-6 scroll-mt-24">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Activating your license</h2>
      <ol class="list-decimal list-inside space-y-2 text-slate-600 dark:text-slate-400 mb-8">
        <li>Launch NoAway.</li>
        <li>Enter your license key when prompted.</li>
        <li>Once activated, NoAway will unlock the full version.</li>
      </ol>
      <div class="p-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
        <p class="font-semibold text-slate-900 dark:text-white mb-2">If activation fails, make sure:</p>
        <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-400">
          <li>the email matches your purchase</li>
          <li>the license key is correct</li>
          <li>your internet connection is available</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Troubleshooting / Common issues -->
  <section id="troubleshooting" class="py-16 px-6 bg-white dark:bg-slate-900/50 scroll-mt-24">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl font-bold mb-8 text-slate-900 dark:text-white">Common issues</h2>
      <div class="space-y-6">
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700">
          <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white">NoAway doesn't start automatically</h3>
          <p class="text-slate-600 dark:text-slate-400">Enable the “Start at Login” option in the app settings.</p>
        </div>
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700">
          <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white">My status still shows Away (e.g. in Teams)</h3>
          <p class="text-slate-600 dark:text-slate-400 mb-3">Make sure NoAway is running and “Keep Active” is enabled (not paused). Then try the following:</p>
          <ul class="list-disc list-inside space-y-1 text-slate-600 dark:text-slate-400 mb-3">
            <li><strong>Use the latest version.</strong> We release updates that improve how often the app simulates activity, so Teams does not switch to Away after a few minutes. Download the newest installer from your purchase email (or buy again from the <a class="text-primary font-medium hover:underline" href="<?php echo esc_url( $downloads_url ); ?>">Download page</a> only if you need a new license).</li>
            <li><strong>After updating,</strong> open the NoAway menu (tray or menu bar) and choose <strong>“Restart Activity Engine”</strong>. This applies the new timing.</li>
            <li><strong>Check the logs.</strong> In the menu, click <strong>“Open Logs”</strong>. If you see lines like “simulated” every few minutes but your status still goes Away, the system is not counting that activity—see <strong>On macOS</strong> below.</li>
          </ul>
          <p class="text-slate-600 dark:text-slate-400 mb-2"><strong>On macOS:</strong> the app must have <strong>Accessibility</strong> permission so the system (and Teams) treats simulated input as real activity. Go to <strong>System Settings → Privacy &amp; Security → Accessibility</strong>, add <strong>NoAway</strong> to the list and turn it on. Quit and reopen NoAway after granting permission. On some Macs (depending on model or macOS version) the system may still not count simulated input as activity, so the status in Teams might not stay Available; in that case NoAway will still keep the display awake and prevent sleep.</p>
          <p class="text-slate-600 dark:text-slate-400 mb-2"><strong>On Windows:</strong> some antivirus or security software can block the kind of activity NoAway uses. If the problem continues, try running NoAway once <strong>as Administrator</strong> (right‑click the icon → “Run as administrator”) to see if that changes anything. Also ensure your display and sleep settings are not turning off the screen or locking the PC too quickly.</p>
          <p class="text-slate-600 dark:text-slate-400">If Teams still goes Away after these steps, send us a copy of the log (or a screenshot) via the <a class="text-primary font-medium hover:underline" href="<?php echo esc_url( $contact_url ); ?>">contact page</a> and we’ll help you fix it.</p>
        </div>
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700">
          <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white">The tray icon is missing</h3>
          <p class="text-slate-600 dark:text-slate-400">On macOS, check the menu bar at the top of your screen. On Windows, expand the hidden tray icons in the taskbar.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Privacy and Security -->
  <section id="privacy-security" class="py-16 px-6 scroll-mt-24">
    <div class="max-w-3xl mx-auto">
      <h2 class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Privacy and security</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
        Keep Active runs on your computer. It does not read your files or messages. Activation and updates contact the license server. The table of what is sent is on the <a class="text-primary font-medium hover:underline" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>.
      </p>
      <?php noaway_render_controls_note( 'en' ); ?>
    </div>
  </section>

  <!-- Contact Support -->
  <section id="contact-support" class="py-20 px-6 bg-slate-100 dark:bg-slate-900/70 scroll-mt-24">
    <div class="max-w-2xl mx-auto text-center">
      <h2 class="text-3xl font-bold mb-4 text-slate-900 dark:text-white">Still need help?</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
        If you can't find the answer you're looking for, our support team will be happy to help.
      </p>
      <a href="<?php echo esc_url( $contact_url ); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary text-white px-8 py-4 font-bold hover:opacity-90 transition-opacity mb-4">
        <span class="material-symbols-outlined">support_agent</span>
        Contact support
      </a>
      <p class="text-slate-600 dark:text-slate-400">
        <a class="text-primary font-medium hover:underline" href="mailto:support@noaway.app">support@noaway.app</a>
      </p>
      <p class="text-sm text-slate-500 dark:text-slate-500 mt-4">We usually respond within 24 hours.</p>
    </div>
  </section>
</main>
<?php get_footer(); ?>
