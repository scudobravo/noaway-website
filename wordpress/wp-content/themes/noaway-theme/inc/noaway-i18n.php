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
 * Template file for a localized guide (non-English).
 *
 * @param string $family slack|teams
 * @param string $lang
 * @return string
 */
function noaway_i18n_guide_template( $family, $lang ) {
	$lang   = noaway_i18n_normalize_lang( $lang );
	$suffix = $lang === 'pt-br' ? 'pt-br' : $lang;
	$base   = $family === 'teams' ? 'page-keep-teams-active-' : 'page-keep-slack-active-';
	return $base . $suffix . '.php';
}

/**
 * Guide slug under the language parent (keep-slack-active / keep-teams-active).
 *
 * @param string $family slack|teams
 * @return string
 */
function noaway_i18n_guide_slug( $family ) {
	return $family === 'teams' ? 'keep-teams-active' : 'keep-slack-active';
}

/**
 * Find a published page that uses a given page template.
 *
 * @param string $template_file
 * @return WP_Post|null
 */
function noaway_i18n_find_page_by_template( $template_file ) {
	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template_file,
			'number'      => 1,
			'post_status' => 'publish',
			'sort_column' => 'ID',
			'sort_order'  => 'ASC',
		)
	);
	return ! empty( $pages[0] ) ? $pages[0] : null;
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
	$slug = noaway_i18n_guide_slug( $family );
	if ( $lang === 'en' ) {
		if ( $family === 'teams' && function_exists( 'noaway_keep_teams_active_page_url' ) ) {
			return noaway_keep_teams_active_page_url();
		}
		if ( $family === 'slack' && function_exists( 'noaway_keep_slack_active_page_url' ) ) {
			return noaway_keep_slack_active_page_url();
		}
	} else {
		$page = noaway_i18n_find_page_by_template( noaway_i18n_guide_template( $family, $lang ) );
		if ( $page ) {
			$url = get_permalink( $page->ID );
			if ( is_string( $url ) && $url !== '' ) {
				return function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( $url ) : $url;
			}
		}
	}
	$path = $lang === 'en' ? '/' . $slug . '/' : '/' . $lang . '/' . $slug . '/';
	$url  = home_url( $path );
	if ( function_exists( 'noaway_seo_canonical_url' ) ) {
		$url = noaway_seo_canonical_url( $url );
	}
	return $url;
}

/**
 * Language parent page titles (URL slug = language code).
 *
 * @return array<string, string>
 */
function noaway_i18n_parent_titles() {
	return array(
		'de'    => 'Deutsch',
		'es'    => 'Español',
		'fr'    => 'Français',
		'pt-br' => 'Português (Brasil)',
	);
}

/**
 * Ensure a published parent page exists for /{lang}/.
 *
 * @param string $lang
 * @return int Parent page ID, or 0 on failure.
 */
function noaway_i18n_ensure_lang_parent( $lang ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	if ( $lang === 'en' ) {
		return 0;
	}
	$titles = noaway_i18n_parent_titles();
	if ( ! isset( $titles[ $lang ] ) ) {
		return 0;
	}
	$existing = get_page_by_path( $lang, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		if ( $existing->post_status !== 'publish' ) {
			wp_update_post(
				array(
					'ID'          => (int) $existing->ID,
					'post_status' => 'publish',
				)
			);
		}
		return (int) $existing->ID;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $titles[ $lang ],
			'post_name'    => $lang,
			'post_content' => '',
			'post_parent'  => 0,
		),
		true
	);
	return ( ! is_wp_error( $id ) && $id ) ? (int) $id : 0;
}

/**
 * Ensure a localized guide page exists under its language parent.
 *
 * @param string $family slack|teams
 * @param string $lang
 * @param int    $parent_id
 * @return bool True when a page was created or updated.
 */
