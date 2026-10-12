<?php
/**
 * Template Name: Thank You (NoAway)
 *
 * Verifica che il checkout Stripe sia completato (session_id in URL) e mostra
 * in esclusiva i link per scaricare .dmg e .exe (una sola volta per acquisto).
 * Senza session_id valido non vengono mostrati link di download.
 */
get_header();

$session_id = isset( $_GET['session_id'] ) ? sanitize_text_field( wp_unslash( $_GET['session_id'] ) ) : '';
$license_api_url = noaway_license_api_url();
$has_session = $session_id !== '' && preg_match( '/^cs_[a-zA-Z0-9]+$/', $session_id );
?>
<main class="max-w-7xl mx-auto px-6 py-20">
  <div class="max-w-2xl mx-auto text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 mb-8" aria-hidden="true">
      <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>

    <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-3">
      PAYMENT SUCCESSFUL
    </h1>
    <p class="text-xl text-slate-600 dark:text-slate-400 mb-10">
      Thank you for your purchase.
    </p>

    <p class="text-slate-600 dark:text-slate-400 mb-12 leading-relaxed">
      An email with your license key and download links has been sent to you. You can also download the app here, once only.
    </p>

    <!-- Blocco download: mostrato solo dopo verifica checkout (una tantum) -->
    <div id="noaway-post-purchase" class="text-left bg-slate-50 dark:bg-slate-800/50 rounded-xl p-8 mb-12">
      <?php if ( ! $has_session ) : ?>
        <p class="text-amber-700 dark:text-amber-300 font-medium">
          No purchase session found. If you just paid, use the link from your confirmation email to access this page and get your download links.
        </p>
        <p class="text-slate-600 dark:text-slate-400 text-sm mt-2">
          The public download page does not provide .dmg or .exe files; they are available only after a successful purchase on this page.
        </p>
      <?php elseif ( ! $license_api_url ) : ?>
        <p class="text-amber-700 dark:text-amber-300 font-medium">
          Download verification is not configured. Please use the download links sent to your email.
        </p>
      <?php else : ?>
        <div id="noaway-download-loading" class="flex items-center justify-center gap-2 py-8 text-slate-500">
          <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          <span>Verifying your purchase…</span>
        </div>
        <div id="noaway-download-success" class="hidden">
          <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Download the app (one-time links)</h2>
          <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">These links are valid for 7 days. You can also use the links in your email.</p>
          <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <a id="noaway-dl-mac" href="#" class="inline-flex items-center justify-center gap-2 bg-slate-800 dark:bg-slate-700 text-white px-6 py-4 rounded-xl font-semibold hover:opacity-90 transition-all">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
              Download for Mac (.dmg)
            </a>
            <a id="noaway-dl-win" href="#" class="inline-flex items-center justify-center gap-2 bg-slate-800 dark:bg-slate-700 text-white px-6 py-4 rounded-xl font-semibold hover:opacity-90 transition-all">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12V6.5l9-5.25 9 5.25V12H3zm9 6.5l-9-5.25V18l9 5.25 9-5.25v-4.75l-9 5.25z"/></svg>
              Download for Windows (.exe)
            </a>
          </div>
          <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1">Your license key (also in your email):</p>
            <p id="noaway-license-key" class="font-mono text-base bg-slate-200 dark:bg-slate-700 px-3 py-2 rounded break-all"></p>
          </div>
        </div>
        <div id="noaway-download-error" class="hidden">
          <p id="noaway-download-error-msg" class="text-amber-700 dark:text-amber-300 font-medium"></p>
          <p class="text-slate-600 dark:text-slate-400 text-sm mt-2">If you have already used this page to get your links, check your email. For help, <a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-primary hover:underline">contact support</a>.</p>
        </div>
      <?php endif; ?>
    </div>

    <section class="text-left bg-slate-50 dark:bg-slate-800/50 rounded-xl p-8 mb-12">
      <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6">What to do next</h2>
      <ol class="space-y-4 text-slate-600 dark:text-slate-400">
        <li class="flex gap-3">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-sm">1</span>
          <span><strong class="text-slate-900 dark:text-white">Check your email</strong> – License key and download links.</span>
        </li>
        <li class="flex gap-3">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-sm">2</span>
          <span><strong class="text-slate-900 dark:text-white">Download the app</strong> – Use the links above or in the email (valid 7 days).</span>
        </li>
        <li class="flex gap-3">
          <span class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 text-primary font-bold flex items-center justify-center text-sm">3</span>
          <span><strong class="text-slate-900 dark:text-white">Install and activate</strong> – Enter your email and license key when prompted.</span>
        </li>
      </ol>
    </section>
  </div>
</main>

<?php if ( $has_session && $license_api_url ) : ?>
<script>
(function() {
  var sessionId = <?php echo json_encode( $session_id ); ?>;
  var apiBase = <?php echo json_encode( $license_api_url ); ?>;
  var loading = document.getElementById('noaway-download-loading');
  var success = document.getElementById('noaway-download-success');
  var error = document.getElementById('noaway-download-error');
  var errorMsg = document.getElementById('noaway-download-error-msg');

  fetch(apiBase + '/post-purchase-downloads?session_id=' + encodeURIComponent(sessionId), { method: 'GET', credentials: 'omit' })
    .then(function(r) { return r.json().then(function(j) { return { status: r.status, json: j }; }); })
    .then(function(result) {
      loading.classList.add('hidden');
      if (result.status === 200 && result.json.status === 'ok') {
        success.classList.remove('hidden');
        document.getElementById('noaway-dl-mac').href = result.json.mac_url;
        document.getElementById('noaway-dl-win').href = result.json.win_url;
        document.getElementById('noaway-license-key').textContent = result.json.license_key || '';
      } else {
        error.classList.remove('hidden');
        var code = result.json && result.json.code;
        var msg = result.json && result.json.message ? result.json.message : 'Unable to verify your purchase.';
        if (code === 'already_revealed') {
          msg = 'You have already received your download links for this purchase. Please use the links in your email.';
        } else if (code === 'payment_not_completed' || code === 'license_not_found') {
          msg = 'Purchase could not be verified. If you just paid, wait a moment and refresh this page. Otherwise contact support.';
        }
        errorMsg.textContent = msg;
      }
    })
    .catch(function() {
      loading.classList.add('hidden');
      error.classList.remove('hidden');
      errorMsg.textContent = 'Unable to verify your purchase. Please check your email for download links or contact support.';
    });
})();
</script>
<?php endif; ?>

<?php get_footer(); ?>
