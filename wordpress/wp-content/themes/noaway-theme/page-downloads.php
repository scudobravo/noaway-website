<?php
/**
 * Template Name: Downloads NoAway
 * Platform chooser → checkout. Installers are delivered only after purchase
 * (thank-you page + license email via api/download.php).
 */
get_header();
$checkout = noaway_checkout_url();
?>
<main class="mx-auto max-w-5xl px-6 py-12 lg:py-20">
  <!-- Hero Section -->
  <div class="text-center mb-16">
    <div class="inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 mb-6">
      <span class="text-xs font-bold uppercase tracking-wider text-primary">Latest Version</span>
    </div>
    <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-slate-100 sm:text-6xl mb-6">
      Download NoAway for your device
    </h1>
    <p class="mx-auto max-w-2xl text-lg text-slate-600 dark:text-slate-400">
      Purchase once, then get your installers by email and on the thank-you page. No free public downloads.
    </p>
  </div>

  <!-- Platform Cards -->
  <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-10 xl:gap-12 mb-20 lg:items-start">
    <!-- macOS -->
    <div class="group relative flex flex-col rounded-xl border border-primary/10 bg-white dark:bg-slate-900/50 p-8 transition-all hover:border-primary/30 hover:shadow-2xl hover:shadow-primary/5 w-full">
      <div class="mb-6 flex items-center">
        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100">
          <span class="material-symbols-outlined text-3xl">desktop_mac</span>
        </div>
      </div>
      <h3 class="text-2xl font-bold mb-2">For macOS</h3>
      <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Requires macOS 11 Big Sur or later. After purchase you choose Apple Silicon or Intel (universal) from your download links.</p>

      <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <a href="<?php echo esc_url( $checkout ); ?>" class="flex flex-1 flex-col items-center justify-center gap-2 rounded-lg bg-primary py-4 px-4 text-center text-base font-bold text-white transition-transform hover:scale-[1.02] active:scale-95"<?php echo noaway_buy_cta_attrs( 'macos-arm64' ); ?>>
          <span class="material-symbols-outlined">shopping_cart</span>
          <span>Apple Silicon (M1, M2, M3, …)</span>
          <span class="text-xs font-normal opacity-90">Buy · then download arm64</span>
        </a>
        <a href="<?php echo esc_url( $checkout ); ?>" class="flex flex-1 flex-col items-center justify-center gap-2 rounded-lg border-2 border-primary bg-white dark:bg-slate-900 py-4 px-4 text-center text-base font-bold text-primary transition-transform hover:scale-[1.02] active:scale-95"<?php echo noaway_buy_cta_attrs( 'macos-intel' ); ?>>
          <span class="material-symbols-outlined">shopping_cart</span>
          <span>Intel</span>
          <span class="text-xs font-normal opacity-90">Buy · then download universal</span>
        </a>
      </div>

      <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">After checkout, pick the build that matches your Mac. The Apple Silicon build’s file name usually includes <code class="bg-slate-100 dark:bg-slate-800 px-1 rounded">arm64</code>. Choose <strong>Intel</strong> (universal DMG) if you have an <strong>Intel</strong> Mac.</p>

      <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/40 p-5 text-left text-sm text-slate-600 dark:text-slate-300">
        <p class="font-bold text-slate-900 dark:text-white mb-2">Which Mac do I have?</p>
        <ol class="list-decimal pl-5 space-y-2">
          <li>Open the <strong>Apple menu</strong> (top-left) → <strong>About This Mac</strong>.</li>
          <li>Check <strong>Chip</strong> or <strong>Processor</strong>:
            <ul class="list-disc pl-5 mt-1 space-y-1">
              <li><strong>Apple M1, M2, M3, M4</strong>, or similar → use <strong>Apple Silicon</strong> after purchase.</li>
              <li><strong>Intel</strong> → use <strong>Intel</strong> (universal installer).</li>
            </ul>
          </li>
        </ol>
      </div>

      <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Already purchased? Use the links in your confirmation email (valid 7 days).</p>
    </div>

    <!-- Windows Card -->
    <div class="group relative flex flex-col rounded-xl border border-primary/10 bg-white dark:bg-slate-900/50 p-8 transition-all hover:border-primary/30 hover:shadow-2xl hover:shadow-primary/5 w-full">
      <div class="mb-6 flex items-center">
        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100">
          <span class="material-symbols-outlined text-3xl">window</span>
        </div>
      </div>
      <h3 class="text-2xl font-bold mb-2">For Windows</h3>
      <p class="text-sm text-slate-500 dark:text-slate-400 mb-8">Compatible with Windows 10 and Windows 11 (64-bit). Installer arrives after purchase.</p>
      <a href="<?php echo esc_url( $checkout ); ?>" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-4 text-base font-bold text-white transition-transform hover:scale-[1.02] active:scale-95"<?php echo noaway_buy_cta_attrs( 'windows-card' ); ?>>
        <span class="material-symbols-outlined">shopping_cart</span>
        Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
      </a>
    </div>
  </div>

  <!-- License & Checkout -->
  <div class="mb-20 rounded-xl border border-primary/20 bg-primary/5 p-8 lg:p-12">
    <div class="flex flex-col items-center justify-between gap-8 lg:flex-row">
      <div class="max-w-xl text-center lg:text-left">
        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white dark:bg-slate-800 px-3 py-1 text-xs font-bold text-primary shadow-sm">
          LIFETIME LICENSE
        </div>
        <h3 class="mb-3 text-3xl font-extrabold">Purchase License</h3>
        <p class="text-slate-600 dark:text-slate-400 mb-4">
          One-time purchase. No subscriptions and no hidden fees. Download links are sent only after payment.
        </p>
        <div class="mb-4 flex flex-wrap items-baseline gap-x-4 gap-y-1">
          <span class="text-slate-500 dark:text-slate-400 text-sm">Launch price:</span>
          <span class="text-slate-900 dark:text-slate-100 font-bold text-2xl"><?php echo esc_html( noaway_price_label() ); ?></span>
          <span class="text-slate-500 dark:text-slate-400 text-sm">Regular price:</span>
          <span class="text-slate-500 dark:text-slate-400 line-through text-lg"><?php echo esc_html( noaway_regular_price_label() ); ?></span>
        </div>
        <p class="text-slate-600 dark:text-slate-400 mb-6">
          Includes <?php echo esc_html( function_exists( 'noaway_fact' ) ? noaway_fact( 'license.lifetime_updates_short' ) : 'updates emailed with a direct download link' ); ?>
        </p>
        <a href="<?php echo esc_url( $checkout ); ?>" class="inline-flex min-w-[200px] items-center justify-center gap-2 rounded-lg bg-slate-900 dark:bg-white py-4 text-base font-bold text-white dark:text-slate-900 transition-colors hover:bg-slate-800 dark:hover:bg-slate-100"<?php echo noaway_buy_cta_attrs( 'license-cta' ); ?>>
          <span class="material-symbols-outlined">shopping_cart</span>
          Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
        </a>
        <div class="mt-4 max-w-md text-left mx-auto lg:mx-0 md:hidden">
          <?php noaway_render_mobile_email_link_box(); ?>
        </div>
        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400"><?php echo noaway_refund_near_price_html( 'en' ); ?></p>
        <?php noaway_render_before_you_buy( 'en' ); ?>
        <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Secure checkout.</p>
      </div>
    </div>
  </div>

  <!-- Installation Guide -->
  <div class="mb-20">
    <h2 class="mb-10 text-center text-2xl font-bold">Simple 3-Step Installation</h2>
    <div class="grid gap-8 md:grid-cols-3">
      <div class="flex flex-col items-center text-center">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-lg">1</div>
        <h3 class="mb-2 font-bold">Purchase</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Buy a lifetime license. You get download links on the thank-you page and by email.</p>
      </div>
      <div class="flex flex-col items-center text-center">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-lg">2</div>
        <h3 class="mb-2 font-bold">Download &amp; install</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Open the installer for your OS and follow the on-screen steps.</p>
      </div>
      <div class="flex flex-col items-center text-center">
        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-lg">3</div>
        <h3 class="mb-2 font-bold">Activate</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Open NoAway and enter your license key to activate the application.</p>
      </div>
    </div>
    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">When you install a new version, use <strong>Restart Activity Engine</strong> from the tray menu so the app applies the latest behaviour (e.g. to keep Teams from going Away).</p>
  </div>

  <!-- Help Section -->
  <div class="mb-20 border-t border-primary/10 pt-12 text-center">
    <p class="mb-6 text-slate-500 dark:text-slate-400">
      Need help with installation?
    </p>
    <div class="flex flex-wrap justify-center gap-6">
      <a class="flex items-center gap-2 text-sm font-bold text-primary hover:underline" href="<?php echo esc_url( noaway_help_page_url() ); ?>">
        <span class="material-symbols-outlined text-lg">help</span>
        Help Center
      </a>
      <a class="flex items-center gap-2 text-sm font-bold text-primary hover:underline" href="<?php echo esc_url( noaway_contact_page_url() ); ?>">
        <span class="material-symbols-outlined text-lg">mail</span>
        Contact Support
      </a>
    </div>
  </div>

</main>
<?php get_footer(); ?>
