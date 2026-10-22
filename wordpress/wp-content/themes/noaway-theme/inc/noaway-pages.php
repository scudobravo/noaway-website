<?php
/**
 * NoAway theme — page URLs, checkout, license API, macOS DMG URLs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve permalink for a page using a given template file, or fallback path.
 *
 * @param string $template_file e.g. 'page-downloads.php'.
 * @param string $fallback_path e.g. '/downloads/'.
 */
function noaway_page_url_by_template( $template_file, $fallback_path ) {
	$fallback_path = is_string( $fallback_path ) ? trim( $fallback_path ) : '/';
	if ( $fallback_path === '' ) {
		$fallback_path = '/';
	}
	if ( $fallback_path[0] !== '/' ) {
		$fallback_path = '/' . $fallback_path;
	}

	$base = '';
	if ( defined( 'WP_HOME' ) && WP_HOME ) {
		$base = rtrim( WP_HOME, '/' );
	} else {
		$home = home_url( '/' );
		if ( is_string( $home ) && preg_match( '#^https?://#i', $home ) ) {
			$base = rtrim( $home, '/' );
		}
	}
	$fallback_url = $base !== '' ? $base . $fallback_path : home_url( $fallback_path );

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template_file,
			'number'      => 1,
			'sort_column' => 'post_date',
			'sort_order'  => 'ASC',
		)
	);
	$url = ! empty( $pages ) ? get_permalink( $pages[0]->ID ) : $fallback_url;
	if ( ! is_string( $url ) || $url === '' || $url === '/' ) {
		$url = $fallback_url;
	}
	if ( function_exists( 'noaway_seo_canonical_url' ) ) {
		$url = noaway_seo_canonical_url( $url );
	}
	if ( ! preg_match( '#^https?://#i', $url ) ) {
		$url = $fallback_url;
	}
	return $url;
}

/**
 * Current landing slug for attribution (home, keep-teams-active, …).
 *
 * @return string
 */
function noaway_current_landing_slug() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && ! empty( $post->post_name ) && is_string( $post->post_name ) ) {
			return sanitize_title( $post->post_name );
		}
	}
	$path = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$parsed = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $parsed ) ) {
			$path = trim( $parsed, '/' );
		}
	}
	if ( $path === '' ) {
		return 'home';
	}
	$parts = explode( '/', $path );
	$slug  = end( $parts );
	return $slug ? sanitize_title( $slug ) : 'home';
}

/**
 * Current page path for CTA analytics (e.g. /keep-teams-active/).
 *
 * @return string
 */
function noaway_current_landing_path() {
	if ( is_front_page() ) {
		return '/';
	}
	if ( is_singular() ) {
		$permalink = get_permalink();
		if ( is_string( $permalink ) && $permalink !== '' ) {
			$path = wp_parse_url( $permalink, PHP_URL_PATH );
			if ( is_string( $path ) && $path !== '' ) {
				return trailingslashit( $path );
			}
		}
	}
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( is_string( $path ) && $path !== '' ) {
			return trailingslashit( $path );
		}
	}
	return '/';
}

/**
 * Stripe / license checkout URL, with landing attribution query args.
 *
 * @param array<string,mixed> $args Optional. Keys: ref (slug override).
 * @return string
 */
function noaway_checkout_url( $args = array() ) {
	$base = defined( 'NOAWAY_STRIPE_CHECKOUT_URL' ) ? NOAWAY_STRIPE_CHECKOUT_URL : 'https://license.noaway.app/create-checkout-session';
	if ( ! is_array( $args ) ) {
		$args = array();
	}
	$slug = '';
	if ( isset( $args['ref'] ) && is_string( $args['ref'] ) && $args['ref'] !== '' ) {
		$slug = sanitize_title( $args['ref'] );
	} else {
		$slug = noaway_current_landing_slug();
	}
	if ( $slug !== '' ) {
		// ref = our analytics slug; client_reference_id = Stripe-compatible if the endpoint forwards it.
		$base = add_query_arg(
			array(
				'ref'                  => $slug,
				'client_reference_id'  => $slug,
			),
			$base
		);
	}
	return $base;
}

