<?php
/**
 * Localized Slack and Teams landings: /de/, /es/, /pt-br/, /fr/.
 * One layout per page; copy is selected with $lang.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/noaway-i18n-slack.php';
require_once __DIR__ . '/noaway-i18n-teams.php';

/**
 * @return array<int, string>
 */
function noaway_i18n_langs() {
	return array( 'en', 'de', 'es', 'pt-br', 'fr' );
}

/**
 * @param string $lang
 * @return string
 */
function noaway_i18n_normalize_lang( $lang ) {
	$lang = is_string( $lang ) ? strtolower( trim( $lang ) ) : '';
	if ( $lang === 'pt' || $lang === 'pt_br' || $lang === 'pt-br' ) {
		return 'pt-br';
	}
	return in_array( $lang, noaway_i18n_langs(), true ) ? $lang : 'en';
}

/**
 * BCP 47 code for html lang and hreflang (pt-BR, not pt-br).
 *
 * @param string $lang
 * @return string
 */
function noaway_i18n_bcp47( $lang ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	return $lang === 'pt-br' ? 'pt-BR' : $lang;
}

/**
 * @param string $lang
 * @return string
 */
function noaway_i18n_og_locale( $lang ) {
	$map = array(
		'en'    => 'en_US',
		'de'    => 'de_DE',
		'es'    => 'es_ES',
		'pt-br' => 'pt_BR',
		'fr'    => 'fr_FR',
	);
	$lang = noaway_i18n_normalize_lang( $lang );
	return isset( $map[ $lang ] ) ? $map[ $lang ] : 'en_US';
}

/**
 * @param string $lang
 * @return array<int, string>
 */
function noaway_i18n_og_locale_alternates( $lang ) {
	$all     = array( 'en_US', 'de_DE', 'es_ES', 'pt_BR', 'fr_FR' );
	$current = noaway_i18n_og_locale( $lang );
	$out     = array();
	foreach ( $all as $locale ) {
		if ( $locale !== $current ) {
			$out[] = $locale;
		}
	}
	return $out;
}

/**
 * @param string $family slack|teams
 * @param string $lang
 * @return bool
 */
function noaway_i18n_valid( $family, $lang ) {
	return ( $family === 'slack' || $family === 'teams' ) && in_array( noaway_i18n_normalize_lang( $lang ), noaway_i18n_langs(), true );
}

/**
 * @return array{family:string,lang:string}|null
 */
function noaway_i18n_current_landing() {
	if ( isset( $GLOBALS['noaway_landing_family'], $GLOBALS['noaway_landing_lang'] ) ) {
		$family = is_string( $GLOBALS['noaway_landing_family'] ) ? $GLOBALS['noaway_landing_family'] : '';
		$lang   = noaway_i18n_normalize_lang( $GLOBALS['noaway_landing_lang'] );
		if ( noaway_i18n_valid( $family, $lang ) ) {
			return array(
				'family' => $family,
				'lang'   => $lang,
			);
		}
	}
	$template = function_exists( 'get_page_template_slug' ) ? get_page_template_slug() : '';
	$from_tpl = noaway_i18n_landing_from_template( is_string( $template ) ? $template : '' );
	if ( $from_tpl ) {
		return $from_tpl;
	}
	return noaway_i18n_landing_from_request();
}

/**
 * @param string $template
 * @return array{family:string,lang:string}|null
 */
function noaway_i18n_landing_from_template( $template ) {
	$map = array(
		'page-keep-slack-active.php'        => array( 'slack', 'en' ),
		'page-keep-slack-active-de.php'     => array( 'slack', 'de' ),
		'page-keep-slack-active-es.php'     => array( 'slack', 'es' ),
		'page-keep-slack-active-pt-br.php'  => array( 'slack', 'pt-br' ),
		'page-keep-slack-active-fr.php'     => array( 'slack', 'fr' ),
		'page-keep-teams-active.php'        => array( 'teams', 'en' ),
		'page-keep-teams-active-de.php'     => array( 'teams', 'de' ),
		'page-keep-teams-active-es.php'     => array( 'teams', 'es' ),
		'page-keep-teams-active-pt-br.php'  => array( 'teams', 'pt-br' ),
		'page-keep-teams-active-fr.php'     => array( 'teams', 'fr' ),
	);
	if ( ! isset( $map[ $template ] ) ) {
		return null;
	}
	return array(
		'family' => $map[ $template ][0],
		'lang'   => $map[ $template ][1],
	);
}

