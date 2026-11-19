<?php
/**
 * NoAway Theme - Sitemap page URL e sitemap.xml per Google Search Console e robots
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * URL della pagina Sitemap (template Sitemap NoAway). Fallback a /sitemap/.
 */
function noaway_sitemap_page_url() {
  $pages = get_pages( array(
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'page-sitemap.php',
    'number'     => 1,
  ) );
  if ( ! empty( $pages ) ) {
    $url = get_permalink( $pages[0] );
  } else {
    $url = home_url( '/sitemap/' );
  }
  return function_exists( 'noaway_seo_canonical_url' ) ? noaway_seo_canonical_url( $url ) : $url;
}

/**
 * Restituisce l'elenco degli URL da includere in sitemap.xml (loc, lastmod opzionale).
 */
function noaway_sitemap_normalize_absolute_url( $url ) {
  $url = is_string( $url ) ? trim( $url ) : '';
  if ( $url === '' ) {
    return '';
  }

  $base = '';
  if ( defined( 'WP_HOME' ) && WP_HOME ) {
    $base = WP_HOME;
  } else {
    $base = home_url( '/' );
  }
  $base = is_string( $base ) ? trim( $base ) : '';
  if ( $base === '' || ! preg_match( '#^https?://#i', $base ) ) {
    return '';
  }

  $base = untrailingslashit( $base );
  $base_parts = wp_parse_url( $base );
  $base_scheme = isset( $base_parts['scheme'] ) ? $base_parts['scheme'] : 'https';
  $base_host = isset( $base_parts['host'] ) ? $base_parts['host'] : '';
  if ( $base_host === '' ) {
    return '';
  }

  if ( preg_match( '#^https?://#i', $url ) ) {
    $url_parts = wp_parse_url( $url );
    $path = isset( $url_parts['path'] ) ? $url_parts['path'] : '/';
    $query = isset( $url_parts['query'] ) ? '?' . $url_parts['query'] : '';
    $fragment = isset( $url_parts['fragment'] ) ? '#' . $url_parts['fragment'] : '';
    if ( $path === '' ) {
      $path = '/';
    }
    return $base_scheme . '://' . $base_host . $path . $query . $fragment;
  }

  if ( $url[0] !== '/' ) {
    $url = '/' . $url;
  }
  return $base . $url;
}

function noaway_get_sitemap_urls() {
  $base = '';
  if ( defined( 'WP_HOME' ) && WP_HOME ) {
    $base = trailingslashit( rtrim( WP_HOME, '/' ) );
  } else {
    $base = trailingslashit( home_url() );
  }
  $urls = array(
    array( 'loc' => $base, 'priority' => '1.0', 'changefreq' => 'weekly' ),
    array( 'loc' => $base . 'features/', 'priority' => '0.9', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'how-it-works/', 'priority' => '0.9', 'changefreq' => 'monthly' ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'teams', 'en' ) : $base . 'keep-teams-active/', 'priority' => '0.8', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'teams' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'teams', 'de' ) : $base . 'de/keep-teams-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'teams' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'teams', 'es' ) : $base . 'es/keep-teams-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'teams' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'teams', 'pt-br' ) : $base . 'pt-br/keep-teams-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'teams' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'teams', 'fr' ) : $base . 'fr/keep-teams-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'teams' ) : array() ),
    array( 'loc' => $base . 'teams-away-status/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'slack', 'en' ) : $base . 'keep-slack-active/', 'priority' => '0.8', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'slack' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'slack', 'de' ) : $base . 'de/keep-slack-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'slack' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'slack', 'es' ) : $base . 'es/keep-slack-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'slack' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'slack', 'pt-br' ) : $base . 'pt-br/keep-slack-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'slack' ) : array() ),
    array( 'loc' => function_exists( 'noaway_i18n_landing_url' ) ? noaway_i18n_landing_url( 'slack', 'fr' ) : $base . 'fr/keep-slack-active/', 'priority' => '0.7', 'changefreq' => 'monthly', 'alternates' => function_exists( 'noaway_i18n_hreflang_pairs' ) ? noaway_i18n_hreflang_pairs( 'slack' ) : array() ),
    array( 'loc' => $base . 'prevent-computer-sleep/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'is-noaway-safe/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'compare/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    // One-to-one comparison landings (noaway-vs-*) intentionally omitted until competitor facts are verified.
    array( 'loc' => $base . 'help/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'releases/', 'priority' => '0.6', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'downloads/', 'priority' => '0.9', 'changefreq' => 'weekly' ),
    array( 'loc' => $base . 'faq/', 'priority' => '0.8', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'contacts/', 'priority' => '0.7', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'sitemap/', 'priority' => '0.5', 'changefreq' => 'monthly' ),
    array( 'loc' => $base . 'privacy-policy/', 'priority' => '0.4', 'changefreq' => 'yearly' ),
    array( 'loc' => $base . 'terms-of-service/', 'priority' => '0.4', 'changefreq' => 'yearly' ),
  );
  foreach ( $urls as $i => $entry ) {
    $urls[ $i ]['loc'] = noaway_sitemap_normalize_absolute_url( isset( $entry['loc'] ) ? $entry['loc'] : '' );
  }
  return $urls;
}