/**
 * HTML attributes for buy CTAs (tracking + attribution metadata).
 *
 * @param string $position Button position label (hero, footer, header, cta, …).
 * @return string Attributes string starting with a space (safe to echo inside a tag).
 */
function noaway_buy_cta_attrs( $position = 'cta' ) {
	$position = is_string( $position ) ? sanitize_key( $position ) : 'cta';
	if ( $position === '' ) {
		$position = 'cta';
	}
	$path = noaway_current_landing_path();
	$slug = noaway_current_landing_slug();
	return sprintf(
		' data-noaway-cta="buy" data-noaway-path="%s" data-noaway-position="%s" data-noaway-ref="%s"',
		esc_attr( $path ),
		esc_attr( $position ),
		esc_attr( $slug )
	);
}

function noaway_license_api_url() {
	return defined( 'NOAWAY_LICENSE_API_URL' ) ? NOAWAY_LICENSE_API_URL : 'https://license.noaway.app';
}

/** Launch price label, e.g. "€4.99". Amount: NOAWAY_SEO_PRICE_AMOUNT. */
function noaway_price_label() {
	return '€' . NOAWAY_SEO_PRICE_AMOUNT;
}

/** Regular price label, e.g. "€9.99". Amount: NOAWAY_REGULAR_PRICE_AMOUNT. */
function noaway_regular_price_label() {
	return '€' . NOAWAY_REGULAR_PRICE_AMOUNT;
}

/**
 * Optional social-proof label for the homepage.
 * Empty by default so unverified counts are not shown.
 * Supply a real figure via the `noaway_social_proof_label` filter.
 *
 * @return string
 */
function noaway_social_proof_label() {
	$label = apply_filters( 'noaway_social_proof_label', '' );
	if ( ! is_string( $label ) ) {
		return '';
	}
	return trim( $label );
}

/**
 * Public Mac/Windows installer URLs are intentionally not exposed.
 * Anonymous visitors go to checkout; signed links are issued after purchase
 * (thank-you page + license email via api/download.php).
 *
 * Legacy NOAWAY_MAC_*_DMG / NOAWAY_WINDOWS_SETUP_EXE constants are ignored.
 */
function noaway_mac_universal_url() {
	return noaway_checkout_url();
}

function noaway_mac_arm64_url() {
	return noaway_checkout_url();
}

/** Empty = theme templates must send visitors to checkout (not a public .exe). */
function noaway_windows_setup_url() {
	return '';
}

function noaway_features_page_url() {
	return noaway_page_url_by_template( 'page-features.php', '/features/' );
}

function noaway_how_it_works_page_url() {
	return noaway_page_url_by_template( 'page-how-it-works.php', '/how-it-works/' );
}

function noaway_keep_teams_active_page_url() {
	return noaway_page_url_by_template( 'page-keep-teams-active.php', '/keep-teams-active/' );
}

function noaway_teams_away_status_page_url() {
	return noaway_page_url_by_template( 'page-teams-away-status.php', '/teams-away-status/' );
}

function noaway_keep_slack_active_page_url() {
	return noaway_page_url_by_template( 'page-keep-slack-active.php', '/keep-slack-active/' );
}

function noaway_prevent_computer_sleep_page_url() {
	return noaway_page_url_by_template( 'page-prevent-computer-sleep.php', '/prevent-computer-sleep/' );
}

function noaway_is_noaway_safe_page_url() {
	return noaway_page_url_by_template( 'page-is-noaway-safe.php', '/is-noaway-safe/' );
}

function noaway_help_page_url() {
	return noaway_page_url_by_template( 'page-help.php', '/help/' );
}

function noaway_downloads_page_url() {
	// Canonical download URL is /downloads/ (/download/ 301s there).
	return noaway_page_url_by_template( 'page-downloads.php', '/downloads/' );
}