/**
 * @return string
 */
function noaway_i18n_request_path() {
	$path = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
		$parsed = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		$path   = is_string( $parsed ) ? $parsed : '';
	}
	$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$home_path = untrailingslashit( $home_path );
	if ( $home_path !== '' && strpos( $path, $home_path ) === 0 ) {
		$path = substr( $path, strlen( $home_path ) );
	}
	if ( $path === '' || $path[0] !== '/' ) {
		$path = '/' . ltrim( $path, '/' );
	}
	return $path;
}

/**
 * @return array{family:string,lang:string}|null
 */
function noaway_i18n_landing_from_request() {
	$path = noaway_i18n_request_path();
	if ( ! preg_match( '#^/(de|es|pt-br|fr)/(keep-slack-active|keep-teams-active)/?$#', $path, $m ) ) {
		return null;
	}
	$family = $m[2] === 'keep-teams-active' ? 'teams' : 'slack';
	return array(
		'family' => $family,
		'lang'   => noaway_i18n_normalize_lang( $m[1] ),
	);
}

/**
 * Public URL for one landing in one language.
 *
 * @param string $family slack|teams
 * @param string $lang
 * @return string
 */
function noaway_i18n_landing_url( $family, $lang ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	$slug = $family === 'teams' ? 'keep-teams-active' : 'keep-slack-active';
	if ( $lang === 'en' ) {
		if ( $family === 'teams' && function_exists( 'noaway_keep_teams_active_page_url' ) ) {
			return noaway_keep_teams_active_page_url();
		}
		if ( $family === 'slack' && function_exists( 'noaway_keep_slack_active_page_url' ) ) {
			return noaway_keep_slack_active_page_url();
		}
	}
	$path = '/' . $lang . '/' . $slug . '/';
	$url  = home_url( $path );
	if ( function_exists( 'noaway_seo_canonical_url' ) ) {
		$url = noaway_seo_canonical_url( $url );
	}
	return $url;
}

/**
 * hreflang alternates for one cluster, including x-default.
 *
 * @param string $family slack|teams
 * @return array<int, array{hreflang:string,href:string}>
 */
function noaway_i18n_hreflang_pairs( $family ) {
	$pairs = array();
	foreach ( noaway_i18n_langs() as $lang ) {
		$pairs[] = array(
			'hreflang' => noaway_i18n_bcp47( $lang ),
			'href'     => noaway_i18n_landing_url( $family, $lang ),
		);
	}
	$pairs[] = array(
		'hreflang' => 'x-default',
		'href'     => noaway_i18n_landing_url( $family, 'en' ),
	);
	return $pairs;
}

/**
 * @param string $family slack|teams
 * @param string $lang
 * @return array<string, mixed>
 */
function noaway_i18n_landing_copy( $family, $lang ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	$all  = $family === 'teams' ? noaway_i18n_teams_copies() : noaway_i18n_slack_copies();
	$copy = isset( $all[ $lang ] ) ? $all[ $lang ] : $all['en'];
	return noaway_i18n_replace_price( $copy );
}

/**
 * @param mixed $value
 * @return mixed
 */
function noaway_i18n_replace_price( $value ) {
	$price = function_exists( 'noaway_price_label' ) ? noaway_price_label() : '€4.99';
	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			$value[ $key ] = noaway_i18n_replace_price( $item );
		}
		return $value;
	}
	if ( is_string( $value ) ) {
		return str_replace( '{price}', $price, $value );
	}
	return $value;
}

/**
 * @return array<string, string>
 */
