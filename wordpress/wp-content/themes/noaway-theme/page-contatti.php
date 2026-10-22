<?php
/**
 * Template Name: Contatti NoAway
 * Pagina Contatti - Support Center, form di contatto
 */
get_header();

if ( defined( 'NOAWAY_RECAPTCHA_SITE_KEY' ) && NOAWAY_RECAPTCHA_SITE_KEY ) {
  wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, false );
}
?>
<main>
  <!-- Hero Section -->
  <section class="relative pt-16 pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
        <span class="material-symbols-outlined text-sm">support_agent</span>
        Support Center
      </div>
      <h1 class="text-5xl md:text-6xl font-black tracking-tight mb-6">
        Get in touch
      </h1>
      <p class="text-slate-600 dark:text-slate-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
        Have questions about NoAway or need help with installation? We're happy to help.
      </p>
    </div>
    <!-- Decorative Elements -->
    <div class="absolute -top-24 -right-24 size-96 bg-primary/5 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 -left-24 size-64 bg-primary/10 rounded-full blur-3xl"></div>
  </section>

  <!-- Main Content Area -->
  <section class="max-w-7xl mx-auto px-6 pb-24">
    <div class="grid lg:grid-cols-12 gap-16">
      <!-- Contact Form -->
      <div class="lg:col-span-7">
        <h2 class="text-2xl font-bold mb-6 text-slate-900 dark:text-slate-100">Send us a message</h2>
        <div class="bg-white dark:bg-slate-900 p-8 md:p-10 rounded-xl shadow-sm border border-slate-100 dark:border-slate-800">
          <?php
          if ( isset( $_GET['contact'] ) && $_GET['contact'] === 'sent' ) {
            echo '<div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-sm flex items-center gap-2">';
            echo '<span class="material-symbols-outlined">check_circle</span>';
            echo '<span>Message sent successfully. We will get back to you soon.</span></div>';
          }
          if ( isset( $_GET['contact'] ) && $_GET['contact'] === 'error' ) {
            echo '<div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm flex items-center gap-2">';
            echo '<span class="material-symbols-outlined">error</span>';
            echo '<span>Something went wrong. Please try again or email us at support@noaway.app.</span></div>';
          }
          ?>
          <form action="<?php echo esc_url( get_permalink() ); ?>" method="post" class="relative space-y-6">
            <?php wp_nonce_field( 'noaway_contact', 'noaway_contact_nonce' ); ?>
            <input type="hidden" name="noaway_contact_form" value="1">
            <?php /* Honeypot — leave empty; bots often fill it. Inline styles so it works without Tailwind rebuild. */ ?>
            <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
              <label for="contact-website">Website</label>
              <input id="contact-website" type="text" name="contact_website" value="" tabindex="-1" autocomplete="off">
            </div>
            <div class="grid md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="text-sm font-semibold ml-1" for="contact-name">Full Name</label>
                <input id="contact-name" name="contact_name" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="John Doe" type="text" value="<?php echo esc_attr( isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '' ); ?>" required>
              </div>
              <div class="space-y-2">
                <label class="text-sm font-semibold ml-1" for="contact-email">Email Address</label>
                <input id="contact-email" name="contact_email" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="john@example.com" type="email" value="<?php echo esc_attr( isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '' ); ?>" required>
              </div>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold ml-1" for="contact-topic">Contact Reason</label>
              <select id="contact-topic" name="contact_topic" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all text-slate-900 dark:text-slate-100 appearance-none cursor-pointer" required>
                <option value="">Choose a topic...</option>
                <option value="General Question" <?php selected( isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '', 'General Question' ); ?>>General Question</option>
                <option value="Technical Support" <?php selected( isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '', 'Technical Support' ); ?>>Technical Support</option>
                <option value="License Issue" <?php selected( isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '', 'License Issue' ); ?>>License Issue</option>
                <option value="Billing Question" <?php selected( isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '', 'Billing Question' ); ?>>Billing Question</option>
                <option value="Other" <?php selected( isset( $_POST['contact_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_topic'] ) ) : '', 'Other' ); ?>>Other</option>
              </select>
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold ml-1" for="contact-subject">Subject</label>
              <input id="contact-subject" name="contact_subject" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="How can we help?" type="text" value="<?php echo esc_attr( isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '' ); ?>">
            </div>
            <div class="space-y-2">
              <label class="text-sm font-semibold ml-1" for="contact-message">Message</label>
              <textarea id="contact-message" name="contact_message" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl p-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400 resize-none" placeholder="Tell us more about your request..." rows="5" required><?php echo esc_textarea( isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '' ); ?></textarea>
            </div>
            <?php if ( defined( 'NOAWAY_RECAPTCHA_SITE_KEY' ) && NOAWAY_RECAPTCHA_SITE_KEY ) : ?>
            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr( NOAWAY_RECAPTCHA_SITE_KEY ); ?>"></div>
            <?php endif; ?>
            <button class="w-full bg-primary text-white font-bold h-14 rounded-xl hover:opacity-95 transition-all flex items-center justify-center gap-2 group" type="submit" name="noaway_contact_submit">
              Send Message
              <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
            </button>
          </form>
        </div>
      </div>

      <!-- Sidebar Info -->
      <div class="lg:col-span-5 space-y-8 lg:sticky lg:top-28 self-start">
        <div class="space-y-6">
          <h3 class="text-2xl font-bold">Other ways to connect</h3>
          <!-- Contact Card 1 -->
          <div class="flex gap-5 p-6 rounded-xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 group hover:border-primary/30 transition-colors">
            <div class="size-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined">mail</span>
            </div>
            <div>
              <h4 class="font-bold mb-1">Email Support</h4>
              <p class="text-slate-600 text-sm mb-3">For technical questions, license issues, or general support.</p>
              <a class="text-primary font-semibold hover:underline" href="mailto:support@noaway.app">support@noaway.app</a>
            </div>
          </div>
          <!-- Contact Card 2 -->
          <div class="flex gap-5 p-6 rounded-xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 group hover:border-primary/30 transition-colors">
            <div class="size-12 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined">help_center</span>
            </div>
            <div>
              <h4 class="font-bold mb-1">Help Center</h4>
              <p class="text-slate-600 text-sm mb-3">Browse documentation and tutorials for quick answers.</p>
              <a class="inline-flex items-center gap-1 text-primary font-semibold hover:underline" href="<?php echo esc_url( home_url( '/help' ) ); ?>">
                Visit Knowledge Base
                <span class="material-symbols-outlined text-sm">open_in_new</span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
