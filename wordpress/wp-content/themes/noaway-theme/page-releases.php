<?php
/**
 * Template Name: Releases NoAway
 * Current version, release date, notes, installer signer verification.
 */
get_header();

$version      = (string) noaway_fact( 'publisher.app_version', '' );
$release_date = (string) noaway_fact( 'publisher.release_date', '' );
$signer       = (string) noaway_fact( 'publisher.signer_display', '' );
if ( $release_date === '' ) {
	$release_date = 'TODO(Andrea)';
}

// Release notes for the current public version (source: noaway/CHANGELOG.md).
$release_notes = array(
	'macOS installers: universal or arm64-only builds, with optional Developer ID signing and notarization.',
	'Windows installers remain Authenticode-signed via the release pipeline.',
	'Idle / scheduler defaults aligned with earlier 1.0.x releases where applicable.',
);
?>
<main class="w-full">
  <section class="relative py-20 px-6 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none"></div>
    <div class="max-w-3xl mx-auto text-center relative z-10">
      <h1 class="text-5xl md:text-6xl font-black tracking-tight mb-6 text-slate-900 dark:text-white">NoAway releases</h1>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
        Current version, release notes, and how to verify your installer.
      </p>
    </div>
  </section>

  <section class="py-12 px-6" aria-labelledby="current-version-heading">
    <div class="max-w-3xl mx-auto">
      <h2 id="current-version-heading" class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Current version</h2>
      <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
          <dt class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Version</dt>
          <dd class="text-2xl font-black text-slate-900 dark:text-white m-0"><?php echo esc_html( $version ); ?></dd>
        </div>
        <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
          <dt class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Release date</dt>
          <dd class="text-2xl font-black text-slate-900 dark:text-white m-0"><?php echo esc_html( $release_date ); ?></dd>
        </div>
      </dl>
      <p class="mt-6 text-slate-600 dark:text-slate-400"><?php echo esc_html( noaway_fact( 'license.lifetime_updates_short' ) ); ?></p>
    </div>
  </section>

  <section class="py-12 px-6 bg-white dark:bg-slate-900/50" aria-labelledby="release-notes-heading">
    <div class="max-w-3xl mx-auto">
      <h2 id="release-notes-heading" class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Release notes<?php echo $version !== '' ? ' — ' . esc_html( $version ) : ''; ?></h2>
      <?php if ( ! empty( $release_notes ) ) : ?>
      <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400">
        <?php foreach ( $release_notes as $note ) : ?>
        <li><?php echo esc_html( $note ); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php else : ?>
      <p class="text-slate-600 dark:text-slate-400">TODO(Andrea)</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="py-12 px-6" aria-labelledby="verify-installer-heading">
    <div class="max-w-3xl mx-auto">
      <h2 id="verify-installer-heading" class="text-3xl font-bold mb-6 text-slate-900 dark:text-white">Verify your installer</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-4">The installer should be signed by <strong><?php echo esc_html( $signer ); ?></strong>.</p>
      <ul class="list-disc list-inside space-y-2 text-slate-600 dark:text-slate-400">
        <li><strong>macOS:</strong> the Developer ID shown by macOS for the app should name <?php echo esc_html( $signer ); ?>.</li>
        <li><strong>Windows:</strong> in the installer file properties, the Digital Signatures tab should list <?php echo esc_html( $signer ); ?> as the signer.</li>
      </ul>
      <p class="mt-6 text-slate-600 dark:text-slate-400">
        Questions? See <a href="<?php echo esc_url( noaway_help_page_url() ); ?>" class="text-primary font-semibold hover:underline">Help</a> or <a href="<?php echo esc_url( noaway_contact_page_url() ); ?>" class="text-primary font-semibold hover:underline">contact support</a>.
      </p>
    </div>
  </section>
</main>
<?php get_footer(); ?>