function noaway_i18n_tokens() {
	$lang       = isset( $GLOBALS['noaway_landing_lang'] ) ? noaway_i18n_normalize_lang( $GLOBALS['noaway_landing_lang'] ) : 'en';
	$download   = function_exists( 'noaway_downloads_page_url' ) ? noaway_downloads_page_url() : home_url( '/download/' );
	$teams_away = function_exists( 'noaway_teams_away_status_page_url' ) ? noaway_teams_away_status_page_url() : home_url( '/teams-away-status/' );
	$faq        = function_exists( 'noaway_faq_page_url' ) ? noaway_faq_page_url() : home_url( '/faq/' );
	$help       = function_exists( 'noaway_help_page_url' ) ? noaway_help_page_url() : home_url( '/help/' );
	$price      = function_exists( 'noaway_price_label' ) ? noaway_price_label() : '€4.99';
	return array(
		'{download_url}'     => esc_url( $download ),
		'{teams_away_url}'   => esc_url( $teams_away ),
		'{teams_active_url}' => esc_url( noaway_i18n_landing_url( 'teams', $lang ) ),
		'{slack_active_url}' => esc_url( noaway_i18n_landing_url( 'slack', $lang ) ),
		'{faq_url}'          => esc_url( $faq ),
		'{help_url}'         => esc_url( $help ),
		'{ms_presence_url}'  => 'https://support.microsoft.com/en-us/office/user-presence-in-teams-33a1a9c0-f1c2-4f1b-9a3c-3d6fbe6d4f67',
		'{ms_status_url}'    => 'https://support.microsoft.com/en-us/office/change-your-status-in-microsoft-teams-58d8f0f1-9e6c-4f5c-93f1-6e4f0e2a1f04',
		'{price}'            => esc_html( $price ),
	);
}

/**
 * @param string $text
 * @return string
 */
function noaway_i18n_plain( $text ) {
	$text = strtr( (string) $text, noaway_i18n_tokens() );
	return esc_html( $text );
}

/**
 * @param string $text
 * @return string
 */
function noaway_i18n_html( $text ) {
	$text = strtr( (string) $text, noaway_i18n_tokens() );
	return wp_kses(
		$text,
		array(
			'a'      => array(
				'href'   => array(),
				'class'  => array(),
				'rel'    => array(),
				'target' => array(),
			),
			'strong' => array(),
		)
	);
}

/**
 * Shared HowTo step labels for localized JSON-LD.
 *
 * @param string $lang
 * @return array{s1_name:string,s1_text:string,s2_name:string,s2_text:string,s3_name:string}
 */
function noaway_i18n_howto_common( $lang ) {
	$all = array(
		'de'    => array(
			's1_name' => 'NoAway herunterladen',
			's1_text' => 'NoAway für macOS oder Windows herunterladen: ',
			's2_name' => 'Installieren und starten',
			's2_text' => 'Installiere NoAway und öffne die App. Sie erscheint in der Menüleiste oder im Infobereich.',
			's3_name' => 'NoAway aktivieren',
		),
		'es'    => array(
			's1_name' => 'Descargar NoAway',
			's1_text' => 'Descarga NoAway para macOS o Windows desde ',
			's2_name' => 'Instalar y abrir',
			's2_text' => 'Instala NoAway y ábrelo. La app aparece en la barra de menús o en la bandeja del sistema.',
			's3_name' => 'Activar NoAway',
		),
		'pt-br' => array(
			's1_name' => 'Baixar o NoAway',
			's1_text' => 'Baixe o NoAway para macOS ou Windows em ',
			's2_name' => 'Instalar e abrir',
			's2_text' => 'Instale o NoAway e abra o app. Ele aparece na barra de menus ou na bandeja do sistema.',
			's3_name' => 'Ativar o NoAway',
		),
		'fr'    => array(
			's1_name' => 'Télécharger NoAway',
			's1_text' => 'Téléchargez NoAway pour macOS ou Windows depuis ',
			's2_name' => 'Installer et lancer',
			's2_text' => 'Installez NoAway et ouvrez l’app. Elle apparaît dans la barre des menus ou dans la zone de notification.',
			's3_name' => 'Activer NoAway',
		),
	);
	$lang = noaway_i18n_normalize_lang( $lang );
	return isset( $all[ $lang ] ) ? $all[ $lang ] : $all['de'];
}

