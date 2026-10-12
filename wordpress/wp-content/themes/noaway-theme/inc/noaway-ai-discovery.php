<?php
/**
 * NoAway Theme - AI discovery endpoints and feeds.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add explicit RSS/Atom discovery links for AI agents and feed readers.
 */
function noaway_ai_feed_links_in_head() {
	$feed_rss = function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/feed/' ) ) : home_url( '/feed/' );
	$feed_atom = function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/feed/atom/' ) ) : home_url( '/feed/atom/' );
	echo '<link rel="alternate" type="application/rss+xml" title="NoAway RSS Feed" href="' . esc_url( $feed_rss ) . '">' . "\n";
	echo '<link rel="alternate" type="application/atom+xml" title="NoAway Atom Feed" href="' . esc_url( $feed_atom ) . '">' . "\n";
}
add_action( 'wp_head', 'noaway_ai_feed_links_in_head', 1 );

/**
 * Rewrite rules for AI-specific discovery files.
 */
function noaway_ai_discovery_rewrite_rules() {
	add_rewrite_rule( '^llms\.txt$', 'index.php?noaway_llms_txt=1', 'top' );
	add_rewrite_rule( '^\.well-known/ai\.txt$', 'index.php?noaway_ai_txt=1', 'top' );
	add_rewrite_rule( '^ai/summary\.json$', 'index.php?noaway_ai_summary=1', 'top' );
	add_rewrite_rule( '^ai/faq\.json$', 'index.php?noaway_ai_faq=1', 'top' );
	add_rewrite_rule( '^ai/service\.json$', 'index.php?noaway_ai_service=1', 'top' );
}
add_action( 'init', 'noaway_ai_discovery_rewrite_rules' );

/**
 * Register query vars for AI discovery endpoints.
 *
 * @param array $vars Existing query vars.
 * @return array
 */
function noaway_ai_discovery_query_vars( $vars ) {
	$vars[] = 'noaway_llms_txt';
	$vars[] = 'noaway_ai_txt';
	$vars[] = 'noaway_ai_summary';
	$vars[] = 'noaway_ai_faq';
	$vars[] = 'noaway_ai_service';
	return $vars;
}
add_filter( 'query_vars', 'noaway_ai_discovery_query_vars' );

/**
 * Output /llms.txt — factual product card for AI assistants (aligned with JSON-LD).
 */
function noaway_output_llms_txt() {
	$base = function_exists( 'noaway_seo_canonical_url' )
		? noaway_seo_canonical_url( trailingslashit( home_url( '/' ) ) )
		: trailingslashit( home_url( '/' ) );
	$price = defined( 'NOAWAY_SEO_PRICE_AMOUNT' ) ? NOAWAY_SEO_PRICE_AMOUNT : '4.99';
	$sitemap = function_exists( 'noaway_seo_canonical_url' )
		? noaway_seo_canonical_url( home_url( '/sitemap.xml' ) )
		: home_url( '/sitemap.xml' );

	$lines = array(
		'# NoAway',
		'',
		'> NoAway is a desktop productivity app for macOS 11 (Big Sur) or later and Windows 10/11 (64-bit) that keeps your computer from entering an idle state so Microsoft Teams, Slack, and Zoom can stay Available. It prevents system idle at the OS level and does not interact with, inject into, or modify Teams or Slack. It does not keylog, capture your screen, access chat accounts or messages, or collect personal activity data. One-time launch price €' . $price . ' (EUR)—no subscription, no free trial. Support: support@noaway.app',
		'',
		'Base-URL: ' . $base,
		'',
		'## Key pages',
		'',
		'- ' . $base . ' — Product overview: stay Available on Teams and Slack',
		'- ' . noaway_keep_slack_active_page_url() . ' — Keep Slack Active on Mac and Windows (~30 min desktop idle)',
		'- ' . noaway_keep_teams_active_page_url() . ' — Keep Microsoft Teams Available / green icon without jigglers',
		'- ' . noaway_teams_away_status_page_url() . ' — Why Teams shows Away (~5 min idle) and how presence works',
		'- ' . noaway_prevent_computer_sleep_page_url() . ' — Prevent computer sleep and keep the machine awake',
		'- ' . noaway_is_noaway_safe_page_url() . ' — Safety, privacy, admin rights, and what NoAway does not do',
		'- ' . noaway_faq_page_url() . ' — Common questions on install, pricing, privacy, and Teams/Slack',
		'- ' . noaway_downloads_page_url() . ' — Download NoAway for macOS and Windows (one-time €' . $price . ')',
		'',
		'Sitemap: ' . $sitemap,
	);

	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex', true );
	echo implode( "\n", $lines );
	exit;
}

/**
 * Output /.well-known/ai.txt.
 */