/**
 * Output sitemap XML (formato standard per Google).
 */
/**
 * Template file for a public path, when one exists in the theme.
 *
 * @param string $path Path beginning with /.
 * @return string Relative template filename or empty.
 */
function noaway_sitemap_template_for_path( $path ) {
  $path = is_string( $path ) ? untrailingslashit( $path ) : '';
  if ( $path === '' ) {
    $path = '/';
  }
  $map = array(
    '/'                         => 'front-page.php',
    '/features'                 => 'page-features.php',
    '/how-it-works'             => 'page-how-it-works.php',
    '/keep-teams-active'        => 'page-keep-teams-active.php',
    '/de/keep-teams-active'     => 'page-keep-teams-active-de.php',
    '/es/keep-teams-active'     => 'page-keep-teams-active-es.php',
    '/pt-br/keep-teams-active'  => 'page-keep-teams-active-pt-br.php',
    '/fr/keep-teams-active'     => 'page-keep-teams-active-fr.php',
    '/teams-away-status'        => 'page-teams-away-status.php',
    '/keep-slack-active'        => 'page-keep-slack-active.php',
    '/de/keep-slack-active'     => 'page-keep-slack-active-de.php',
    '/es/keep-slack-active'     => 'page-keep-slack-active-es.php',
    '/pt-br/keep-slack-active'  => 'page-keep-slack-active-pt-br.php',
    '/fr/keep-slack-active'     => 'page-keep-slack-active-fr.php',
    '/prevent-computer-sleep'   => 'page-prevent-computer-sleep.php',
    '/is-noaway-safe'           => 'page-is-noaway-safe.php',
    '/compare'                  => 'page-compare.php',
    '/help'                     => 'page-help.php',
    '/releases'                 => 'page-releases.php',
    '/downloads'                => 'page-downloads.php',
    '/faq'                      => 'page-faq.php',
    '/contacts'                 => 'page-contatti.php',
    '/sitemap'                  => 'page-sitemap.php',
    '/privacy-policy'           => 'page-privacy-policy.php',
    '/terms-of-service'         => 'page-terms-of-service.php',
  );
  return isset( $map[ $path ] ) ? $map[ $path ] : '';
}

/**
 * lastmod for localized keep-*-active guides.
 * Max of WP post_modified and filemtime of the template / translation files that render the page.
 * Never falls back to the current date.
 *
 * @param string $lang de|es|pt-br|fr
 * @param string $slug keep-teams-active|keep-slack-active
 * @return string Y-m-d or empty.
 */