/**
 * Product JSON-LD strings for a localized landing graph. Prices stay in EUR.
 *
 * @param string $lang
 * @return array{app_description:string,features:array<int,string>,offer:string,website:string,home:string}
 */
function noaway_i18n_schema_shared( $lang ) {
	$all = array(
		'de'    => array(
			'app_description' => 'NoAway hält den Computer aktiv, damit Microsoft Teams, Slack und Zoom dich nicht als abwesend anzeigen. Einmaliger Kauf (EUR) für Mac und Windows.',
			'features'        => array(
				'Verhindert den Teams-Status Abwesend',
				'Hält den Slack-Status aktiv',
				'Verhindert den Ruhezustand des Computers',
				'Tray-App für Mac und Windows',
				'Keine Administratorrechte nötig',
				'Kein Abo',
			),
			'offer'           => 'Einmaliger Kauf (EUR), Updates auf Lebenszeit. Einführungspreis.',
			'website'         => 'NoAway hält den Computer aktiv, damit Teams und Slack erreichbar bleiben. Download für Mac und Windows, einmaliger Kauf ({price}).',
			'home'            => 'Startseite',
		),
		'es'    => array(
			'app_description' => 'NoAway mantiene el equipo activo para que Microsoft Teams, Slack y Zoom no te muestren como Ausente. Compra única (EUR) para Mac y Windows.',
			'features'        => array(
				'Evita el estado Ausente en Teams',
				'Mantiene el estado de Slack activo',
				'Evita que el equipo entre en suspensión',
				'App de bandeja para Mac y Windows',
				'Sin permisos de administrador',
				'Sin suscripción',
			),
			'offer'           => 'Compra única (EUR), actualizaciones de por vida. Precio de lanzamiento.',
			'website'         => 'NoAway mantiene el equipo activo para que Teams y Slack sigan Disponibles. Descarga para Mac y Windows; compra única ({price}).',
			'home'            => 'Inicio',
		),
		'pt-br' => array(
			'app_description' => 'O NoAway mantém o computador ativo para o Microsoft Teams, o Slack e o Zoom não mostrarem você como Ausente. Compra única (EUR) para Mac e Windows.',
			'features'        => array(
				'Evita o status Ausente no Teams',
				'Mantém o status do Slack ativo',
				'Evita a suspensão do computador',
				'App de bandeja para Mac e Windows',
				'Sem direitos de administrador',
				'Sem assinatura',
			),
			'offer'           => 'Compra única (EUR), atualizações vitalícias. Preço de lançamento.',
			'website'         => 'O NoAway mantém o computador ativo para o Teams e o Slack continuarem disponíveis. Download para Mac e Windows; compra única ({price}).',
			'home'            => 'Início',
		),
		'fr'    => array(
			'app_description' => 'NoAway garde l’ordinateur actif pour que Microsoft Teams, Slack et Zoom ne vous affichent pas Absent. Achat unique (EUR) pour Mac et Windows.',
			'features'        => array(
				'Empêche le statut Absent dans Teams',
				'Garde le statut Slack actif',
				'Empêche la mise en veille de l’ordinateur',
				'App de barre des menus pour Mac et Windows',
				'Aucun droit administrateur',
				'Sans abonnement',
			),
			'offer'           => 'Achat unique (EUR), mises à jour à vie. Prix de lancement.',
			'website'         => 'NoAway garde l’ordinateur actif pour que Teams et Slack restent disponibles. Téléchargement pour Mac et Windows, achat unique ({price}).',
			'home'            => 'Accueil',
		),
	);
	$lang = noaway_i18n_normalize_lang( $lang );
	$row  = isset( $all[ $lang ] ) ? $all[ $lang ] : $all['de'];
	return noaway_i18n_replace_price( $row );
}

