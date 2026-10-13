<?php
/**
 * Template Name: Teams Away Status SEO
 * Diagnostic guide: why Teams shows Away.
 * Commercial CTA lives on /keep-teams-active/ only.
 */
get_header();

$teams_active_url = noaway_keep_teams_active_page_url();
$ms_presence_url  = 'https://learn.microsoft.com/en-us/microsoftteams/presence-admins';

$faqs = function_exists( 'noaway_seo_landing_faq_items' ) ? noaway_seo_landing_faq_items( 'page-teams-away-status.php' ) : array();
if ( ! is_array( $faqs ) ) {
	$faqs = array();
}

$rows = array(
	array(
		'cause'   => 'Inactivity (no keyboard or mouse)',
		'see'     => 'Status turns Away (yellow) after roughly five minutes on the desktop app',
		'do'      => 'Keep the computer reporting activity, or interact briefly before long idle stretches',
		'noaway'  => 'Yes',
	),
	array(
		'cause'   => 'Lock screen',
		'see'     => 'Presence can flip to Away while the screen is locked',
		'do'      => 'Unlock when you need Available; locking stops input signals',
		'noaway'  => 'In part',
	),
	array(
		'cause'   => 'Sleep / suspend',
		'see'     => 'Machine sleeps or hibernates; Teams session looks idle or disconnects',
		'do'      => 'Adjust power settings if you need the machine awake; sleep ≠ presence',
		'noaway'  => 'Yes',
	),
	array(
		'cause'   => 'Teams in background or closed',
		'see'     => 'Desktop client may still follow idle rules; closed client can show Offline on that device',
		'do'      => 'Leave the desktop app signed in when you care about that device’s presence',
		'noaway'  => 'In part',
	),
	array(
		'cause'   => 'Calendar and meetings',
		'see'     => 'Busy, In a meeting, or Out of office from calendar state',
		'do'      => 'Check calendar blocks; presence from meetings is separate from idle',
		'noaway'  => 'No',
	),
	array(
		'cause'   => 'Calls',
		'see'     => 'On a call / In a call style presence while a call is active',
		'do'      => 'Call state is controlled by Teams calling, not by idle prevention',
		'noaway'  => 'No',
	),
	array(
		'cause'   => 'Other devices / mobile',
		'see'     => 'Presence may reflect another signed-in client (phone, second PC)',
		'do'      => 'Check which device Teams is using for presence; activity on one device does not drive all clients the same way',
		'noaway'  => 'No',
	),
	array(
		'cause'   => 'Company / admin policy',
		'see'     => 'Status options or presence behavior limited by org settings',
		'do'      => 'Ask IT; admin presence policies can override what you expect',
		'noaway'  => 'No',
	),
);
?>
<main>
  <article class="max-w-4xl mx-auto px-6 py-16 lg:py-24">
    <header class="mb-12">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="text-primary text-xs font-bold uppercase tracking-wider">Microsoft Teams</span>
      </div>
      <h1 class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-slate-100 mb-6">
        Why Microsoft Teams shows Away
      </h1>
      <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
        Microsoft Teams chooses presence from signals such as your activity, calendar, calls, and which client you are using—not from a permanent “always Available” switch. Microsoft documents how presence works for admins in
        <a href="<?php echo esc_url( $ms_presence_url ); ?>" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank">User presence in Teams</a>.
        Use the table below to diagnose what you are seeing before changing settings.
      </p>
      <?php noaway_render_last_reviewed( 'page-teams-away-status.php' ); ?>
    </header>

    <section class="mb-16" aria-labelledby="diag-heading">
      <h2 id="diag-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6">Diagnosis: cause → what you see → what you can do</h2>
      <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900/60">
              <th class="p-3 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Cause</th>
              <th class="p-3 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">What you see</th>
              <th class="p-3 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">What you can do</th>
              <th class="p-3 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">NoAway helps?</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <?php foreach ( $rows as $row ) : ?>
            <tr>
              <td class="p-3 font-semibold text-slate-800 dark:text-slate-200 align-top"><?php echo esc_html( $row['cause'] ); ?></td>
              <td class="p-3 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['see'] ); ?></td>
              <td class="p-3 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['do'] ); ?></td>
              <td class="p-3 text-slate-800 dark:text-slate-200 align-top font-medium"><?php echo esc_html( $row['noaway'] ); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="away-vs-heading">
      <h2 id="away-vs-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Away vs Offline vs Appear away</h2>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3">
        <li><strong>Away</strong> — You are signed in; Teams treats you as inactive or sets Away based on presence rules (for example idle on the desktop client).</li>
        <li><strong>Offline</strong> — That client is not connected in a way that shows you as present (app closed, signed out, or no connection for that client).</li>
        <li><strong>Appear away</strong> — A manual status you can set in Teams so others see Away even if you are active. It is a user-chosen status, not the same as automatic idle Away.</li>
      </ul>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mt-4">
        For the full list of presence states and admin configuration, see Microsoft’s
        <a href="<?php echo esc_url( $ms_presence_url ); ?>" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank">presence documentation</a>.
      </p>
    </section>

    <section class="prose prose-slate dark:prose-invert max-w-none mb-16" aria-labelledby="clients-heading">
      <h2 id="clients-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4">Desktop vs browser vs mobile</h2>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
        Microsoft documents that presence can differ by client and that organizations can configure presence settings. In practice:
      </p>
      <ul class="list-disc pl-5 text-slate-600 dark:text-slate-400 leading-relaxed space-y-3">
        <li><strong>Desktop</strong> — Presence commonly follows recent keyboard and mouse activity on that computer (often about five minutes without input before Away).</li>
        <li><strong>Browser</strong> — Presence follows the browser session; it is not identical to the desktop idle window in every case.</li>
        <li><strong>Mobile</strong> — Leaving the app or locking the phone can change how that client reports presence.</li>
      </ul>
      <p class="text-slate-600 dark:text-slate-400 leading-relaxed mt-4">
        Activity on one device does not automatically keep every other Teams client Available. Prefer Microsoft’s docs over third-party claims when your org has custom policies.
      </p>
    </section>

    <?php if ( $faqs ) : ?>
    <section class="mb-16" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-8">Questions about Teams presence</h2>
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
    <?php endif; ?>

    <section class="rounded-2xl bg-primary/5 dark:bg-primary/10 border border-primary/20 p-8 text-center" aria-labelledby="cta-heading">
      <h2 id="cta-heading" class="text-xl font-bold text-slate-900 dark:text-slate-100 mb-3">When idle on this computer is the cause</h2>
      <p class="text-slate-600 dark:text-slate-400 mb-6 max-w-xl mx-auto">
        If the diagnosis points to inactivity or sleep on this Mac or Windows PC—not calendar, calls, or another device—see
        <a href="<?php echo esc_url( $teams_active_url ); ?>" class="text-primary font-semibold hover:underline">how to keep Teams active</a>.
      </p>
      <a href="<?php echo esc_url( $teams_active_url ); ?>" class="inline-flex items-center justify-center gap-2 bg-primary text-white px-8 py-4 rounded-xl text-lg font-bold hover:scale-[1.02] active:scale-[0.98] transition-all">
        Keep Teams active on this computer
      </a>
    </section>
  </article>
</main>
<?php get_footer(); ?>
