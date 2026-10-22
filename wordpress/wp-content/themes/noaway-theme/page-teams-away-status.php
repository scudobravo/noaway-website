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
  <article class="max-w-6xl mx-auto px-6 pt-12 lg:pt-20 pb-12" itemscope itemtype="https://schema.org/Article">
    <header class="max-w-3xl mb-12 lg:mb-16" data-noaway-sticky-after>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit mb-6">
        <span class="na-eyebrow">Microsoft Teams</span>
      </div>
      <h1 class="na-h1 mb-6" style="text-wrap:balance">
        Why Microsoft Teams shows Away
      </h1>
      <p class="na-lead">
        Microsoft Teams chooses presence from signals such as your activity, calendar, calls, and which client you are using—not from a permanent “always Available” switch. Microsoft documents how presence works for admins in
        <a href="<?php echo esc_url( $ms_presence_url ); ?>" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank">User presence in Teams</a>.
        Use the table below to diagnose what you are seeing before changing settings.
      </p>
      <?php noaway_render_last_reviewed( 'page-teams-away-status.php' ); ?>
    </header>

    <?php ob_start(); ?>
    <section class="mb-14" aria-labelledby="diag-heading">
      <h2 id="diag-heading" class="na-guide-h2 !mt-0">Diagnosis: cause → what you see → what you can do</h2>
      <div class="na-table-wrap na-table-sticky-col">
        <table>
          <thead>
            <tr>
              <th scope="col">Cause</th>
              <th scope="col">What you see</th>
              <th scope="col">What you can do</th>
              <th scope="col">NoAway helps?</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $rows as $row ) : ?>
            <?php
            if ( 'Yes' === $row['noaway'] ) {
              $helps_icon  = 'check_circle';
              $helps_class = 'text-emerald-600';
            } elseif ( 'No' === $row['noaway'] ) {
              $helps_icon  = 'cancel';
              $helps_class = 'text-slate-500';
            } else {
              $helps_icon  = 'remove_circle';
              $helps_class = 'text-amber-600';
            }
            ?>
            <tr>
              <td class="font-semibold text-slate-800 dark:text-slate-200 min-w-[10rem]"><?php echo esc_html( $row['cause'] ); ?></td>
              <td class="text-slate-600 dark:text-slate-400 min-w-[14rem]"><?php echo esc_html( $row['see'] ); ?></td>
              <td class="text-slate-600 dark:text-slate-400 min-w-[14rem]"><?php echo esc_html( $row['do'] ); ?></td>
              <td class="text-slate-800 dark:text-slate-200 font-medium whitespace-nowrap"><span class="inline-flex items-center gap-1.5"><span class="material-symbols-outlined text-xl <?php echo esc_attr( $helps_class ); ?>" aria-hidden="true"><?php echo esc_html( $helps_icon ); ?></span><?php echo esc_html( $row['noaway'] ); ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="mb-14" aria-labelledby="away-vs-heading">
      <h2 id="away-vs-heading" class="na-guide-h2 !mt-0">Away vs Offline vs Appear away</h2>
      <ul class="list-disc pl-5 text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] space-y-3 mb-4">
        <li><strong>Away</strong> — You are signed in; Teams treats you as inactive or sets Away based on presence rules (for example idle on the desktop client).</li>
        <li><strong>Offline</strong> — That client is not connected in a way that shows you as present (app closed, signed out, or no connection for that client).</li>
        <li><strong>Appear away</strong> — A manual status you can set in Teams so others see Away even if you are active. It is a user-chosen status, not the same as automatic idle Away.</li>
      </ul>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        For the full list of presence states and admin configuration, see Microsoft’s
        <a href="<?php echo esc_url( $ms_presence_url ); ?>" class="text-primary font-semibold hover:underline" rel="noopener noreferrer" target="_blank">presence documentation</a>.
      </p>
    </section>

    <section class="mb-14" aria-labelledby="clients-heading">
      <h2 id="clients-heading" class="na-guide-h2 !mt-0">Desktop vs browser vs mobile</h2>
      <p class="text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] mb-4">
        Microsoft documents that presence can differ by client and that organizations can configure presence settings. In practice:
      </p>
      <ul class="list-disc pl-5 text-[17px] text-slate-700 dark:text-slate-300 leading-[1.75] space-y-3 mb-4">
        <li><strong>Desktop</strong> — Presence commonly follows recent keyboard and mouse activity on that computer (often about five minutes without input before Away).</li>
        <li><strong>Browser</strong> — Presence follows the browser session; it is not identical to the desktop idle window in every case.</li>
        <li><strong>Mobile</strong> — Leaving the app or locking the phone can change how that client reports presence.</li>
      </ul>
      <div class="mt-6 flex items-start gap-3 rounded-xl border border-amber-300 bg-amber-50 dark:bg-amber-950/30 dark:border-amber-700/60 p-4 sm:p-5" role="note">
        <span class="material-symbols-outlined text-amber-700 dark:text-amber-400 shrink-0" aria-hidden="true">info</span>
        <p class="m-0 text-[15px] text-amber-900 dark:text-amber-100 leading-relaxed">
          Activity on one device does not automatically keep every other Teams client Available. Prefer Microsoft’s docs over third-party claims when your org has custom policies.
        </p>
      </div>
    </section>

    <?php if ( $faqs ) : ?>
    <section class="mb-6" id="faq" aria-labelledby="faq-heading">
      <h2 id="faq-heading" class="na-guide-h2 !mt-0">Questions about Teams presence</h2>
      <div class="space-y-4">
        <?php foreach ( $faqs as $faq ) : ?>
        <details class="group rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/40 overflow-hidden">
          <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 sm:p-6 min-h-[44px] list-none text-left font-bold text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <span><?php echo esc_html( $faq['name'] ); ?></span>
            <span class="material-symbols-outlined text-slate-400 shrink-0 transition-transform group-open:rotate-180">expand_more</span>
          </summary>
          <div class="px-5 sm:px-6 pb-6 pt-0 text-slate-600 dark:text-slate-400">
            <p class="text-sm leading-relaxed"><?php echo esc_html( $faq['text'] ); ?></p>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
    <?php
    $noaway_guide_body = ob_get_clean();
    // TODO(Andrea): this page's commercial CTA lives on /keep-teams-active/ only (see file header), so the TOC card
    // and sticky bar point to that page with the existing CTA label instead of the Stripe checkout URL.
    noaway_render_guide_layout(
      $noaway_guide_body,
      array(
        'buy_url'   => $teams_active_url,
        'buy_label' => 'Keep Teams active on this computer',
        'tracked'   => false,
        'position'  => 'guide-toc',
      )
    );
    ?>
  </article>

  <?php
  get_template_part(
    'template-parts/cta-final',
    null,
    array(
      'section_id'     => 'download',
      'title'          => 'When idle on this computer is the cause',
      'lines'          => array(
        'If the diagnosis points to inactivity or sleep on this Mac or Windows PC—not calendar, calls, or another device—see <a href="' . esc_url( $teams_active_url ) . '" class="text-white font-semibold underline underline-offset-2 hover:no-underline">how to keep Teams active</a>.',
      ),
      'button_url'     => $teams_active_url,
      'button_label'   => 'Keep Teams active on this computer',
      'cta_position'   => 'none',
    )
  );
  ?>
  <section class="px-6 pb-12 md:pb-16">
    <div class="max-w-5xl mx-auto">
      <?php noaway_render_before_you_buy( 'en', 'horizontal' ); ?>
    </div>
  </section>
</main>
<?php
if ( function_exists( 'noaway_render_sticky_buy_bar' ) ) {
  noaway_render_sticky_buy_bar(
    array(
      'label'   => 'Keep Teams active on this computer',
      'url'     => $teams_active_url,
      'tracked' => false,
    )
  );
}
get_footer();