/**
 * Ensure the downloads page uses the /downloads/ slug (idempotent).
 */
function noaway_ensure_downloads_slug() {
	if ( ! function_exists( 'wp_update_post' ) ) {
		return;
	}
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-downloads.php',
			'number'      => 1,
			'post_status' => array( 'publish', 'private', 'draft' ),
		)
	);
	if ( empty( $pages[0] ) ) {
		return;
	}
	$page = $pages[0];
	if ( $page->post_name === 'downloads' ) {
		return;
	}
	$conflict = get_page_by_path( 'downloads', OBJECT, 'page' );
	if ( $conflict instanceof WP_Post && (int) $conflict->ID !== (int) $page->ID ) {
		return;
	}
	$result = wp_update_post(
		array(
			'ID'        => (int) $page->ID,
			'post_name' => 'downloads',
		),
		true
	);
	if ( ! is_wp_error( $result ) ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'after_switch_theme', 'noaway_ensure_downloads_slug' );
add_action( 'admin_init', 'noaway_ensure_downloads_slug', 31 );

function noaway_faq_page_url() {
	return noaway_page_url_by_template( 'page-faq.php', '/faq/' );
}

function noaway_contact_page_url() {
	// Production slug is /contacts/. /contact/ already 301s to /contacts/.
	return noaway_page_url_by_template( 'page-contatti.php', '/contacts/' );
}

/**
 * Responsive <picture> with WebP + PNG fallback for theme images.
 *
 * @param string               $basename Filename without extension under assets/images/ (e.g. landing-hero-section).
 * @param string               $alt      Alt text.
 * @param array<string,mixed>  $attrs    Optional img attrs: class, width, height, loading, fetchpriority, decoding.
 */
function noaway_picture( $basename, $alt, $attrs = array() ) {
	$basename = is_string( $basename ) ? basename( $basename ) : '';
	$basename = preg_replace( '/\.(webp|png|jpe?g|gif|svg|avif)$/i', '', $basename );
	if ( ! is_string( $basename ) || $basename === '' ) {
		return;
	}
	if ( ! is_array( $attrs ) ) {
		$attrs = array();
	}
	$dir   = get_stylesheet_directory() . '/assets/images/';
	$uri   = get_stylesheet_directory_uri() . '/assets/images/';
	$class = isset( $attrs['class'] ) ? (string) $attrs['class'] : '';
	$width = isset( $attrs['width'] ) ? (int) $attrs['width'] : 0;
	$height = isset( $attrs['height'] ) ? (int) $attrs['height'] : 0;
	$loading = isset( $attrs['loading'] ) ? (string) $attrs['loading'] : '';
	$fetchpriority = isset( $attrs['fetchpriority'] ) ? (string) $attrs['fetchpriority'] : '';
	$decoding = isset( $attrs['decoding'] ) ? (string) $attrs['decoding'] : 'async';
	$sizes = isset( $attrs['sizes'] ) ? (string) $attrs['sizes'] : '';
	$widths = array();
	if ( ! empty( $attrs['widths'] ) && is_array( $attrs['widths'] ) ) {
		foreach ( $attrs['widths'] as $candidate ) {
			$candidate = (int) $candidate;
			if ( $candidate > 0 ) {
				$widths[] = $candidate;
			}
		}
	}

	$srcset_for = function ( $ext ) use ( $dir, $uri, $basename, $widths ) {
		$parts = array();
		foreach ( $widths as $w ) {
			$file = $dir . $basename . '-' . $w . '.' . $ext;
			if ( ! file_exists( $file ) ) {
				continue;
			}
			$parts[] = esc_url( $uri . $basename . '-' . $w . '.' . $ext ) . ' ' . $w . 'w';
		}
		return implode( ', ', $parts );
	};

	$img_attrs = '';
	if ( $class !== '' ) {
		$img_attrs .= ' class="' . esc_attr( $class ) . '"';
	}
	if ( $width > 0 ) {
		$img_attrs .= ' width="' . $width . '"';
	}
	if ( $height > 0 ) {
		$img_attrs .= ' height="' . $height . '"';
	}
	if ( $loading !== '' ) {
		$img_attrs .= ' loading="' . esc_attr( $loading ) . '"';
	}
	if ( $fetchpriority !== '' ) {
		$img_attrs .= ' fetchpriority="' . esc_attr( $fetchpriority ) . '"';
	}
	if ( $decoding !== '' ) {
		$img_attrs .= ' decoding="' . esc_attr( $decoding ) . '"';
	}

	$png_srcset = $srcset_for( 'png' );
	$webp_srcset = $srcset_for( 'webp' );
	$avif_srcset = $srcset_for( 'avif' );
	$png = $dir . $basename . '.png';
	$webp = $dir . $basename . '.webp';
	$fallback_src = file_exists( $png ) ? $uri . $basename . '.png' : $uri . $basename . '.webp';
	if ( $png_srcset !== '' && ! empty( $widths ) ) {
		$largest = max( $widths );
		$sized_png = $dir . $basename . '-' . $largest . '.png';
		if ( file_exists( $sized_png ) ) {
			$fallback_src = $uri . $basename . '-' . $largest . '.png';
		}
	}

	$sizes_attr = $sizes !== '' ? ' sizes="' . esc_attr( $sizes ) . '"' : '';
	echo '<picture>';
	if ( $avif_srcset !== '' ) {
		echo '<source type="image/avif" srcset="' . $avif_srcset . '"' . $sizes_attr . '>';
	}
	if ( $webp_srcset !== '' ) {
		echo '<source type="image/webp" srcset="' . $webp_srcset . '"' . $sizes_attr . '>';
	} elseif ( file_exists( $webp ) ) {
		echo '<source type="image/webp" srcset="' . esc_url( $uri . $basename . '.webp' ) . '">';
	}
	if ( $png_srcset !== '' ) {
		$img_attrs .= ' srcset="' . $png_srcset . '"' . $sizes_attr;
	}
	echo '<img' . $img_attrs . ' alt="' . esc_attr( $alt ) . '" src="' . esc_url( $fallback_src ) . '">';
	echo '</picture>';
}

