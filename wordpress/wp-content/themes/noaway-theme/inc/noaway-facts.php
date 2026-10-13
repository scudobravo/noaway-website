<?php
/**
 * Single source of truth for product facts (privacy, license, benefit, requirements, publisher).
 * All pages, FAQ, JSON-LD, i18n, and llms.txt should read from here — do not hardcode these claims elsewhere.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full facts array.
 *
 * @return array<string, mixed>
 */
function noaway_facts() {
	static $facts = null;
	if ( $facts !== null ) {
		return $facts;
	}

	$help_url = function_exists( 'noaway_help_page_url' ) ? noaway_help_page_url() : home_url( '/help/' );
	$price    = defined( 'NOAWAY_SEO_PRICE_AMOUNT' ) ? NOAWAY_SEO_PRICE_AMOUNT : '4.99';

	$facts = array(
		'benefit' => array(
			'full'  => 'NoAway keeps your computer active while it is switched on. Whether Teams or Slack show you as Available also depends on permissions and on the conditions listed in Help.',
			'short' => array(
				'en'    => 'NoAway keeps your computer active while it is on. Teams/Slack Available also depends on permissions and Help conditions.',
				'de'    => 'NoAway hält den Computer aktiv, solange er eingeschaltet ist. Ob Teams/Slack dich als Verfügbar zeigen, hängt auch von Berechtigungen und den Bedingungen unter Hilfe ab.',
				'es'    => 'NoAway mantiene el equipo activo mientras está encendido. Que Teams/Slack te muestren Disponible también depende de permisos y de las condiciones en Ayuda.',
				'pt-br' => 'O NoAway mantém o computador ativo enquanto está ligado. Se Teams/Slack mostram Disponível também depende de permissões e das condições em Ajuda.',
				'fr'    => 'NoAway garde l’ordinateur actif tant qu’il est allumé. L’affichage Disponible dans Teams/Slack dépend aussi des autorisations et des conditions indiquées dans l’Aide.',
			),
			'help_url' => $help_url,
		),

		'data_sent' => array(
			'full' => 'NoAway does not send activity, usage or personal data. The keep-active feature runs entirely on your computer. The only network request is the license check, which sends your license key and a device identifier so the license works on one device.',
			'short' => array(
				'en'    => 'NoAway does not send activity, usage or personal data. Keep Active runs on your computer. The only network request is the license check (license key + device id).',
				'de'    => 'NoAway sendet keine Aktivitäts-, Nutzungs- oder personenbezogenen Daten. Keep Active läuft lokal. Die einzige Netzwerkanfrage ist die Lizenzprüfung (Lizenzschlüssel + Geräte-ID).',
				'es'    => 'NoAway no envía datos de actividad, uso ni personales. Keep Active se ejecuta en tu equipo. La única petición de red es la comprobación de licencia (clave + id de dispositivo).',
				'pt-br' => 'O NoAway não envia dados de atividade, uso ou pessoais. O Keep Active roda no seu computador. A única requisição de rede é a verificação de licença (chave + id do dispositivo).',
				'fr'    => 'NoAway n’envoie pas de données d’activité, d’usage ou personnelles. Keep Active tourne sur votre ordinateur. La seule requête réseau est la vérification de licence (clé + identifiant appareil).',
			),
			// Confirmed from desktop app licenseManager.js: POST /activate at activation; POST /validate at start and every 24h.
			'when'           => 'at_activation_and_periodic',
			'when_label'     => 'License check runs when you activate, and again periodically while the app is installed (about once every 24 hours) to confirm the license is still valid on this device.',
			'activation'     => 'Activation also sends the purchase email with the license key and device id.',
			'no_telemetry'   => true,
			// Fields that must NOT appear in site copy (Andrea 13 Oct 2026): activity mode, detected app names, active seconds.
			'not_sent'       => array( 'activity_mode', 'detected_apps', 'active_seconds_today', 'keystrokes', 'screen', 'chats', 'files' ),
		),

		'license' => array(
			'devices_per_license' => 1,
			'devices_label'       => 'One license works on one device.',
			'lifetime_updates'    => 'Lifetime updates means future versions are emailed to buyers with a direct download link to the new version.',
			'lifetime_updates_short' => 'Updates are emailed to buyers with a direct download link.',
			'refund'              => 'Not satisfied? Request a refund within 7 days of purchase via support. On refund, the license is deactivated.',
			'refund_days'         => 7,
			'same_license_mac_win' => 'TODO(Andrea)', // Same license for Mac and Windows?
			'transfer'            => 'TODO(Andrea)', // How to move to a new computer.
			'recover_download'    => 'TODO(Andrea)', // Recover download after 7-day link expiry.
			'offline'             => 'TODO(Andrea)', // Offline use after activation (grace / duration).
			'price_final_vat'     => 'TODO(Andrea)', // Final price and VAT treatment (current launch label uses €' . $price . ').
			'price_label_current' => '€' . $price,
		),

		'requirements' => array(
			'macos_min'     => 'macOS 11 (Big Sur) or later',
			'windows_min'   => 'Windows 10/11 (64-bit)',
			'accessibility' => 'On macOS, Accessibility permission is required so the system (and apps like Teams) treat simulated input as real activity. Grant it under System Settings → Privacy & Security → Accessibility, then quit and reopen NoAway.',
			'process'       => 'You can close the NoAway window; the process must keep running (menu bar on Mac, system tray on Windows).',
			'known_limits'  => array(
				'Calendar status, a locked screen, company policy, and presence on other devices are outside what Keep Active controls.',
				'On some Macs, depending on model or macOS version, the system may still not count simulated input as activity; NoAway will still keep the display awake and prevent sleep.',
				'On Windows, antivirus or security software can block the kind of activity NoAway uses.',
				'Always follow your employer’s software policy on managed devices.',
			),
		),

		'publisher' => array(
			'company'            => 'OLIVEE SRLS',
			'brand'              => 'NoAway',
			'signer_display'     => 'OLIVEE SRLS', // Name buyers should verify on the signed installer (Mac Developer ID / Windows Authenticode).
			'app_version'        => '1.0.6', // From sibling app package.json in this workspace.
			'release_date'       => 'TODO(Andrea)', // Last public release date.
			'support_email'      => 'support@noaway.app',
		),
	);

	return $facts;
}

