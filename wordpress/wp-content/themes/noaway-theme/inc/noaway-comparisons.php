<?php
/**
 * Comparison landing data (NoAway vs X).
 * Keys = page slug. Template: page-compare.php.
 *
 * competitor_todo on rows / points = facts to double-check before publishing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared NoAway column values for comparison tables.
 *
 * @return array<string, string>
 */
function noaway_comparison_noaway_defaults() {
	return array(
		'platforms'         => 'macOS and Windows',
		'keeps_teams_slack' => 'Yes — keeps the system from going idle so Teams/Slack can stay Available',
		'prevents_sleep'    => 'Yes — prevents idle / sleep while Keep Active is on',
		'needs_admin'       => 'No — designed for install without admin rights',
		'price'             => 'One-time €' . NOAWAY_SEO_PRICE_AMOUNT . ' (launch price)',
		'setup'             => 'Download, enable from tray / menu bar',
	);
}

/**
 * All comparison landings keyed by slug.
 *
 * @return array<string, array<string, mixed>>
 */
function noaway_comparisons() {
	$noaway = noaway_comparison_noaway_defaults();

	$comparisons = array(
		'noaway-vs-powertoys-awake' => array(
			'slug'             => 'noaway-vs-powertoys-awake',
			'competitor_name'  => 'PowerToys Awake',
			'competitor_short' => 'Awake',
			'badge'            => 'Comparison',
			'h1'               => 'NoAway vs PowerToys Awake',
			'intro'            => 'Two ways to keep a Windows PC from sleeping during long tasks—and what that means for Teams and Slack status.',
			'seo_title'        => 'NoAway vs PowerToys Awake: Which Keeps Teams Active? | NoAway',
			'seo_description'  => 'PowerToys Awake keeps Windows awake for free. NoAway keeps Mac & Windows from idle so Teams/Slack stay Available—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.',
			'verdict'          => 'PowerToys Awake is a free Microsoft tool that keeps Windows from sleeping during long tasks. NoAway is a focused Mac and Windows tray app that prevents idle so Teams and Slack can stay Available. Choose Awake for free Windows-only sleep control; choose NoAway for cross-platform presence during deep work.',
			'rows'             => array(
				array(
					'label'           => 'Platforms',
					'competitor'      => 'Windows (via Microsoft PowerToys)',
					'competitor_todo' => 'Confirm Awake still ships only with PowerToys and remains Windows-only.',
					'noaway'          => $noaway['platforms'],
				),
				array(
					'label'           => 'Keeps Teams / Slack Available',
					'competitor'      => 'Indirect — prevents sleep; idle/presence behavior depends on OS and app settings',
					'competitor_todo' => 'Confirm whether Awake alone reliably keeps Teams/Slack Available vs only blocking sleep.',
					'noaway'          => $noaway['keeps_teams_slack'],
				),
				array(
					'label'           => 'Prevents sleep',
					'competitor'      => 'Yes — keep awake indefinitely or for a timed interval',
					'competitor_todo' => 'Confirm current Awake modes (indefinite / timed / keep screen on) in latest PowerToys.',
					'noaway'          => $noaway['prevents_sleep'],
				),
				array(
					'label'           => 'Needs admin rights',
					'competitor'      => 'PowerToys install may require elevated rights depending on setup',
					'competitor_todo' => 'Confirm whether current PowerToys / Awake install or runtime needs admin.',
					'noaway'          => $noaway['needs_admin'],
				),
				array(
					'label'           => 'Price',
					'competitor'      => 'Free (open-source PowerToys)',
					'competitor_todo' => 'Confirm PowerToys Awake remains free with no paid tier.',
					'noaway'          => $noaway['price'],
				),
				array(
					'label'           => 'Setup',
					'competitor'      => 'Install Microsoft PowerToys, then enable the Awake module',
					'competitor_todo' => 'Confirm enable path in current PowerToys UI (Settings → Awake).',
					'noaway'          => $noaway['setup'],
				),
			),
			'when_competitor'  => array(
				'heading' => 'When to use PowerToys Awake',
				'intro'   => 'Awake is a strong fit if you already live in the Windows / PowerToys ecosystem and mainly need the machine not to sleep.',
				'points'  => array(
					array(
						'text' => 'You only use Windows and already install (or can install) Microsoft PowerToys.',
						'todo' => 'Confirm any org restrictions on PowerToys in managed environments.',
					),
					array(
						'text' => 'You want a free, Microsoft-maintained way to keep the PC awake for downloads, installs, or overnight jobs.',
						'todo' => 'Confirm Microsoft still maintains Awake inside PowerToys releases.',
					),
					array(
						'text' => 'Your goal is sleep prevention first; Teams/Slack presence is secondary or already fine.',
						'todo' => 'Confirm Awake does not claim Teams/Slack presence as a primary feature in official docs.',
					),
					array(
						'text' => 'You are comfortable configuring modules inside the PowerToys suite rather than a single-purpose tray app.',
						'todo' => 'Confirm Awake is still a toggleable PowerToys module (not a separate installer).',
					),
				),
			),
			'when_noaway'      => array(
				'heading' => 'When to use NoAway',
				'intro'   => 'NoAway is built for people whose main pain is status flipping to Away while they are still working.',
				'points'  => array(
					array( 'text' => 'You need the same workflow on Mac and Windows.' ),
					array( 'text' => 'You care about Teams or Slack staying Available during builds, reads, and long tasks—not only that the display stays on.' ),
					array( 'text' => 'You want a one-click tray / menu-bar control without installing a full utilities suite.' ),
					array( 'text' => 'You prefer a one-time purchase with a product focused on that single job.' ),
				),
			),
			'faqs'             => array(
				array(
					'name'            => 'Is PowerToys Awake the same as keeping Teams Available?',
					'text'            => 'Not exactly. Awake is aimed at keeping Windows from sleeping. Teams and Slack infer presence from activity and idle signals; preventing sleep helps, but it is not identical to a dedicated idle-prevention workflow.',
					'competitor_todo' => 'Confirm wording against current Microsoft PowerToys Awake documentation.',
				),
				array(
					'name'            => 'Can I use PowerToys Awake on a Mac?',
					'text'            => 'No. PowerToys (including Awake) is a Windows toolkit. On Mac, people often look at apps like Amphetamine or NoAway instead.',
					'competitor_todo' => 'Confirm there is still no official macOS PowerToys Awake.',
				),
				array(
					'name' => 'Which should I pick if I use Teams every day?',
					'text' => 'If you only need free Windows sleep control, Awake is excellent. If you want a small Mac and Windows app focused on staying Available on Teams and Slack, NoAway is the better fit.',
				),
			),
		),

		'noaway-vs-amphetamine' => array(
			'slug'             => 'noaway-vs-amphetamine',
			'competitor_name'  => 'Amphetamine',
			'competitor_short' => 'Amphetamine',
			'badge'            => 'Comparison',
			'h1'               => 'NoAway vs Amphetamine',
			'intro'            => 'Two Mac-oriented approaches to staying awake—how they differ for Teams and Slack presence.',
			'seo_title'        => 'NoAway vs Amphetamine: Keep Mac Awake & Teams Active | NoAway',
			'seo_description'  => 'Amphetamine keeps your Mac awake. NoAway prevents idle on Mac & Windows so Teams/Slack stay Available—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.',
			'verdict'          => 'Amphetamine is a popular free Mac menu-bar app for keeping the Mac awake with flexible triggers. NoAway is a focused Mac and Windows utility that prevents idle so Teams and Slack can stay Available. Choose Amphetamine for Mac-only sleep control; choose NoAway for cross-platform presence.',
			'rows'             => array(
				array(
					'label'           => 'Platforms',
					'competitor'      => 'macOS',
					'competitor_todo' => 'Confirm Amphetamine remains Mac-only (no Windows build).',
					'noaway'          => $noaway['platforms'],
				),
				array(
					'label'           => 'Keeps Teams / Slack Available',
					'competitor'      => 'Indirect — keep-awake focused; presence depends on idle signals',
					'competitor_todo' => 'Confirm whether Amphetamine modes affect Teams/Slack presence beyond preventing sleep.',
					'noaway'          => $noaway['keeps_teams_slack'],
				),
				array(
					'label'           => 'Prevents sleep',
					'competitor'      => 'Yes — session-based and trigger-based keep-awake',
					'competitor_todo' => 'Confirm current Amphetamine trigger types (app-based, display, timed).',
					'noaway'          => $noaway['prevents_sleep'],
				),
				array(
					'label'           => 'Needs admin rights',
					'competitor'      => 'Typically no for standard Mac App Store / direct install',
					'competitor_todo' => 'Confirm Amphetamine install path and privilege requirements.',
					'noaway'          => $noaway['needs_admin'],
				),
				array(
					'label'           => 'Price',
					'competitor'      => 'Free (optional tip / related paid apps may exist)',
					'competitor_todo' => 'Confirm Amphetamine pricing and any in-app purchases.',
					'noaway'          => $noaway['price'],
				),
				array(
					'label'           => 'Setup',
					'competitor'      => 'Install on Mac, enable from the menu bar',
					'competitor_todo' => 'Confirm distribution (Mac App Store vs direct) for recommended install.',
					'noaway'          => $noaway['setup'],
				),
			),
			'when_competitor'  => array(
				'heading' => 'When to use Amphetamine',
				'intro'   => 'Amphetamine shines when you want rich Mac keep-awake rules and you only work on macOS.',
				'points'  => array(
					array(
						'text' => 'You are Mac-only and want flexible keep-awake triggers.',
						'todo' => 'Confirm standout Amphetamine features worth listing (triggers, sessions).',
					),
					array(
						'text' => 'You mainly need the Mac not to sleep during long local tasks.',
						'todo' => 'Confirm Amphetamine’s primary positioning is keep-awake (not Teams presence).',
					),
					array(
						'text' => 'You prefer a free Mac menu-bar utility from the Mac ecosystem.',
						'todo' => 'Confirm current App Store / website listing and publisher name.',
					),
				),
			),
			'when_noaway'      => array(
				'heading' => 'When to use NoAway',
				'intro'   => 'Pick NoAway when status on Teams or Slack matters on more than one OS.',
				'points'  => array(
					array( 'text' => 'You use Mac and Windows, or may switch between them.' ),
					array( 'text' => 'You want a simple Keep Active control aimed at presence apps.' ),
					array( 'text' => 'You prefer one product and a one-time license.' ),
				),
			),
			'faqs'             => array(
				array(
					'name'            => 'Does Amphetamine work on Windows?',
					'text'            => 'No. Amphetamine is a macOS app. On Windows, options include PowerToys Awake or NoAway.',
					'competitor_todo' => 'Confirm Amphetamine has no Windows edition under another name.',
				),
				array(
					'name'            => 'Is Amphetamine enough to keep Teams green?',
					'text'            => 'Keeping the Mac awake helps, but Teams still keys off idle/activity. If Away during deep work is the main issue, a dedicated idle-prevention app like NoAway is built for that job.',
					'competitor_todo' => 'Confirm Amphetamine docs do not claim Teams Available as a feature.',
				),
				array(
					'name' => 'Which is better for remote workers on Mac and PC?',
					'text' => 'NoAway covers both platforms with one workflow. Amphetamine is Mac-only.',
				),
			),
		),

		'noaway-vs-caffeine' => array(
			'slug'             => 'noaway-vs-caffeine',
			'competitor_name'  => 'Caffeine',
			'competitor_short' => 'Caffeine',
			'badge'            => 'Comparison',
			'h1'               => 'NoAway vs Caffeine',
			'intro'            => 'Classic keep-awake utilities versus a Teams/Slack-focused idle preventer.',
			'seo_title'        => 'NoAway vs Caffeine: Keep Awake vs Stay Available | NoAway',
			'seo_description'  => 'Caffeine-style apps prevent sleep with a click. NoAway keeps Mac & Windows from idle so Teams/Slack stay Available—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.',
			'verdict'          => 'Caffeine-style apps are simple click-to-stay-awake tools, often free and Mac-oriented. NoAway targets the same “don’t go idle” need with a Mac and Windows product aimed at Teams and Slack staying Available. Use Caffeine for basic keep-awake; use NoAway when presence status is the goal.',
			'rows'             => array(
				array(
					'label'           => 'Platforms',
					'competitor'      => 'Primarily macOS (classic Caffeine); variants exist elsewhere',
					'competitor_todo' => 'Confirm which Caffeine product (classic vs forks) and supported OS list.',
					'noaway'          => $noaway['platforms'],
				),
				array(
					'label'           => 'Keeps Teams / Slack Available',
					'competitor'      => 'Indirect — typically prevents idle/sleep only',
					'competitor_todo' => 'Confirm behavior of the specific Caffeine build regarding OS idle assertions.',
					'noaway'          => $noaway['keeps_teams_slack'],
				),
				array(
					'label'           => 'Prevents sleep',
					'competitor'      => 'Yes — toggle keep-awake from the menu bar',
					'competitor_todo' => 'Confirm timed vs indefinite modes in the referenced Caffeine app.',
					'noaway'          => $noaway['prevents_sleep'],
				),
				array(
					'label'           => 'Needs admin rights',
					'competitor'      => 'Usually no',
					'competitor_todo' => 'Confirm install privileges for the Caffeine build you compare against.',
					'noaway'          => $noaway['needs_admin'],
				),
				array(
					'label'           => 'Price',
					'competitor'      => 'Often free',
					'competitor_todo' => 'Confirm price of the specific Caffeine app/version referenced.',
					'noaway'          => $noaway['price'],
				),
				array(
					'label'           => 'Setup',
					'competitor'      => 'Install and click the cup / menu-bar icon',
					'competitor_todo' => 'Confirm current UI/branding of the Caffeine app you mean.',
					'noaway'          => $noaway['setup'],
				),
			),
			'when_competitor'  => array(
				'heading' => 'When to use Caffeine',
				'intro'   => 'Caffeine is enough when you only need a quick “don’t sleep” toggle.',
				'points'  => array(
					array(
						'text' => 'You want the smallest possible keep-awake control.',
						'todo' => 'Confirm classic Caffeine still installs on current macOS versions.',
					),
					array(
						'text' => 'You are fine with a free, single-purpose menu-bar toggle.',
						'todo' => 'Confirm maintenance/update status of classic Caffeine.',
					),
					array(
						'text' => 'Teams/Slack Away is not your primary concern.',
						'todo' => 'Confirm Caffeine marketing does not claim chat-app presence features.',
					),
				),
			),
			'when_noaway'      => array(
				'heading' => 'When to use NoAway',
				'intro'   => 'Choose NoAway when Away status during work is the problem you are solving.',
				'points'  => array(
					array( 'text' => 'You need Mac and Windows support.' ),
					array( 'text' => 'You want a product positioned around Teams/Slack availability.' ),
					array( 'text' => 'You want ongoing updates under a one-time license.' ),
				),
			),
			'faqs'             => array(
				array(
					'name'            => 'Is Caffeine still maintained?',
					'text'            => 'It depends which Caffeine you mean—the classic Mac app and later forks differ. Check the publisher’s page for the build you install before relying on it long-term.',
					'competitor_todo' => 'Confirm maintenance status for the specific Caffeine compared here.',
				),
				array(
					'name'            => 'Will Caffeine keep Slack active?',
					'text'            => 'It may help by preventing sleep/idle, but it is not a Teams/Slack-specific presence tool. NoAway is built for that workflow on Mac and Windows.',
					'competitor_todo' => 'Confirm Slack/Teams claims (or lack of) on the Caffeine product page.',
				),
				array(
					'name' => 'Is NoAway just Caffeine with a price tag?',
					'text' => 'No. NoAway is a commercial Mac and Windows app focused on keeping the system active for presence apps, with download, license, and support around that use case.',
				),
			),
		),

		'noaway-vs-mouse-jiggler' => array(
			'slug'             => 'noaway-vs-mouse-jiggler',
			'competitor_name'  => 'a mouse jiggler',
			'competitor_short' => 'Mouse jiggler',
			'badge'            => 'Comparison',
			'h1'               => 'NoAway vs a Mouse Jiggler',
			'intro'            => 'Hardware and software jigglers fake movement. NoAway keeps the system active without nudging the cursor.',
			'seo_title'        => 'NoAway vs Mouse Jiggler: Stay Available Without Wiggling | NoAway',
			'seo_description'  => 'Mouse jigglers simulate movement. NoAway prevents idle on Mac & Windows so Teams/Slack stay Available—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.',
			'verdict'          => 'Mouse jigglers (USB dongles or scripts) simulate movement so the PC looks busy. They can work, but they are blunt and sometimes blocked. NoAway keeps the system from going idle with a tray app on Mac and Windows—cleaner for Teams and Slack without moving your cursor.',
			'rows'             => array(
				array(
					'label'           => 'Platforms',
					'competitor'      => 'Varies — USB devices are OS-agnostic; software jigglers differ by platform',
					'competitor_todo' => 'Clarify whether you compare hardware USB jigglers, open-source apps, or both.',
					'noaway'          => $noaway['platforms'],
				),
				array(
					'label'           => 'Keeps Teams / Slack Available',
					'competitor'      => 'Often yes, by faking input — reliability varies',
					'competitor_todo' => 'Confirm common failure modes (security tools, remote desktop, multi-monitor).',
					'noaway'          => $noaway['keeps_teams_slack'],
				),
				array(
					'label'           => 'Prevents sleep',
					'competitor'      => 'Usually, while the jiggler is running or plugged in',
					'competitor_todo' => 'Confirm whether typical hardware jigglers also block display sleep vs only cursor move.',
					'noaway'          => $noaway['prevents_sleep'],
				),
				array(
					'label'           => 'Needs admin rights',
					'competitor'      => 'Hardware: usually none; software scripts may be blocked by IT',
					'competitor_todo' => 'Confirm corporate policy patterns you want to cite.',
					'noaway'          => $noaway['needs_admin'],
				),
				array(
					'label'           => 'Price',
					'competitor'      => 'Hardware often a few dollars; software often free',
					'competitor_todo' => 'Confirm price range you want listed for typical USB jigglers.',
					'noaway'          => $noaway['price'],
				),
				array(
					'label'           => 'Setup',
					'competitor'      => 'Plug in a dongle or run a jiggle script/app',
					'competitor_todo' => 'Confirm whether to discourage scripts explicitly for security reasons.',
					'noaway'          => $noaway['setup'],
				),
			),
			'when_competitor'  => array(
				'heading' => 'When to use a mouse jiggler',
				'intro'   => 'A jiggler can be a quick experiment when you only need crude “something is moving” activity.',
				'points'  => array(
					array(
						'text' => 'You need a temporary hardware workaround on a locked-down PC where you cannot install software.',
						'todo' => 'Confirm honesty bound—some IT policies also ban USB HID jigglers.',
					),
					array(
						'text' => 'You accept cursor movement or a visible dongle as the tradeoff.',
						'todo' => 'Confirm typical hardware jiggler behavior (micro-move vs continuous circle).',
					),
					array(
						'text' => 'You are testing whether idle/presence is even your real problem.',
						'todo' => 'Optional: cite that jigglers do not fix sleep vs idle confusion by themselves.',
					),
				),
			),
			'when_noaway'      => array(
				'heading' => 'When to use NoAway',
				'intro'   => 'Use NoAway when you want a proper app instead of faking mouse moves.',
				'points'  => array(
					array( 'text' => 'You do not want the cursor drifting or a USB stick in the port.' ),
					array( 'text' => 'You want the same Keep Active control on Mac and Windows.' ),
					array( 'text' => 'You prefer a supported product over scripts that break after updates.' ),
				),
			),
			'faqs'             => array(
				array(
					'name'            => 'Do mouse jigglers keep Teams green?',
					'text'            => 'They can, because they generate input. Results vary by device, security software, and remote-desktop setups. Many people switch to an app like NoAway for a cleaner approach.',
					'competitor_todo' => 'Confirm Teams still treats synthetic HID movement as activity in current desktop clients.',
				),
				array(
					'name'            => 'Are mouse jigglers allowed at work?',
					'text'            => 'Often not. Follow your company policy—USB devices and input simulators may be restricted. NoAway also requires policy approval on managed PCs.',
					'competitor_todo' => 'Avoid over-claiming; keep “often not” unless you have a cited policy pattern.',
				),
				array(
					'name' => 'Is NoAway a software mouse jiggler?',
					'text' => 'NoAway prevents the system from going idle; it is not marketed as a cursor-wiggling toy. The goal is stable Available status without moving the mouse.',
				),
			),
		),
	);

	return apply_filters( 'noaway_comparisons', $comparisons );
}