function noaway_sitemap_localized_guide_lastmod( $lang, $slug ) {
  $lang = is_string( $lang ) ? $lang : '';
  $slug = is_string( $slug ) ? $slug : '';
  if ( $lang === '' || ( $slug !== 'keep-teams-active' && $slug !== 'keep-slack-active' ) ) {
    return '';
  }

  $family   = $slug === 'keep-teams-active' ? 'teams' : 'slack';
  $stamps   = array();
  $lang_tpl = function_exists( 'noaway_i18n_guide_template' )
    ? noaway_i18n_guide_template( $family, $lang )
    : ( 'page-' . $slug . '-' . $lang . '.php' );
  $base_tpl = 'page-' . $slug . '.php';
  $i18n_rel = $family === 'teams' ? 'inc/noaway-i18n-teams.php' : 'inc/noaway-i18n-slack.php';

  foreach ( array( $lang_tpl, $base_tpl, $i18n_rel ) as $rel ) {
    if ( ! is_string( $rel ) || $rel === '' ) {
      continue;
    }
    $ts = function_exists( 'noaway_content_file_timestamp' )
      ? noaway_content_file_timestamp( $rel )
      : 0;
    if ( $ts <= 0 ) {
      $file = get_stylesheet_directory() . '/' . ltrim( $rel, '/' );
      if ( file_exists( $file ) ) {
        $ts = (int) filemtime( $file );
      }
    }
    if ( $ts > 0 ) {
      $stamps[] = $ts;
    }
  }

  $post = null;
  if ( function_exists( 'noaway_i18n_find_page_by_template' ) && is_string( $lang_tpl ) && $lang_tpl !== '' ) {
    $post = noaway_i18n_find_page_by_template( $lang_tpl );
  }
  if ( ! ( $post instanceof WP_Post ) ) {
    $found = get_page_by_path( $lang . '/' . $slug, OBJECT, 'page' );
    if ( $found instanceof WP_Post ) {
      $post = $found;
    }
  }
  if ( $post instanceof WP_Post && ! empty( $post->post_modified_gmt ) && $post->post_modified_gmt !== '0000-00-00 00:00:00' ) {
    $ts = strtotime( $post->post_modified_gmt . ' UTC' );
    if ( $ts ) {
      $body = trim( wp_strip_all_tags( (string) $post->post_content ) );
      // Empty routing shells get post_modified bumped by ensure/meta fixes;
      // only trust that stamp when it is not newer than the rendering files.
      if ( $body !== '' ) {
        $stamps[] = (int) $ts;
      } else {
        $file_max = $stamps ? max( $stamps ) : 0;
        if ( $file_max > 0 && (int) $ts <= $file_max ) {
          $stamps[] = (int) $ts;
        } elseif ( $file_max === 0 ) {
          $stamps[] = (int) $ts;
        }
      }
    }
  }

  $stamps = array_filter( $stamps );
  if ( ! $stamps ) {
    return '';
  }
  return gmdate( 'Y-m-d', max( $stamps ) );
}

/**
 * lastmod — localized guides use post_modified / template / translation filemtimes;
 * everything else shares the JSON-LD dateModified source. Never emits "now".
 *
 * @param string $loc Absolute URL.
 * @return string Y-m-d or empty.
 */
function noaway_sitemap_lastmod( $loc ) {
  $path = wp_parse_url( is_string( $loc ) ? $loc : '', PHP_URL_PATH );
  $path = is_string( $path ) ? '/' . trim( $path, '/' ) : '';
  if ( $path !== '/' && $path !== '' ) {
    $path = untrailingslashit( $path );
  }
  if ( preg_match( '#^/(de|es|pt-br|fr)/(keep-teams-active|keep-slack-active)$#', $path, $m ) ) {
    return noaway_sitemap_localized_guide_lastmod( $m[1], $m[2] );
  }
  return function_exists( 'noaway_content_modified' ) ? noaway_content_modified( $loc ) : '';
}

