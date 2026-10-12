<?php
/**
 * Template Name: Download (macOS — universal & Apple Silicon)
 * Assign this template to your Download page in WordPress (Page → Template).
 *
 * Set real DMG URLs in wp-config.php:
 *   define('NOAWAY_MAC_UNIVERSAL_DMG', 'https://noaway.app/path/NoAway-x.y.z.dmg');
 *   define('NOAWAY_MAC_ARM64_DMG', 'https://noaway.app/path/NoAway-x.y.z-arm64.dmg');
 */

if (! defined('ABSPATH')) {
    exit;
}

$mac_universal = function_exists('noaway_mac_universal_url') ? noaway_mac_universal_url() : 'https://noaway.app/download/';
$mac_arm64 = function_exists('noaway_mac_arm64_url') ? noaway_mac_arm64_url() : 'https://noaway.app/download/';

get_header();
?>

<main class="noaway-download-wrap">
  <h1>Download NoAway for Mac</h1>
  <p class="lead">
    Choose the build that matches your Mac. If you are not sure, follow the steps under <strong>Which Mac do I have?</strong> below.
  </p>

  <div class="noaway-download-cards">
    <div class="noaway-card">
      <span class="badge">Recommended · Apple Silicon</span>
      <h2>Apple Silicon (M1, M2, M3, M4, …)</h2>
      <p>
        Smaller download, native <strong>arm64</strong> app. Use this if your Mac has an <strong>Apple</strong> chip (any M-series).
      </p>
      <a class="noaway-btn" href="<?php echo esc_url($mac_arm64); ?>">Download (Apple Silicon)</a>
      <p class="noaway-note" style="margin-top:1rem;margin-bottom:0;font-size:0.85rem;">
        File name usually contains <code>arm64</code>.
      </p>
    </div>

    <div class="noaway-card">
      <span class="badge">Intel Mac · or unsure</span>
      <h2>Universal (Intel + Apple Silicon)</h2>
      <p>
        One disk image with both Intel (<strong>x64</strong>) and Apple Silicon (<strong>arm64</strong>) slices. Use this if you have an <strong>Intel</strong> Mac, or you need a single installer for mixed environments.
      </p>
      <a class="noaway-btn" href="<?php echo esc_url($mac_universal); ?>">Download (Universal)</a>
      <p class="noaway-note" style="margin-top:1rem;margin-bottom:0;font-size:0.85rem;">
        Larger file; works on all supported Macs.
      </p>
    </div>
  </div>

  <section class="noaway-help">
    <h2>Which Mac do I have?</h2>
    <ol>
      <li>Click the <strong>Apple menu</strong> in the top-left corner of the screen.</li>
      <li>Select <strong>About This Mac</strong> (or <strong>About This Mac → More Info</strong> on newer macOS).</li>
      <li>Look at <strong>Chip</strong> or <strong>Processor</strong>:
        <ul>
          <li>If you see <strong>Apple M1</strong>, <strong>M2</strong>, <strong>M3</strong>, <strong>M4</strong>, or similar → your Mac is <strong>Apple Silicon</strong>. Download <strong>Apple Silicon (arm64)</strong>.</li>
          <li>If you see <strong>Intel</strong> → choose <strong>Universal</strong> (the universal DMG includes the Intel build).</li>
        </ul>
      </li>
    </ol>
    <p class="noaway-note" style="margin-top:1rem;">
      After purchase, your email may also include direct download links. Use the same rule: <strong>arm64</strong> for Apple Silicon, <strong>universal</strong> for Intel or if you prefer one installer for every Mac.
    </p>
  </section>

  <p class="noaway-note">
    <strong>Windows:</strong> use the Windows download from this site or the link in your purchase email.
  </p>
</main>

<?php
get_footer();
