<?php
/**
 * Template Name: Download (macOS — universal & Apple Silicon)
 * Assign this template to your Download page in WordPress (Page → Template).
 *
 * Public installers are not linked here. Buttons go to checkout; after payment
 * the thank-you page and license email provide signed download links.
 */

if (! defined('ABSPATH')) {
    exit;
}

$checkout = function_exists('noaway_checkout_url') ? noaway_checkout_url() : 'https://license.noaway.app/create-checkout-session';

get_header();
?>

<main class="noaway-download-wrap">
  <h1>Download NoAway for Mac</h1>
  <p class="lead">
    Buy NoAway first. After payment you receive signed download links (Apple Silicon or Universal) by email and on the thank-you page.
  </p>

  <div class="noaway-download-cards">
    <div class="noaway-card">
      <span class="badge">Recommended · Apple Silicon</span>
      <h2>Apple Silicon (M1, M2, M3, M4, …)</h2>
      <p>
        Native <strong>arm64</strong> build for Macs with an <strong>Apple</strong> chip (any M-series). Available after purchase.
      </p>
      <a class="noaway-btn" href="<?php echo esc_url($checkout); ?>"<?php echo function_exists('noaway_buy_cta_attrs') ? noaway_buy_cta_attrs('macos-arm64') : ''; ?>>Buy NoAway – then download Apple Silicon</a>
    </div>

    <div class="noaway-card">
      <span class="badge">Intel Mac · or unsure</span>
      <h2>Universal (Intel + Apple Silicon)</h2>
      <p>
        One disk image with both Intel (<strong>x64</strong>) and Apple Silicon (<strong>arm64</strong>) slices. Available after purchase.
      </p>
      <a class="noaway-btn" href="<?php echo esc_url($checkout); ?>"<?php echo function_exists('noaway_buy_cta_attrs') ? noaway_buy_cta_attrs('macos-intel') : ''; ?>>Buy NoAway – then download Universal</a>
    </div>
  </div>

  <section class="noaway-help">
    <h2>Which Mac do I have?</h2>
    <ol>
      <li>Click the <strong>Apple menu</strong> in the top-left corner of the screen.</li>
      <li>Select <strong>About This Mac</strong> (or <strong>About This Mac → More Info</strong> on newer macOS).</li>
      <li>Look at <strong>Chip</strong> or <strong>Processor</strong>:
        <ul>
          <li>If you see <strong>Apple M1</strong>, <strong>M2</strong>, <strong>M3</strong>, <strong>M4</strong>, or similar → choose <strong>Apple Silicon (arm64)</strong> from your post-purchase links.</li>
          <li>If you see <strong>Intel</strong> → choose <strong>Universal</strong>.</li>
        </ul>
      </li>
    </ol>
    <p class="noaway-note" style="margin-top:1rem;">
      Already purchased? Use the links in your confirmation email (valid 7 days).
    </p>
  </section>

  <p class="noaway-note">
    <strong>Windows:</strong> the Windows installer is included in the same purchase email and thank-you page.
  </p>
</main>

<?php
get_footer();