/**
 * @param string $slug Page slug.
 * @return array<string, mixed>|null
 */
function noaway_get_comparison( $slug ) {
	$slug = is_string( $slug ) ? trim( $slug, '/' ) : '';
	if ( $slug === '' ) {
		return null;
	}
	$all = noaway_comparisons();
	return isset( $all[ $slug ] ) ? $all[ $slug ] : null;
}

/**
 * Resolve comparison for the current singular page (by post_name).
 *
 * @return array<string, mixed>|null
 */
function noaway_get_comparison_for_current_page() {
	if ( ! is_singular() ) {
		return null;
	}
	$post = get_queried_object();
	if ( ! $post || empty( $post->post_name ) ) {
		return null;
	}
	return noaway_get_comparison( $post->post_name );
}

/**
 * URL for a comparison landing (template page-compare.php + slug fallback).
 *
 * @param string $slug e.g. noaway-vs-powertoys-awake.
 * @return string
 */
function noaway_compare_page_url( $slug ) {
	$slug = is_string( $slug ) ? trim( $slug, '/' ) : '';
	if ( $slug === '' ) {
		return home_url( '/' );
	}
	return noaway_page_url_by_template_and_slug( 'page-compare.php', $slug, '/' . $slug . '/' );
}

/**
 * Like noaway_page_url_by_template, but prefers a page with matching slug among template matches.
 *
 * @param string $template_file Template file.
 * @param string $slug          Desired post_name.
 * @param string $fallback_path Fallback path.
 * @return string
 */
function noaway_page_url_by_template_and_slug( $template_file, $slug, $fallback_path ) {
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template_file,
			'number'      => 50,
			'sort_column' => 'post_date',
			'sort_order'  => 'ASC',
		)
	);
	if ( ! empty( $pages ) ) {
		foreach ( $pages as $page ) {
			if ( isset( $page->post_name ) && $page->post_name === $slug ) {
				$url = get_permalink( $page->ID );
				if ( is_string( $url ) && $url !== '' ) {
					return function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( $url ) : $url;
				}
			}
		}
	}
	return noaway_page_url_by_template( $template_file, $fallback_path );
}

function noaway_vs_powertoys_awake_page_url() {
	return noaway_compare_page_url( 'noaway-vs-powertoys-awake' );
}