function noaway_output_sitemap_xml() {
  $urls = noaway_get_sitemap_urls();
  header( 'Content-Type: application/xml; charset=UTF-8' );
  header( 'X-Robots-Tag: noindex', true );
  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
  foreach ( $urls as $entry ) {
    $loc = isset( $entry['loc'] ) ? esc_url_raw( $entry['loc'] ) : '';
    if ( $loc === '' ) {
      continue;
    }
    $priority = isset( $entry['priority'] ) ? $entry['priority'] : '0.5';
    $changefreq = isset( $entry['changefreq'] ) ? $entry['changefreq'] : 'monthly';
    echo "  <url>\n";
    echo "    <loc>" . esc_html( $loc ) . "</loc>\n";
    $lastmod = noaway_sitemap_lastmod( $loc );
    if ( $lastmod !== '' ) {
      echo "    <lastmod>" . esc_html( $lastmod ) . "</lastmod>\n";
    }
    echo "    <changefreq>" . esc_html( $changefreq ) . "</changefreq>\n";
    echo "    <priority>" . esc_html( $priority ) . "</priority>\n";
    if ( ! empty( $entry['alternates'] ) && is_array( $entry['alternates'] ) ) {
      foreach ( $entry['alternates'] as $alt ) {
        $href = isset( $alt['href'] ) ? esc_url( $alt['href'] ) : '';
        $hreflang = isset( $alt['hreflang'] ) ? $alt['hreflang'] : '';
        if ( $href === '' || $hreflang === '' ) {
          continue;
        }
        echo '    <xhtml:link rel="alternate" hreflang="' . esc_attr( $hreflang ) . '" href="' . $href . '"/>' . "\n";
      }
    }
    echo "  </url>\n";
  }
  echo '</urlset>';
  exit;
}

/**
 * Registra la query var e la rewrite rule per sitemap.xml
 */
function noaway_sitemap_rewrite_rules() {
  add_rewrite_rule( 'sitemap\.xml$', 'index.php?noaway_sitemap_xml=1', 'top' );
}
add_action( 'init', 'noaway_sitemap_rewrite_rules' );

function noaway_sitemap_query_vars( $vars ) {
  $vars[] = 'noaway_sitemap_xml';
  return $vars;
}
add_filter( 'query_vars', 'noaway_sitemap_query_vars' );

function noaway_sitemap_template_redirect() {
  if ( (int) get_query_var( 'noaway_sitemap_xml' ) === 1 ) {
    noaway_output_sitemap_xml();
  }
}
add_action( 'template_redirect', 'noaway_sitemap_template_redirect' );

/**
 * URL assoluto per robots.txt virtuale. Host di produzione sempre senza www,
 * come wordpress/robots.txt e noaway_seo_canonical_url().
 */
function noaway_robots_discovery_url( $path ) {
  $url = home_url( $path );
  if ( function_exists( 'noaway_seo_canonical_url' ) ) {
    return noaway_seo_canonical_url( $url );
  }
  $rewritten = preg_replace( '~^https://www\.noaway\.app(?=/|:|\?|#|$)~i', 'https://noaway.app', $url );
  return is_string( $rewritten ) ? $rewritten : $url;
}

/**
 * Aggiunge Sitemap: ... in robots.txt per Google e altri crawler.
 */
function noaway_robots_txt_sitemap( $output, $public ) {
  if ( $public ) {
    $sitemap_url = noaway_robots_discovery_url( '/sitemap.xml' );
    $llms_url = noaway_robots_discovery_url( '/llms.txt' );
    $ai_policy_url = noaway_robots_discovery_url( '/.well-known/ai.txt' );
    $output .= "User-agent: *\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Allow: /wp-admin/admin-ajax.php\n";
    $output .= "Disallow: /private/\n";
    $output .= "Disallow: /test/\n";
    $output .= "\nUser-agent: GPTBot\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /private/\n";
    $output .= "Disallow: /test/\n";
    $output .= "\nUser-agent: ClaudeBot\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /private/\n";
    $output .= "Disallow: /test/\n";
    $output .= "\nUser-agent: PerplexityBot\n";
    $output .= "Allow: /\n";
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /private/\n";
    $output .= "Disallow: /test/\n";
    $output .= "\nSitemap: " . $sitemap_url . "\n";
    $output .= "llms: " . $llms_url . "\n";
    $output .= "ai-policy: " . $ai_policy_url . "\n";
  }
  return $output;
}
add_filter( 'robots_txt', 'noaway_robots_txt_sitemap', 99, 2 );
