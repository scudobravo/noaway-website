<?php
/**
 * Template Name: Privacy Policy NoAway
 * Template Post Type: page
 * Template selezionabile da editor per Privacy Policy
 */

$privacy_template_path = locate_template('page-privacy-policy.php', false, false);

if (!empty($privacy_template_path)) {
  include $privacy_template_path;
  return;
}

get_header();
?>
<main class="flex-1 px-6 md:px-10 lg:px-40 py-12 md:py-20">
  <div class="max-w-[800px] mx-auto">
    <h1 class="text-slate-900 dark:text-slate-100 text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] mb-4">Privacy Policy</h1>
    <p class="text-slate-700 dark:text-slate-300">Privacy policy template not found.</p>
  </div>
</main>
<?php get_footer(); ?>