function noaway_i18n_ensure_guide_page( $family, $lang, $parent_id ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	if ( $lang === 'en' || $parent_id <= 0 || ! noaway_i18n_valid( $family, $lang ) ) {
		return false;
	}
	$template = noaway_i18n_guide_template( $family, $lang );
	$slug     = noaway_i18n_guide_slug( $family );
	$copy     = noaway_i18n_landing_copy( $family, $lang );
	$title    = ! empty( $copy['h1'] ) ? $copy['h1'] : $slug;
	$changed  = false;

	$page = noaway_i18n_find_page_by_template( $template );
	if ( $page ) {
		$update = array( 'ID' => (int) $page->ID );
		if ( (int) $page->post_parent !== (int) $parent_id ) {
			$update['post_parent'] = (int) $parent_id;
			$changed               = true;
		}
		if ( $page->post_name !== $slug ) {
			$update['post_name'] = $slug;
			$changed             = true;
		}
		if ( $page->post_status !== 'publish' ) {
			$update['post_status'] = 'publish';
			$changed               = true;
		}
		if ( $changed ) {
			wp_update_post( $update );
		}
		return $changed;
	}

	$path = $lang . '/' . $slug;
	$by_path = get_page_by_path( $path, OBJECT, 'page' );
	if ( $by_path instanceof WP_Post ) {
		wp_update_post(
			array(
				'ID'          => (int) $by_path->ID,
				'post_parent' => (int) $parent_id,
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_title'  => $title,
			)
		);
		update_post_meta( (int) $by_path->ID, '_wp_page_template', $template );
		return true;
	}

	$id = wp_insert_post(
		array(
			'post_type'     => 'page',
			'post_status'   => 'publish',
			'post_title'    => $title,
			'post_name'     => $slug,
			'post_content'  => '',
			'post_parent'   => (int) $parent_id,
			'page_template' => $template,
		),
		true
	);
	if ( is_wp_error( $id ) || ! $id ) {
		return false;
	}
	update_post_meta( (int) $id, '_wp_page_template', $template );
	return true;
}

/**
 * Create missing /{lang}/ parents and guide pages (idempotent).
 */
function noaway_i18n_ensure_localized_pages() {
	if ( ! function_exists( 'wp_insert_post' ) ) {
		return;
	}
	$created_or_fixed = false;
	foreach ( array( 'de', 'es', 'fr', 'pt-br' ) as $lang ) {
		$parent_id = noaway_i18n_ensure_lang_parent( $lang );
		if ( $parent_id <= 0 ) {
			continue;
		}
		foreach ( array( 'slack', 'teams' ) as $family ) {
			if ( noaway_i18n_ensure_guide_page( $family, $lang, $parent_id ) ) {
				$created_or_fixed = true;
			}
		}
	}
	$version = '1';
	if ( get_option( 'noaway_i18n_pages_version' ) !== $version ) {
		update_option( 'noaway_i18n_pages_version', $version, false );
		$created_or_fixed = true;
	}
	if ( $created_or_fixed ) {
		flush_rewrite_rules( false );
	}
}
add_action( 'after_switch_theme', 'noaway_i18n_ensure_localized_pages' );
add_action( 'admin_init', 'noaway_i18n_ensure_localized_pages', 30 );

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
 * Short labels for the switcher chrome (Language / Sprache / …).
 *
 * @return array<string, string>
 */
function noaway_i18n_switcher_chrome() {
	return array(
		'en'    => 'Language',
		'de'    => 'Sprache',
		'es'    => 'Idioma',
		'pt-br' => 'Idioma',
		'fr'    => 'Langue',
	);
}

/**
 * Visible language switcher for Slack/Teams guides.
 *
 * @param string $family  slack|teams
 * @param string $context header|under-title
 */