/**
 * Native language names for the switcher.
 *
 * @return array<string, string>
 */
function noaway_i18n_language_labels() {
	return array(
		'en'    => 'English',
		'de'    => 'Deutsch',
		'es'    => 'Español',
		'pt-br' => 'Português',
		'fr'    => 'Français',
	);
}

/**
 * @param string $family slack|teams
 */
function noaway_i18n_language_switcher( $family ) {
	$landing = noaway_i18n_current_landing();
	$current = is_array( $landing ) ? $landing['lang'] : 'en';
	$aria    = array(
		'en'    => 'Languages',
		'de'    => 'Sprachen',
		'es'    => 'Idiomas',
		'pt-br' => 'Idiomas',
		'fr'    => 'Langues',
	);
	$label   = isset( $aria[ $current ] ) ? $aria[ $current ] : 'Languages';
	echo '<nav class="mb-6 flex flex-wrap gap-x-3 gap-y-1 text-sm font-semibold text-slate-500 dark:text-slate-400" aria-label="' . esc_attr( $label ) . '">';
	foreach ( noaway_i18n_language_labels() as $code => $name ) {
		$url = noaway_i18n_landing_url( $family, $code );
		if ( $code === $current ) {
			echo '<span class="text-primary" aria-current="page">' . esc_html( $name ) . '</span>';
			continue;
		}
		echo '<a class="hover:text-primary transition-colors" href="' . esc_url( $url ) . '" hreflang="' . esc_attr( noaway_i18n_bcp47( $code ) ) . '">' . esc_html( $name ) . '</a>';
	}
	echo '</nav>';
}

/**
 * @param string $output
 * @return string
 */
function noaway_i18n_language_attributes( $output ) {
	$landing = noaway_i18n_current_landing();
	if ( ! is_array( $landing ) || $landing['lang'] === 'en' ) {
		return $output;
	}
	$lang = noaway_i18n_bcp47( $landing['lang'] );
	if ( preg_match( '/\blang="[^"]*"/', $output ) ) {
		return preg_replace( '/\blang="[^"]*"/', 'lang="' . esc_attr( $lang ) . '"', $output, 1 );
	}
	return 'lang="' . esc_attr( $lang ) . '" ' . $output;
}
add_filter( 'language_attributes', 'noaway_i18n_language_attributes' );

/**
 * Serve /{lang}/keep-slack-active/ and /{lang}/keep-teams-active/ from the page templates.
 */
function noaway_i18n_template_redirect() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	if ( ! is_404() ) {
		return;
	}
	$landing = noaway_i18n_landing_from_request();
	if ( ! $landing ) {
		return;
	}
	$path = noaway_i18n_request_path();
	if ( substr( $path, -1 ) !== '/' ) {
		$target = home_url( trailingslashit( $path ) );
		if ( function_exists( 'noaway_seo_canonical_url' ) ) {
			$target = noaway_seo_canonical_url( $target );
		}
		wp_safe_redirect( $target, 301 );
		exit;
	}

	$suffix = $landing['lang'] === 'pt-br' ? 'pt-br' : $landing['lang'];
	$base   = $landing['family'] === 'teams' ? 'page-keep-teams-active-' : 'page-keep-slack-active-';
	$file   = get_template_directory() . '/' . $base . $suffix . '.php';
	if ( ! is_readable( $file ) ) {
		return;
	}

	global $wp_query;
	if ( $wp_query instanceof WP_Query ) {
		$wp_query->is_404 = false;
	}
	status_header( 200 );
	header_remove( 'Expires' );
	header_remove( 'Pragma' );
	header_remove( 'Cache-Control' );

	$GLOBALS['noaway_landing_family'] = $landing['family'];
	$GLOBALS['noaway_landing_lang']   = $landing['lang'];
	include $file;
	exit;
}
add_action( 'template_redirect', 'noaway_i18n_template_redirect', 1 );
