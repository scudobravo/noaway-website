<?php
/**
 * Template Name: Privacy Policy NoAway
 * Pagina Privacy Policy - Informativa sulla privacy, dati, sicurezza
 */
get_header();
?>
<main class="flex-1 px-6 md:px-10 lg:px-40 py-12 md:py-20">
  <div class="max-w-[800px] mx-auto">
    <div class="mb-16">
      <h1 class="text-slate-900 dark:text-slate-100 text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Privacy Policy</h1>
      <p class="text-primary font-medium">Last Updated: <?php echo esc_html( wp_date( 'F j, Y', filemtime( __FILE__ ) ) ); ?></p>
    </div>
    <div class="prose-custom dark:prose-invert text-slate-700 dark:text-slate-300">
      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">1. INTRODUCTION</h2>
        <p class="leading-relaxed mb-4">
          This Privacy Policy explains how NoAway OLIVEE SRLS ("Company", "we", "us", or "our") collects, uses, and protects personal data when you access or use the NoAway application, website, and related services (the "Service").
        </p>
        <p class="leading-relaxed mb-0">
          We are committed to protecting your privacy and processing your data in accordance with applicable laws, including the General Data Protection Regulation (GDPR).
        </p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">2. DATA CONTROLLER</h2>
        <p class="leading-relaxed mb-4">The data controller responsible for your personal data is:</p>
        <p class="leading-relaxed mb-0">
          NoAway OLIVEE SRLS<br>
          Livorno, Italy<br>
          support@noaway.app
        </p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">3. DATA WE COLLECT</h2>
        <p class="leading-relaxed mb-4">We are committed to data minimization.</p>
        <p class="leading-relaxed mb-4">
          Depending on how you use the Service, we may collect the following categories of data:
        </p>
        <h3 class="text-slate-900 dark:text-slate-100 font-semibold text-lg mb-3">3.1 Information You Provide</h3>
        <ul class="list-disc pl-6 mb-6 space-y-2">
          <li>Email address (if you create an account or contact us)</li>
          <li>Billing information (if applicable)</li>
        </ul>
        <h3 class="text-slate-900 dark:text-slate-100 font-semibold text-lg mb-3">3.2 What is sent, and where</h3>
        <?php noaway_render_privacy_transfer_table(); ?>
        <h3 class="text-slate-900 dark:text-slate-100 font-semibold text-lg mb-3">3.3 Data We DO NOT Collect</h3>
        <p class="leading-relaxed mb-4">We explicitly do NOT collect:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>keyboard input or keystrokes</li>
          <li>screen content or recordings</li>
          <li>activity within third-party applications such as Microsoft Teams or Slack</li>
          <li>personal files or documents</li>
        </ul>
        <p class="leading-relaxed mb-0">
          The Service operates locally on your device and does not monitor user behavior beyond what is strictly necessary.
        </p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">4. PURPOSE OF DATA PROCESSING</h2>
        <p class="leading-relaxed mb-4">We process your data only for the following purposes:</p>
        <ul class="list-disc pl-6 mb-0 space-y-2">
          <li>providing and maintaining the Service</li>
          <li>improving performance and stability</li>
          <li>processing payments (if applicable)</li>
          <li>responding to user inquiries</li>
          <li>ensuring security and preventing abuse</li>
        </ul>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">5. LEGAL BASIS FOR PROCESSING</h2>
        <p class="leading-relaxed mb-4">Under GDPR, we rely on the following legal bases:</p>
        <ul class="list-disc pl-6 mb-0 space-y-2">
          <li>Performance of a contract (to provide the Service)</li>
          <li>Legitimate interests (to improve and secure the Service)</li>
          <li>Legal obligations (where applicable)</li>
          <li>Consent (where explicitly requested)</li>
        </ul>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">6. DATA RETENTION</h2>
        <p class="leading-relaxed mb-4">We retain personal data only as long as necessary:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>Account data: for the duration of your account</li>
          <li>Billing data: as required by law</li>
          <li>Technical logs: for a limited period for security and debugging</li>
        </ul>
        <p class="leading-relaxed mb-0">When no longer needed, data is securely deleted or anonymized.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">7. DATA SHARING</h2>
        <p class="leading-relaxed mb-4">We do NOT sell your personal data.</p>
        <p class="leading-relaxed mb-4">We may share data only with:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>payment processors</li>
          <li>hosting providers</li>
          <li>analytics providers (in anonymized form where possible)</li>
        </ul>
        <p class="leading-relaxed mb-0">All third parties are required to comply with applicable data protection laws.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">8. INTERNATIONAL DATA TRANSFERS</h2>
        <p class="leading-relaxed mb-4">Your data may be processed outside your country.</p>
        <p class="leading-relaxed mb-4">Where required, we ensure appropriate safeguards, such as:</p>
        <ul class="list-disc pl-6 mb-0 space-y-2">
          <li>Standard Contractual Clauses (SCCs)</li>
          <li>GDPR-compliant providers</li>
        </ul>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">9. DATA SECURITY</h2>
        <p class="leading-relaxed mb-4">We implement appropriate technical and organizational measures to protect your data, including:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>encryption where appropriate</li>
          <li>access controls</li>
          <li>minimal data storage</li>
        </ul>
        <p class="leading-relaxed mb-0">However, no system is completely secure.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">10. YOUR RIGHTS (GDPR)</h2>
        <p class="leading-relaxed mb-4">If you are in the European Economic Area, you have the right to:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>access your data</li>
          <li>rectify inaccurate data</li>
          <li>request deletion</li>
          <li>restrict processing</li>
          <li>object to processing</li>
          <li>data portability</li>
        </ul>
        <p class="leading-relaxed mb-0">To exercise your rights, contact us at: support@noaway.app</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">11. THIRD-PARTY SERVICES</h2>
        <p class="leading-relaxed mb-4">The Service may interact with third-party software such as:</p>
        <ul class="list-disc pl-6 mb-4 space-y-2">
          <li>Microsoft Teams</li>
          <li>Slack</li>
        </ul>
        <p class="leading-relaxed mb-0">We are not responsible for their privacy practices. Please review their policies separately.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">12. CHILDREN'S PRIVACY</h2>
        <p class="leading-relaxed mb-4">The Service is not intended for individuals under 18.</p>
        <p class="leading-relaxed mb-0">We do not knowingly collect data from children.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">13. CHANGES TO THIS POLICY</h2>
        <p class="leading-relaxed mb-4">We may update this Privacy Policy from time to time.</p>
        <p class="leading-relaxed mb-0">Changes will be posted on this page with an updated "Last Updated" date.</p>
      </section>

      <section class="mb-14 p-8 rounded-xl bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="!mt-0 mb-4 text-slate-900 dark:text-slate-100 font-bold text-xl">14. CONTACT</h2>
        <p class="leading-relaxed mb-4">For any questions regarding this Privacy Policy:</p>
        <p class="leading-relaxed mb-0">
          Email: support@noaway.app<br>
          Company: NoAway OLIVEE SRLS
        </p>
      </section>

    </div>
  </div>
</main>
<?php get_footer(); ?>
