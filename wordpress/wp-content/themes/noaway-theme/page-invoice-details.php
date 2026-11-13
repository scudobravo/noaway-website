<?php
/**
 * Template Name: Invoice details (NoAway)
 *
 * Post-purchase form for Italian electronic invoice billing data.
 * Private individuals only. Opened via signed link from the license email.
 */
get_header();

$status  = isset( $_GET['invoice'] ) ? sanitize_text_field( wp_unslash( $_GET['invoice'] ) ) : '';
$ctx     = function_exists( 'noaway_invoice_details_context_from_request' ) ? noaway_invoice_details_context_from_request() : array( 'ok' => false, 'error' => 'Form unavailable.' );
$countries = function_exists( 'noaway_invoice_country_options' ) ? noaway_invoice_country_options() : array( 'IT' => 'Italy' );

$posted_name     = isset( $_POST['invoice_full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_full_name'] ) ) : '';
$posted_address  = isset( $_POST['invoice_address'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_address'] ) ) : '';
$posted_city     = isset( $_POST['invoice_city'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_city'] ) ) : '';
$posted_postal    = isset( $_POST['invoice_postal'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_postal'] ) ) : '';
$posted_province = isset( $_POST['invoice_province'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_province'] ) ) : '';
$posted_country  = isset( $_POST['invoice_country'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['invoice_country'] ) ) ) : 'IT';
$posted_tax      = isset( $_POST['invoice_tax_code'] ) ? sanitize_text_field( wp_unslash( $_POST['invoice_tax_code'] ) ) : '';
$posted_notes    = isset( $_POST['invoice_address_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['invoice_address_notes'] ) ) : '';

$full_name = $posted_name !== '' ? $posted_name : ( ! empty( $ctx['name'] ) ? $ctx['name'] : '' );
$country   = isset( $countries[ $posted_country ] ) ? $posted_country : 'IT';
?>
<main>
  <section class="relative pt-8 pb-10 overflow-hidden">
    <div class="max-w-2xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
        <span class="material-symbols-outlined text-sm">receipt_long</span>
        Electronic invoice
      </div>
      <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4 text-slate-900 dark:text-white">
        Billing details
      </h1>
      <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
        Under Italian tax law we must issue an electronic invoice for your NoAway purchase.
        Please enter your personal billing address so we can complete and transmit it.
      </p>
    </div>
    <div class="absolute -top-24 -right-24 size-96 bg-primary/5 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
  </section>

  <section class="max-w-2xl mx-auto px-6 pb-24">
    <?php if ( $status === 'sent' ) : ?>
      <div class="p-6 md:p-8 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-100" role="status">
        <div class="flex items-start gap-3">
          <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-300 shrink-0" aria-hidden="true">check_circle</span>
          <div>
            <p class="font-bold text-lg mb-1">Thank you — details received</p>
            <p class="text-sm leading-relaxed opacity-90">
              We will issue your electronic invoice shortly. A confirmation was also sent to your purchase email.
              Your NoAway license is already active; nothing else is required from you.
            </p>
          </div>
        </div>
      </div>
    <?php elseif ( ! $ctx['ok'] ) : ?>
      <div class="p-6 md:p-8 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-950 dark:text-amber-100" role="alert">
        <div class="flex items-start gap-3">
          <span class="material-symbols-outlined text-amber-600 dark:text-amber-300 shrink-0" aria-hidden="true">link_off</span>
          <div>
            <p class="font-bold text-lg mb-1">Invalid or missing link</p>
            <p class="text-sm leading-relaxed opacity-90 mb-3">
              <?php echo esc_html( ! empty( $ctx['error'] ) ? $ctx['error'] : 'Open this page from the link in your purchase email.' ); ?>
            </p>
            <p class="text-sm">
              Need help?
              <a class="text-primary font-semibold hover:underline" href="mailto:support@noaway.app">support@noaway.app</a>
            </p>
          </div>
        </div>
      </div>
    <?php else : ?>
      <?php if ( $status === 'error' ) : ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm flex items-center gap-2" role="alert">
          <span class="material-symbols-outlined" aria-hidden="true">error</span>
          <span>Please check the required fields (for Italy: 2-letter province and a valid codice fiscale) and try again.</span>
        </div>
      <?php elseif ( $status === 'invalid' ) : ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm flex items-center gap-2" role="alert">
          <span class="material-symbols-outlined" aria-hidden="true">error</span>
          <span>This link is invalid or expired. Contact <a class="underline font-semibold" href="mailto:support@noaway.app">support@noaway.app</a>.</span>
        </div>
      <?php endif; ?>

      <div class="mb-6 p-4 rounded-xl bg-primary/5 border border-primary/20 text-slate-700 dark:text-slate-300 text-sm leading-relaxed">
        <strong class="text-primary">Why we ask:</strong>
        Every sale must be documented with an Italian electronic invoice sent to the Revenue Agency (Sistema di Interscambio).
        A complete personal address is mandatory. This does not affect your license.
      </div>

      <form action="<?php echo esc_url( get_permalink() ); ?>" method="post" class="relative space-y-5 bg-white dark:bg-slate-900 p-6 md:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm" novalidate>
        <?php wp_nonce_field( 'noaway_invoice', 'noaway_invoice_nonce' ); ?>
        <input type="hidden" name="noaway_invoice_form" value="1">
        <input type="hidden" name="invoice_token" value="<?php echo esc_attr( $ctx['token'] ); ?>">
        <input type="hidden" name="invoice_license_key" value="<?php echo esc_attr( $ctx['license_key'] ); ?>">
        <input type="hidden" name="invoice_email" value="<?php echo esc_attr( $ctx['email'] ); ?>">

        <div style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
          <label for="invoice-website">Website</label>
          <input id="invoice-website" type="text" name="invoice_website" value="" tabindex="-1" autocomplete="off">
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-email-display">Purchase email</label>
          <input id="invoice-email-display" class="w-full h-14 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 text-slate-600 dark:text-slate-400 cursor-not-allowed" type="email" value="<?php echo esc_attr( $ctx['email'] ); ?>" readonly>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-full-name">Full name <span class="text-red-500">*</span></label>
          <input id="invoice-full-name" name="invoice_full_name" required autocomplete="name" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="As it should appear on the invoice" type="text" value="<?php echo esc_attr( $full_name ); ?>">
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-address">Street address <span class="text-red-500">*</span></label>
          <input id="invoice-address" name="invoice_address" required autocomplete="street-address" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="Street and number" type="text" value="<?php echo esc_attr( $posted_address ); ?>">
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-city">City / Municipality <span class="text-red-500">*</span></label>
          <input id="invoice-city" name="invoice_city" required autocomplete="address-level2" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="Start typing your city" type="text" value="<?php echo esc_attr( $posted_city ); ?>">
        </div>

        <div class="grid sm:grid-cols-2 gap-5">
          <div class="space-y-2">
            <label class="text-sm font-semibold ml-1" for="invoice-postal">Postal / ZIP code (CAP) <span class="text-red-500">*</span></label>
            <input id="invoice-postal" name="invoice_postal" required autocomplete="postal-code" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="e.g. 20121" type="text" value="<?php echo esc_attr( $posted_postal ); ?>">
          </div>
          <div class="space-y-2">
            <label class="text-sm font-semibold ml-1" for="invoice-province">Province / State <span class="text-red-500">*</span></label>
            <input id="invoice-province" name="invoice_province" required autocomplete="address-level1" maxlength="40" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400" placeholder="e.g. MI" type="text" value="<?php echo esc_attr( $posted_province ); ?>">
            <p id="invoice-province-hint" class="text-xs text-slate-500 ml-1">Italy: 2-letter code (MI, RM, TO…)</p>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-country">Country <span class="text-red-500">*</span></label>
          <select id="invoice-country" name="invoice_country" required class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all text-slate-900 dark:text-slate-100 appearance-none cursor-pointer">
            <?php foreach ( $countries as $code => $label ) : ?>
              <option value="<?php echo esc_attr( $code ); ?>" <?php selected( $country, $code ); ?>><?php echo esc_html( $label ); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="space-y-2" id="invoice-tax-wrap">
          <label class="text-sm font-semibold ml-1" for="invoice-tax-code">
            Tax code (Codice Fiscale)
            <span id="invoice-tax-required-mark" class="text-red-500">*</span>
          </label>
          <input id="invoice-tax-code" name="invoice_tax_code" autocomplete="off" maxlength="16" class="w-full h-14 bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl px-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400 uppercase" placeholder="16 characters" type="text" value="<?php echo esc_attr( $posted_tax ); ?>">
          <p class="text-xs text-slate-500 ml-1">Required if you live in Italy. Leave blank if you do not have an Italian tax code.</p>
        </div>

        <div class="space-y-2">
          <label class="text-sm font-semibold ml-1" for="invoice-address-notes">Address notes <span class="text-slate-400 font-normal">(optional)</span></label>
          <textarea id="invoice-address-notes" name="invoice_address_notes" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl p-5 focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-400 resize-none" placeholder="Apartment, building, c/o…"><?php echo esc_textarea( $posted_notes ); ?></textarea>
        </div>

        <button class="w-full bg-primary text-white font-bold h-14 rounded-xl hover:opacity-95 transition-all flex items-center justify-center gap-2 group" type="submit" name="noaway_invoice_submit">
          Submit billing details
          <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform" aria-hidden="true">send</span>
        </button>
        <p class="text-xs text-center text-slate-500">
          Data is used only to issue your electronic invoice.
          <a class="text-primary hover:underline" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
        </p>
      </form>

      <script>
      (function () {
        var country = document.getElementById('invoice-country');
        var tax = document.getElementById('invoice-tax-code');
        var taxMark = document.getElementById('invoice-tax-required-mark');
        var province = document.getElementById('invoice-province');
        function sync() {
          var it = country && country.value === 'IT';
          if (tax) {
            tax.required = !!it;
            if (!it) { tax.setCustomValidity(''); }
          }
          if (taxMark) { taxMark.style.display = it ? '' : 'none'; }
          if (province && it) {
            province.setAttribute('maxlength', '2');
            province.placeholder = 'e.g. MI';
          } else if (province) {
            province.setAttribute('maxlength', '40');
            province.placeholder = 'State / region';
          }
        }
        if (country) {
          country.addEventListener('change', sync);
          sync();
        }
      })();
      </script>
    <?php endif; ?>
  </section>
</main>
<?php
get_footer();