/**
 * Short "what it controls / what it doesn't" block. Same limits as Help.
 *
 * @param string $lang en|de|es|pt-br|fr.
 */
function noaway_render_controls_note( $lang = 'en' ) {
	$lang = is_string( $lang ) ? $lang : 'en';
	$copy = array(
		'en'    => array(
			'h'   => 'What NoAway controls — and what it doesn’t',
			'yes' => 'System activity and sleep on the computer where NoAway is running, while Keep Active is on.',
			'no'  => 'Calendar status, a locked screen, company policy, and presence on other devices.',
		),
		'de'    => array(
			'h'   => 'Was NoAway steuert — und was nicht',
			'yes' => 'Systemaktivität und Ruhezustand auf dem Computer, auf dem NoAway läuft, solange Keep Active an ist.',
			'no'  => 'Kalenderstatus, einen gesperrten Bildschirm, Unternehmensrichtlinien und die Anwesenheit auf anderen Geräten.',
		),
		'es'    => array(
			'h'   => 'Qué controla NoAway — y qué no',
			'yes' => 'La actividad del sistema y la suspensión en el equipo donde NoAway está en marcha, mientras Keep Active está activo.',
			'no'  => 'El estado del calendario, una pantalla bloqueada, las políticas de la empresa y la presencia en otros dispositivos.',
		),
		'pt-br' => array(
			'h'   => 'O que o NoAway controla — e o que não controla',
			'yes' => 'A atividade do sistema e a suspensão no computador em que o NoAway está rodando, enquanto o Keep Active está ligado.',
			'no'  => 'O status do calendário, uma tela bloqueada, as políticas da empresa e a presença em outros dispositivos.',
		),
		'fr'    => array(
			'h'   => 'Ce que NoAway contrôle — et ce qu’il ne contrôle pas',
			'yes' => 'L’activité du système et la veille sur l’ordinateur où NoAway tourne, tant que Keep Active est activé.',
			'no'  => 'Le statut du calendrier, un écran verrouillé, les règles de l’entreprise et la présence sur d’autres appareils.',
		),
	);
	$c = isset( $copy[ $lang ] ) ? $copy[ $lang ] : $copy['en'];
	$yes_label = array(
		'en'    => 'It controls',
		'de'    => 'Es steuert',
		'es'    => 'Controla',
		'pt-br' => 'Controla',
		'fr'    => 'Il contrôle',
	);
	$no_label = array(
		'en'    => 'It doesn’t',
		'de'    => 'Nicht',
		'es'    => 'No controla',
		'pt-br' => 'Não controla',
		'fr'    => 'Il ne contrôle pas',
	);
	$yes = isset( $yes_label[ $lang ] ) ? $yes_label[ $lang ] : $yes_label['en'];
	$no  = isset( $no_label[ $lang ] ) ? $no_label[ $lang ] : $no_label['en'];
	?>
	<section class="noaway-controls-note w-full max-w-3xl rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/40 p-6" aria-labelledby="noaway-controls-heading">
		<h2 id="noaway-controls-heading" class="text-lg font-bold text-slate-900 dark:text-slate-100 mb-4"><?php echo esc_html( $c['h'] ); ?></h2>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
			<div class="flex items-start gap-2">
				<span class="material-symbols-outlined text-emerald-600 shrink-0" aria-hidden="true">check_circle</span>
				<div>
					<p class="font-bold text-slate-800 dark:text-slate-200 mb-1"><?php echo esc_html( $yes ); ?></p>
					<p class="m-0"><?php echo esc_html( $c['yes'] ); ?></p>
				</div>
			</div>
			<div class="flex items-start gap-2">
				<span class="material-symbols-outlined text-slate-500 shrink-0" aria-hidden="true">cancel</span>
				<div>
					<p class="font-bold text-slate-800 dark:text-slate-200 mb-1"><?php echo esc_html( $no ); ?></p>
					<p class="m-0"><?php echo esc_html( $c['no'] ); ?></p>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Data actually sent — single source: inc/noaway-facts.php.
 *
 * @return array<int, array{activity:string,where:string,data:string}>
 */
function noaway_privacy_transfer_rows() {
	if ( function_exists( 'noaway_facts_privacy_transfer_rows' ) ) {
		return noaway_facts_privacy_transfer_rows();
	}
	return array();
}

/**
 * Visible privacy table shared by /is-noaway-safe/ and /privacy-policy/.
 */
function noaway_render_privacy_transfer_table() {
	$rows = noaway_privacy_transfer_rows();
	?>
	<div class="not-prose overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 mb-6">
		<table class="w-full text-left text-sm">
			<thead>
				<tr class="bg-slate-50 dark:bg-slate-900/60">
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Activity</th>
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Where</th>
					<th class="p-4 font-bold text-slate-900 dark:text-slate-100 border-b border-slate-200 dark:border-slate-700">Data sent</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-slate-200 dark:divide-slate-700">
				<?php foreach ( $rows as $row_index => $row ) : ?>
				<tr class="<?php echo ( 0 === $row_index % 2 ) ? 'bg-white dark:bg-slate-900/20' : 'bg-slate-50/70 dark:bg-slate-800/30'; ?>">
					<td class="p-4 font-semibold text-slate-800 dark:text-slate-200 align-top"><?php echo esc_html( $row['activity'] ); ?></td>
					<td class="p-4 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['where'] ); ?></td>
					<td class="p-4 text-slate-600 dark:text-slate-400 align-top"><?php echo esc_html( $row['data'] ); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * “Before you buy” box under primary purchase CTAs.
 *
 * @param string $lang    en|de|es|pt-br|fr
 * @param string $variant compact|horizontal
 */
function noaway_render_before_you_buy( $lang = 'en', $variant = 'compact' ) {
	get_template_part(
		'template-parts/before-you-buy',
		null,
		array(
			'lang'    => $lang,
			'variant' => $variant,
		)
	);
}

/**
 * Short refund line next to price (HTML, already escaped).
 *
 * @param string $lang
 * @param bool   $on_primary White link style for use on the primary-colour card.
 * @return string
 */
function noaway_refund_near_price_html( $lang = 'en', $on_primary = false ) {
	$lang = is_string( $lang ) ? $lang : 'en';
	if ( function_exists( 'noaway_i18n_normalize_lang' ) ) {
		$lang = noaway_i18n_normalize_lang( $lang );
	}
	$labels = array(
		'en'    => 'Not satisfied? Request a refund within 7 days',
		'de'    => 'Nicht zufrieden? Rückerstattung innerhalb von 7 Tagen beantragen',
		'es'    => '¿No estás satisfecho? Solicita un reembolso en 7 días',
		'pt-br' => 'Não ficou satisfeito? Peça reembolso em até 7 dias',
		'fr'    => 'Pas satisfait ? Demandez un remboursement sous 7 jours',
	);
	$label   = isset( $labels[ $lang ] ) ? $labels[ $lang ] : $labels['en'];
	$contact = function_exists( 'noaway_contact_page_url' ) ? noaway_contact_page_url() : home_url( '/contacts/' );
	$cls = $on_primary
		? 'text-white font-semibold underline underline-offset-2 hover:no-underline'
		: 'text-primary font-semibold hover:underline';
	return '<a href="' . esc_url( $contact ) . '" class="inline-flex items-center min-h-[44px] ' . $cls . '">' . esc_html( $label ) . '</a>';
}

function noaway_releases_page_url() {
	return noaway_page_url_by_template( 'page-releases.php', '/releases/' );
}

/**
 * App screenshot slots. Each renders only if the file exists in assets/images/.
 *
 * @return array<int, array{file:string,alt:string,width:int,height:int,caption:string}>
 */
function noaway_app_screenshot_slots() {
	return array(
		array(
			'file'    => 'app-mac-menu.webp',
			'alt'     => 'NoAway menu bar menu on macOS showing the Keep Active toggle and status options',
			'width'   => 800,
			'height'  => 600,
			'caption' => 'macOS: menu bar menu',
		),
		array(
			'file'    => 'app-windows-tray.webp',
			'alt'     => 'NoAway system tray menu on Windows showing the Keep Active toggle and status options',
			'width'   => 800,
			'height'  => 600,
			'caption' => 'Windows: system tray menu',
		),
	);
}

/**
 * Render app screenshots that exist on disk. Silent when none are present.
 *
 * @param string $heading Optional section heading.
 */
function noaway_render_app_screenshots( $heading = 'NoAway in your menu bar and system tray' ) {
	$dir   = trailingslashit( get_template_directory() ) . 'assets/images/';
	$uri   = trailingslashit( get_template_directory_uri() ) . 'assets/images/';
	$items = array();
	foreach ( noaway_app_screenshot_slots() as $slot ) {
		if ( file_exists( $dir . $slot['file'] ) ) {
			$items[] = $slot;
		}
	}
	if ( ! $items ) {
		return;
	}
	?>
	<section class="py-16 px-6" aria-labelledby="noaway-app-screens-heading">
		<div class="max-w-5xl mx-auto">
			<h2 id="noaway-app-screens-heading" class="text-2xl md:text-3xl font-bold mb-8 text-center text-slate-900 dark:text-white"><?php echo esc_html( $heading ); ?></h2>
			<div class="grid gap-8 sm:grid-cols-2 justify-items-center">
				<?php foreach ( $items as $item ) : ?>
				<figure class="w-full max-w-md">
					<img src="<?php echo esc_url( $uri . $item['file'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" width="<?php echo (int) $item['width']; ?>" height="<?php echo (int) $item['height']; ?>" loading="lazy" decoding="async" class="w-full h-auto rounded-xl border border-slate-200 dark:border-slate-700 shadow-lg">
					<figcaption class="mt-3 text-sm text-center text-slate-600 dark:text-slate-400"><?php echo esc_html( $item['caption'] ); ?></figcaption>
				</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Numbered "First setup" section (facts-driven). Place BEFORE troubleshooting.
 *
 * @param string $troubleshooting_url Link target for "not working".
 * @param bool   $embedded            True: render a vertical timeline without the outer <section> (for use inside another section).
 */
function noaway_render_first_setup( $troubleshooting_url = '', $embedded = false ) {
	if ( $troubleshooting_url === '' ) {
		$troubleshooting_url = noaway_help_page_url() . '#troubleshooting';
	}
	$steps = array(
		array(
			'title' => 'Install',
			'text'  => 'Download the installer from your purchase email and install it. Requirements: ' . noaway_fact( 'requirements.macos_min' ) . '; ' . noaway_fact( 'requirements.windows_min' ) . '.',
		),
		array(
			'title' => 'Activate your license',
			'text'  => 'Launch NoAway and enter your license key. ' . noaway_fact( 'license.devices_label' ),
		),
		array(
			'title' => 'Grant Accessibility (Mac only)',
			'text'  => noaway_fact( 'requirements.accessibility' ),
		),
		array(
			'title' => 'Enable Keep Active',
			'text'  => 'Open NoAway from the menu bar or system tray and turn on Keep Active. ' . noaway_fact( 'requirements.process' ),
		),
		array(
			'title' => 'Verify',
			'text'  => 'Leave the computer untouched for about 15 minutes, then check your status in Teams or Slack.',
		),
	);
	if ( $embedded ) :
		?>
	<div id="first-setup" class="scroll-mt-24" aria-labelledby="first-setup-heading">
		<h2 id="first-setup-heading" class="na-h2 mb-8 text-center md:text-left">First setup</h2>
		<ol class="relative list-none p-0 m-0 max-w-3xl before:content-[''] before:absolute before:left-[17px] before:top-2 before:bottom-2 before:w-px before:bg-slate-200 dark:before:bg-slate-700">
			<?php foreach ( $steps as $i => $step ) : ?>
			<li class="relative flex gap-5 pb-8 last:pb-0">
				<span class="relative z-[1] size-9 shrink-0 rounded-full bg-primary text-white font-bold flex items-center justify-center ring-4 ring-white dark:ring-slate-900" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
				<div class="pt-0.5">
					<h3 class="na-h3 !text-lg mb-1"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="text-[15px] text-slate-600 dark:text-slate-400 leading-relaxed mb-0"><?php echo esc_html( $step['text'] ); ?></p>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
		<p class="mt-6 text-slate-600 dark:text-slate-400">
			Not working? Go to <a href="<?php echo esc_url( $troubleshooting_url ); ?>" class="text-primary font-semibold hover:underline inline-flex items-center min-h-[44px]">Troubleshooting</a>.
		</p>
	</div>
		<?php
		return;
	endif;
	?>
	<section id="first-setup" class="py-16 px-6 scroll-mt-24" aria-labelledby="first-setup-heading">
		<div class="max-w-3xl mx-auto">
			<h2 id="first-setup-heading" class="text-3xl font-bold mb-8 text-slate-900 dark:text-white">First setup</h2>
			<ol class="space-y-4 list-none p-0 m-0">
				<?php foreach ( $steps as $i => $step ) : ?>
				<li class="flex gap-4 p-5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
					<span class="size-9 shrink-0 rounded-full bg-primary text-white font-bold flex items-center justify-center" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
					<div>
						<h3 class="text-lg font-bold mb-1 text-slate-900 dark:text-white"><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-0"><?php echo esc_html( $step['text'] ); ?></p>
					</div>
				</li>
				<?php endforeach; ?>
			</ol>
			<p class="mt-6 text-slate-600 dark:text-slate-400">
				Not working? Go to <a href="<?php echo esc_url( $troubleshooting_url ); ?>" class="text-primary font-semibold hover:underline">Troubleshooting</a>.
			</p>
		</div>
	</section>
	<?php
}