/**
 * @param string $dot_path Dot path, e.g. "benefit.full" or "license.devices_per_license".
 * @param mixed  $default
 * @return mixed
 */
function noaway_fact( $dot_path, $default = null ) {
	$parts = explode( '.', (string) $dot_path );
	$node  = noaway_facts();
	foreach ( $parts as $part ) {
		if ( ! is_array( $node ) || ! array_key_exists( $part, $node ) ) {
			return $default;
		}
		$node = $node[ $part ];
	}
	return $node;
}

/**
 * Localized short string from a facts map keyed by lang.
 *
 * @param string $dot_path Path to an array of lang => string (e.g. "benefit.short").
 * @param string $lang
 * @return string
 */
function noaway_fact_i18n( $dot_path, $lang = 'en' ) {
	$map  = noaway_fact( $dot_path, array() );
	$lang = is_string( $lang ) ? $lang : 'en';
	if ( ! is_array( $map ) ) {
		return is_string( $map ) ? $map : '';
	}
	if ( isset( $map[ $lang ] ) && is_string( $map[ $lang ] ) ) {
		return $map[ $lang ];
	}
	return isset( $map['en'] ) && is_string( $map['en'] ) ? $map['en'] : '';
}

/**
 * Canonical data_sent paragraph (EN), optionally with when + activation notes.
 *
 * @param bool $include_when
 * @return string
 */
function noaway_fact_data_sent_paragraph( $include_when = true ) {
	$text = (string) noaway_fact( 'data_sent.full', '' );
	if ( $include_when ) {
		$when = (string) noaway_fact( 'data_sent.when_label', '' );
		if ( $when !== '' ) {
			$text .= ' ' . $when;
		}
		$activation = (string) noaway_fact( 'data_sent.activation', '' );
		if ( $activation !== '' ) {
			$text .= ' ' . $activation;
		}
	}
	return $text;
}

/**
 * Benefit + single Help link sentence for page bodies (EN).
 *
 * @return string Plain text (no HTML).
 */
function noaway_fact_benefit_with_help_plain() {
	$benefit = (string) noaway_fact( 'benefit.full', '' );
	return $benefit . ' See Help for the full list of conditions.';
}

/**
 * Privacy transfer rows derived from facts (no activity/usage telemetry fields).
 *
 * @return array<int, array{activity:string,where:string,data:string}>
 */
function noaway_facts_privacy_transfer_rows() {
	$data = (string) noaway_fact( 'data_sent.full', '' );
	$when = (string) noaway_fact( 'data_sent.when_label', '' );
	$act  = (string) noaway_fact( 'data_sent.activation', '' );

	return array(
		array(
			'activity' => 'Keep Active',
			'where'    => 'On your computer',
			'data'     => 'Nothing leaves your computer for idle and sleep prevention. NoAway does not send keystrokes, screen contents, chats, files, activity mode, detected app names, or active-time counters.',
		),
		array(
			'activity' => 'Activation',
			'where'    => 'License server (license.noaway.app)',
			'data'     => $act !== '' ? $act : 'License key, the email used at purchase, and a device id.',
		),
		array(
			'activity' => 'License check',
			'where'    => 'License server (license.noaway.app)',
			'data'     => trim( $data . ( $when !== '' ? ' ' . $when : '' ) ),
		),
		array(
			'activity' => 'Updates',
			'where'    => 'Email to the purchase address',
			'data'     => (string) noaway_fact( 'license.lifetime_updates', '' ),
		),
		array(
			'activity' => 'Purchase',
			'where'    => 'Stripe, via the license server',
			'data'     => 'Stripe collects the payment. This website only adds a landing reference (ref and client_reference_id) to the checkout URL.',
		),
		array(
			'activity' => 'Website',
			'where'    => 'Google Analytics 4, only after analytics consent',
			'data'     => 'Page views. Buy-button clicks record the page path, button position, and landing reference in this site’s analytics.',
		),
		array(
			'activity' => 'Support',
			'where'    => 'Email to support@noaway.app',
			'data'     => 'Name, email, topic, subject, and message from the contact form. A reCAPTCHA token is included only if a site key is configured.',
		),
	);
}

/**
 * Collect TODO(Andrea) markers currently present in facts.
 *
 * @return array<int, array{key:string,value:string}>
 */
function noaway_facts_todos() {
	$todos = array();
	$walk  = function ( $node, $prefix ) use ( &$todos, &$walk ) {
		if ( is_string( $node ) && strpos( $node, 'TODO(Andrea)' ) !== false ) {
			$todos[] = array(
				'key'   => $prefix,
				'value' => $node,
			);
			return;
		}
		if ( ! is_array( $node ) ) {
			return;
		}
		foreach ( $node as $k => $v ) {
			$path = $prefix === '' ? (string) $k : $prefix . '.' . $k;
			$walk( $v, $path );
		}
	};
	$walk( noaway_facts(), '' );
	return $todos;
}
