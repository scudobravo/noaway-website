<?php
/**
 * Template Name: Is NoAway safe
 * SEO page: Is NoAway safe / legit – privacy, admin rights, company PCs
 */
get_header();
$download_url = noaway_downloads_page_url();
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24" itemscope itemtype="https://schema.org/Article">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Trust &amp; safety</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        Is NoAway Safe?
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Straight answers about what NoAway is, what it does on your Mac or Windows PC, what it never does, and how it fits with company IT policies. Related: <a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a>, <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="text-primary font-semibold hover:underline">Privacy Policy</a>, and <a href="<?php echo esc_url( noaway_how_it_works_page_url() ); ?>" class="text-primary font-semibold hover:underline">how it works</a>.
      </p>
      <div class="mt-8 p-6 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700" role="complementary" aria-label="In brief">
        <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">In brief</p>
        <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-0">
          NoAway is a lightweight desktop utility from OLIVEE SRLS. It runs locally and is built to prevent system idle so apps like Teams and Slack can stay Available. It is not a keylogger, does not read your chat apps, and does not need to open Teams or Slack. Always follow your employer’s software policy on managed devices.
        </p>
      </div>
    </header>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="legit-heading">
      <h2 id="legit-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Is NoAway legit?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Yes. NoAway is a commercial desktop product sold as a one-time purchase for macOS and Windows. The company behind it is OLIVEE SRLS (see the site footer for VAT details). You buy a license, download the app, and run it from the system tray or menu bar—there is no subscription upsell loop and no browser extension that hijacks your session.
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php // TODO: Confirm any third-party trust signals worth listing (reviews, store listings, antivirus false-positive status). ?>
        Legitimacy also means clear policies: <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="text-primary font-semibold hover:underline">Privacy Policy</a>, <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>" class="text-primary font-semibold hover:underline">Terms of Service</a>, and support via the <a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-primary font-semibold hover:underline">contact</a> page.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="what-it-does-heading">
      <h2 id="what-it-does-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">What exactly does NoAway do on my computer?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        NoAway’s job is narrow: while Keep Active is enabled, it prevents your computer from entering an idle state at the operating-system level. Presence apps that read that signal—Microsoft Teams, Slack, and similar tools—can then continue to show you as Available during long builds, downloads, or deep work.
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php // TODO: Confirm exact OS APIs / idle-prevention mechanism for marketing accuracy (macOS vs Windows). ?>
        It runs as a small tray / menu-bar app. It does not inject into Teams or Slack, does not open a hidden browser tab, and does not change your permanent power-plan settings as its primary model—you turn it on when you need the machine to stay active.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="what-it-does-not-heading">
      <h2 id="what-it-does-not-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">What NoAway does NOT do</h2>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3 mb-4">
        <li><strong>No keylogging</strong> — it does not record keystrokes or what you type.</li>
        <li><strong>No screen capture</strong> — it does not take screenshots or record your display.</li>
        <li><strong>No access to Teams or Slack accounts or messages</strong> — it does not log into those apps, read chats, or modify their settings.</li>
        <li><strong>No browsing your personal files</strong> — it is not a file or document scanner.</li>
        <li>
          <strong>No data sent about your activity</strong> —
          <?php // TODO: Confirm desktop-app network behavior: license activation, update checks, crash reports—list any exceptions explicitly. ?>
          presence and idle prevention run locally. License activation and downloads require the network; everyday Keep Active does not need to stream your work activity off the device.
        </li>
      </ul>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        For the formal list of what is and is not collected, see the <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="text-primary font-semibold hover:underline">Privacy Policy</a>.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="admin-heading">
      <h2 id="admin-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Does it need admin rights?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php // TODO: Confirm install/runtime privileges for current Mac and Windows builds (no admin for normal install; any edge cases?). ?>
        NoAway is designed so you can install and use it without administrator rights on a typical personal Mac or Windows PC. That is one reason it is lighter than tools that rewrite system policies.
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        On locked-down company machines, IT may still block unsigned installs or unknown publishers even when an admin password is not required by the app itself.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="company-pc-heading">
      <h2 id="company-pc-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Can I use it on a company-managed computer?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Be honest with yourself and with IT: follow your company’s software and acceptable-use policy. Many organizations only allow apps from an approved catalog. Some managed devices block third-party installs, require MDM approval, or flag unknown tray apps.
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        NoAway does not bypass MDM, antivirus, or endpoint protection. If your workplace forbids personal utilities, do not install it on that machine. When in doubt, ask IT—or use NoAway only on a personal device you control.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="signed-heading">
      <h2 id="signed-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Is it signed/notarized?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Yes. Official NoAway installers are code-signed for both platforms and produced through our GitHub Actions release pipeline: macOS builds use Apple Developer ID signing and notarization (Gatekeeper), and Windows builds use Authenticode signing (SmartScreen). Always download from the official NoAway site so you get those signed binaries—not unofficial mirrors.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="opensource-heading">
      <h2 id="opensource-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Is it open source?</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        <?php // TODO: Confirm open-source status (closed source vs any public repos/components). ?>
        NoAway is sold as a commercial desktop application. It is not marketed as an open-source project. If that status changes, this page will be updated.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="refunds-heading">
      <h2 id="refunds-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Refunds and support</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        All sales are final: we do not offer refunds. The <a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>" class="text-primary font-semibold hover:underline">Terms of Service</a> also state that changes to operating systems or third-party apps (Teams, Slack, and similar) do not entitle you to a refund. Support for purchase or activation issues is still available through the <a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-primary font-semibold hover:underline">contact</a> page and the <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help Center</a>.
      </p>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        If something goes wrong with purchase or activation, contact support with your order email—do not rely on unofficial resellers.
      </p>
    </section>

    <?php
    $faqs = array(
      array(
        'name' => 'Is NoAway safe to install?',
        'text' => 'NoAway is a lightweight desktop utility that runs locally to prevent system idle. It does not keylog, capture your screen, or access Teams or Slack accounts or messages. Always download from the official NoAway site.',
      ),
      array(
        'name' => 'Is NoAway a legit company product?',
        'text' => 'Yes. NoAway is a commercial one-time-purchase app for Mac and Windows from OLIVEE SRLS, with published Privacy Policy and Terms of Service.',
      ),
      array(
        'name' => 'Does NoAway need administrator rights?',
        'text' => 'NoAway is designed to install and run without admin rights on a typical personal Mac or Windows PC. Company-managed devices may still block third-party apps through IT policy.',
      ),
      array(
        'name' => 'Can I use NoAway on a work laptop?',
        'text' => 'Only if your company policy allows it. Some managed devices block third-party software. Follow your IT rules; NoAway does not bypass MDM or endpoint protection.',
      ),
      array(
        'name' => 'Does NoAway send my activity data anywhere?',
        'text' => 'Keep Active runs locally and does not stream your work activity. License activation and downloading the app require a network connection. See the Privacy Policy for what is and is not collected.',
      ),
      array(
        'name' => 'Do you offer refunds? How do I get support?',
        'text' => 'No. All sales are final; we do not offer refunds. For purchase or activation help, use the contact page or Help Center with your order email. License terms are in the Terms of Service.',
      ),
      array(
        'name' => 'Is NoAway code-signed on Mac and Windows?',
        'text' => 'Yes. Official installers are signed in our GitHub Actions release pipeline: Developer ID and notarization on macOS, Authenticode on Windows. Download only from the official NoAway site.',
      ),
    );
    ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Frequently asked questions about NoAway safety</h2>
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
      <h2 id="cta-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Ready to try NoAway?</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto"><a href="<?php echo esc_url( $download_url ); ?>" class="text-primary font-semibold hover:underline">Download for Mac and Windows</a> — one-time purchase, lifetime updates.</p>
      <div class="max-w-md mx-auto mb-4 text-left">
        <?php noaway_render_mobile_email_link_box(); ?>
      </div>
      <a href="<?php echo esc_url( noaway_checkout_url() ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all"<?php echo noaway_buy_cta_attrs( 'footer-cta' ); ?>>
        Buy NoAway – <?php echo esc_html( noaway_price_label() ); ?>
      </a>
      <p class="mt-4 text-sm text-slate-500 dark:text-slate-400"><a href="<?php echo esc_url( noaway_faq_page_url() ); ?>" class="text-primary font-semibold hover:underline">FAQ</a> · <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a> · <a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-primary font-semibold hover:underline">Contact</a></p>
    </section>
  </article>
</main>
<?php get_footer(); ?>