function noaway_i18n_language_switcher( $family, $context = 'header' ) {
	$landing = noaway_i18n_current_landing();
	$current = is_array( $landing ) ? $landing['lang'] : 'en';
	$labels  = noaway_i18n_language_labels();
	$chrome  = noaway_i18n_switcher_chrome();
	$aria    = isset( $chrome[ $current ] ) ? $chrome[ $current ] : 'Language';
	$current_name = isset( $labels[ $current ] ) ? $labels[ $current ] : $current;
	$extra   = $context === 'under-title' ? ' noaway-lang-switcher--under-title mt-5 mb-2' : ' noaway-lang-switcher--header mb-6';

	echo '<nav class="noaway-lang-switcher' . esc_attr( $extra ) . '" aria-label="' . esc_attr( $aria ) . '">';
	echo '<span class="noaway-lang-switcher__chrome">' . esc_html( $aria ) . ': <strong class="noaway-lang-switcher__current">' . esc_html( $current_name ) . '</strong></span>';
	echo '<ul class="noaway-lang-switcher__list">';
	foreach ( $labels as $code => $name ) {
		$url = noaway_i18n_landing_url( $family, $code );
		echo '<li>';
		if ( $code === $current ) {
			echo '<span class="noaway-lang-switcher__item noaway-lang-switcher__item--active" aria-current="page">' . esc_html( $name ) . '</span>';
		} else {
			echo '<a class="noaway-lang-switcher__item" href="' . esc_url( $url ) . '" hreflang="' . esc_attr( noaway_i18n_bcp47( $code ) ) . '">' . esc_html( $name ) . '</a>';
		}
		echo '</li>';
	}
	echo '</ul></nav>';
}

/**
 * Locale suggestion messages (browser language → localized guide).
 *
 * @return array<string, string>
 */
function noaway_i18n_locale_banner_messages() {
	return array(
		'de'    => 'Diese Anleitung auf Deutsch lesen?',
		'es'    => '¿Leer esta guía en español?',
		'fr'    => 'Lire ce guide en français ?',
		'pt-br' => 'Ler este guia em português?',
	);
}

/**
 * Whether assets for guide i18n UI should load.
 *
 * @return bool
 */
function noaway_i18n_should_load_guide_assets() {
	$landing = noaway_i18n_current_landing();
	return is_array( $landing ) && ( $landing['family'] === 'slack' || $landing['family'] === 'teams' );
}

/**
 * Enqueue language-switcher CSS + optional locale banner JS on guide pages only.
 */
function noaway_i18n_enqueue_guide_assets() {
	if ( ! noaway_i18n_should_load_guide_assets() ) {
		return;
	}
	$landing = noaway_i18n_current_landing();
	$css_rel = '/assets/css/noaway-i18n.css';
	$js_rel  = '/assets/js/noaway-i18n-locale-banner.js';
	$css_abs = get_template_directory() . $css_rel;
	$js_abs  = get_template_directory() . $js_rel;
	$css_ver = file_exists( $css_abs ) ? (string) filemtime( $css_abs ) : '1.0.0';
	$js_ver  = file_exists( $js_abs ) ? (string) filemtime( $js_abs ) : '1.0.0';

	wp_enqueue_style(
		'noaway-i18n',
		get_template_directory_uri() . $css_rel,
		array(),
		$css_ver
	);
	wp_enqueue_script(
		'noaway-i18n-locale-banner',
		get_template_directory_uri() . $js_rel,
		array(),
		$js_ver,
		true
	);

	$urls = array();
	foreach ( array( 'de', 'es', 'fr', 'pt-br' ) as $code ) {
		$urls[ $code ] = noaway_i18n_landing_url( $landing['family'], $code );
	}
	wp_localize_script(
		'noaway-i18n-locale-banner',
		'NoAwayI18nBanner',
		array(
			'currentLang' => $landing['lang'],
			'family'      => $landing['family'],
			'urls'        => $urls,
			'messages'    => noaway_i18n_locale_banner_messages(),
			'dismissAria' => array(
				'en'    => 'Dismiss',
				'de'    => 'Schließen',
				'es'    => 'Cerrar',
				'fr'    => 'Fermer',
				'pt-br' => 'Fechar',
			),
			'storageKey'  => 'noaway.i18nBanner.dismissed.v1',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'noaway_i18n_enqueue_guide_assets', 36 );

/**
 * Markup host for the non-redirecting locale suggestion banner (filled by JS).
 *
 * @param string $family slack|teams
 * @param string $lang
 */
function noaway_i18n_render_locale_banner( $family, $lang ) {
	$lang = noaway_i18n_normalize_lang( $lang );
	if ( ! noaway_i18n_valid( $family, $lang ) ) {
		return;
	}
	echo '<div class="noaway-locale-banner" data-noaway-locale-banner hidden role="region" aria-live="polite"></div>';
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