function noaway_output_ai_txt() {
	$lines = array(
		'# AI crawler policy for noaway.app',
		'',
		'User-agent: GPTBot',
		'Allow: /',
		'Disallow: /wp-admin/',
		'Disallow: /private/',
		'Disallow: /test/',
		'',
		'User-agent: ClaudeBot',
		'Allow: /',
		'Disallow: /wp-admin/',
		'Disallow: /private/',
		'Disallow: /test/',
		'',
		'User-agent: PerplexityBot',
		'Allow: /',
		'Disallow: /wp-admin/',
		'Disallow: /private/',
		'Disallow: /test/',
		'',
		'Sitemap: ' . ( function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/sitemap.xml' ) ) : home_url( '/sitemap.xml' ) ),
		'llms: ' . ( function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/llms.txt' ) ) : home_url( '/llms.txt' ) ),
	);

	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex', true );
	echo implode( "\n", $lines );
	exit;
}

/**
 * JSON encoder helper.
 *
 * @param array $payload Data to encode.
 */
function noaway_output_ai_json( $payload ) {
	header( 'Content-Type: application/json; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex', true );
	echo wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
	exit;
}

/**
 * Output /ai/summary.json.
 */
function noaway_output_ai_summary_json() {
	$home = function_exists( 'noaway_seo_canonical_url' )
		? noaway_seo_canonical_url( trailingslashit( home_url( '/' ) ) )
		: trailingslashit( home_url( '/' ) );
	$payload = array(
		'site'        => 'NoAway',
		'url'         => $home,
		'description' => 'NoAway is a desktop app for macOS and Windows that prevents computer idle so Microsoft Teams and Slack stay Available.',
		'focus_topics' => array(
			'keep teams active',
			'prevent teams away',
			'keep teams icon green',
			'prevent computer sleep',
		),
		'important_pages' => array(
			noaway_keep_teams_active_page_url(),
			noaway_teams_away_status_page_url(),
			noaway_is_noaway_safe_page_url(),
			noaway_downloads_page_url(),
		),
		'feeds' => array(
			function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/feed/' ) ) : home_url( '/feed/' ),
			function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/feed/atom/' ) ) : home_url( '/feed/atom/' ),
		),
		'sitemap' => function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( home_url( '/sitemap.xml' ) ) : home_url( '/sitemap.xml' ),
	);
	noaway_output_ai_json( $payload );
}

/**
 * Output /ai/faq.json.
 */
function noaway_output_ai_faq_json() {
	$entities = function_exists( 'noaway_seo_faq_schema_entities' ) ? noaway_seo_faq_schema_entities() : array();
	$faqs     = array();
	foreach ( $entities as $item ) {
		$faqs[] = array(
			'question' => isset( $item['name'] ) ? $item['name'] : '',
			'answer'   => isset( $item['text'] ) ? $item['text'] : '',
		);
	}
	$payload = array(
		'type' => 'FAQ',
		'site' => 'NoAway',
		'url'  => noaway_faq_page_url(),
		'faq'  => $faqs,
	);
	noaway_output_ai_json( $payload );
}

/**
 * Output /ai/service.json.
 */
function noaway_output_ai_service_json() {
	$payload = array(
		'service' => 'NoAway',
		'category' => 'Desktop productivity utility',
		'platforms' => array( 'macOS', 'Windows' ),
		'capabilities' => array(
			'Prevent operating system idle state',
			'Keep Microsoft Teams status available by preventing idle',
			'Keep Slack status active by preventing idle',
			'Run in tray/menu bar with lightweight resource usage',
		),
		'pricing' => array(
			'model' => 'one-time purchase',
			'currency' => NOAWAY_SEO_PRICE_CURRENCY,
			'price' => NOAWAY_SEO_PRICE_AMOUNT,
		),
		'links' => array(
			'download' => noaway_downloads_page_url(),
			'help'     => noaway_help_page_url(),
			'faq'      => noaway_faq_page_url(),
		),
	);
	noaway_output_ai_json( $payload );
}

/**
 * Route AI discovery requests.
 */
function noaway_ai_discovery_template_redirect() {
	if ( (int) get_query_var( 'noaway_llms_txt' ) === 1 ) {
		noaway_output_llms_txt();
	}
	if ( (int) get_query_var( 'noaway_ai_txt' ) === 1 ) {
		noaway_output_ai_txt();
	}
	if ( (int) get_query_var( 'noaway_ai_summary' ) === 1 ) {
		noaway_output_ai_summary_json();
	}
	if ( (int) get_query_var( 'noaway_ai_faq' ) === 1 ) {
		noaway_output_ai_faq_json();
	}
	if ( (int) get_query_var( 'noaway_ai_service' ) === 1 ) {
		noaway_output_ai_service_json();
	}
}
add_action( 'template_redirect', 'noaway_ai_discovery_template_redirect', 1 );
