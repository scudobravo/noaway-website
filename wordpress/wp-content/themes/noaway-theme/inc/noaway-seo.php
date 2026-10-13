<?php
/**
 * NoAway Theme - SEO: meta tags, canonical, Open Graph, Twitter Cards, JSON-LD
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/** Prezzo pubblico (schema + copy) — valuta EUR. Lancio e prezzo pieno. */
if ( ! defined( 'NOAWAY_SEO_PRICE_AMOUNT' ) ) {
  define( 'NOAWAY_SEO_PRICE_AMOUNT', '4.99' );
}
if ( ! defined( 'NOAWAY_REGULAR_PRICE_AMOUNT' ) ) {
  define( 'NOAWAY_REGULAR_PRICE_AMOUNT', '9.99' );
}
if ( ! defined( 'NOAWAY_SEO_PRICE_CURRENCY' ) ) {
  define( 'NOAWAY_SEO_PRICE_CURRENCY', 'EUR' );
}

/**
 * WordPress core also prints rel_canonical on wp_head; we output canonical in noaway_seo_wp_head().
 */
remove_action( 'wp_head', 'rel_canonical' );

/**
 * Default OG image (absolute URL). Used when page has no specific image.
 */
function noaway_seo_og_image_default() {
  return get_stylesheet_directory_uri() . '/assets/images/landing-hero-section.png';
}

/**
 * Restituisce l'URL canonico: HTTPS e host di produzione sempre `noaway.app`
 * (allinea canonical/OG/JSON-LD a Search Console e riduce split www/non-www).
 */
function noaway_seo_canonical_url( $url ) {
  if ( ! is_string( $url ) ) {
    return '';
  }
  $url = trim( $url );
  if ( $url === '' ) {
    return '';
  }
  if ( strpos( $url, '//' ) === 0 ) {
    $url = 'https:' . $url;
  }
  if ( stripos( $url, 'http://' ) === 0 ) {
    $url = 'https://' . substr( $url, 7 );
  }
  if ( stripos( $url, 'https://' ) === 0 ) {
    $rewritten = preg_replace( '~^https://www\.noaway\.app(?=/|:|\?|#|$)~i', 'https://noaway.app', $url );
    if ( is_string( $rewritten ) ) {
      $url = $rewritten;
    }
  }
  return $url;
}

/**
 * Canonical di fallback: path della richiesta, host fisso https://noaway.app, slash finale.
 */
function noaway_seo_request_canonical_url() {
  $path = '/';
  if ( isset( $_SERVER['REQUEST_URI'] ) && is_string( $_SERVER['REQUEST_URI'] ) ) {
    $uri = wp_unslash( $_SERVER['REQUEST_URI'] );
    $parsed = wp_parse_url( $uri, PHP_URL_PATH );
    if ( is_string( $parsed ) && $parsed !== '' ) {
      $path = $parsed;
    }
  }
  if ( $path === '' || $path[0] !== '/' ) {
    $path = '/' . ltrim( $path, '/' );
  }
  $path = preg_replace( '~/{2,}~', '/', $path );
  if ( ! is_string( $path ) || $path === '' ) {
    $path = '/';
  }
  return 'https://noaway.app' . trailingslashit( $path );
}

/**
 * Get SEO data for current page: title, description, og_image (optional override).
 */
function noaway_seo_get_page_data() {
  $base_url = noaway_seo_canonical_url( home_url( '/' ) );
  $default_image = noaway_seo_og_image_default();
  $default_title = 'NoAway – Keep Teams and Slack from going Away';
  $default_desc  = noaway_fact_i18n( 'benefit.short', 'en' ) . ' One-time purchase for Mac and Windows.';

  $data = array(
    'title'            => $default_title,
    'description'      => $default_desc,
    'og_image'         => $default_image,
    'canonical'        => $base_url,
    'canonical_branch' => 'home',
  );

  if ( ! is_string( $data['canonical'] ) || $data['canonical'] === '' ) {
    $data['canonical']        = noaway_seo_request_canonical_url();
    $data['canonical_branch'] = 'request';
  }

  if ( is_front_page() ) {
    $data['title']       = 'Keep Teams and Slack from going Away | NoAway';
    $data['description'] = noaway_fact_i18n( 'benefit.short', 'en' ) . ' One-time €' . NOAWAY_SEO_PRICE_AMOUNT . ' for Mac and Windows.';
    $front = trailingslashit( is_string( $base_url ) ? $base_url : '' );
    if ( $front === '' || $front === '/' ) {
      $data['canonical']        = noaway_seo_request_canonical_url();
      $data['canonical_branch'] = 'request';
    } else {
      $data['canonical']        = $front;
      $data['canonical_branch'] = 'front_page';
    }
    return $data;
  }

  if ( is_singular() ) {
    $post_id = (int) get_queried_object_id();
    $raw = $post_id > 0 ? get_permalink( $post_id ) : '';
    $permalink = noaway_seo_canonical_url( is_string( $raw ) ? $raw : '' );
    if ( is_string( $permalink ) && $permalink !== '' ) {
      $data['canonical']        = $permalink;
      $data['canonical_branch'] = 'permalink';
    } else {
      $data['canonical']        = noaway_seo_request_canonical_url();
      $data['canonical_branch'] = 'request';
    }
  }

  $template = get_page_template_slug();
  // Fallback when get_page_template_slug() is empty (wrong Page Attributes template in wp-admin,
  // or title filter runs without a resolved template): match page slug / request path.
  // This fixes /teams-away-status/ falling through to the home default title.
  if ( ( ! is_string( $template ) || $template === '' ) && ! is_front_page() ) {
    $page_slug_map = array(
      'features'               => 'page-features.php',
      'how-it-works'           => 'page-how-it-works.php',
      'keep-teams-active'      => 'page-keep-teams-active.php',
      'teams-away-status'      => 'page-teams-away-status.php',
      'keep-slack-active'      => 'page-keep-slack-active.php',
      'prevent-computer-sleep' => 'page-prevent-computer-sleep.php',
      'is-noaway-safe'         => 'page-is-noaway-safe.php',
      'download'               => 'page-downloads.php',
      'downloads'              => 'page-downloads.php',
      'thank-you'              => 'page-thank-you.php',
      'help'                   => 'page-help.php',
      'contacts'               => 'page-contatti.php',
      'contact'                => 'page-contatti.php',
      'faq'                    => 'page-faq.php',
      'sitemap'                => 'page-sitemap.php',
      'releases'               => 'page-releases.php',
    );
    foreach ( $page_slug_map as $slug => $tpl ) {
      if ( is_page( $slug ) ) {
        $template = $tpl;
        break;
      }
    }
    if ( ! is_string( $template ) || $template === '' ) {
      $req_path = (string) wp_parse_url( noaway_seo_request_canonical_url(), PHP_URL_PATH );
      $req_path = trim( untrailingslashit( $req_path ), '/' );
      if ( isset( $page_slug_map[ $req_path ] ) ) {
        $template = $page_slug_map[ $req_path ];
      }
    }
  }
  if ( $template === 'page-features.php' ) {
    $data['title']       = 'Features | NoAway – Lightweight App to Keep Teams & Slack Active';
    $data['description'] = 'NoAway features: lightweight tray app, Mac & Windows, minimal resources, simple setup, automatic startup, scheduled wake. Built to stay out of your way.';
  } elseif ( $template === 'page-how-it-works.php' ) {
    $data['title']       = 'How NoAway Works | Install, Enable, Stay Available';
    $data['description'] = 'Install NoAway once, enable Keep Active from the tray, and your computer stays active automatically. No complicated setup. Works with Teams, Slack, Zoom.';
  } elseif ( $template === 'page-keep-teams-active.php' ) {
    $data['title']       = 'Stop Teams Showing Away After 5 Minutes – Keep Status Green | NoAway';
    $data['description'] = 'Teams can show Away after about 5 minutes without keyboard or mouse input. ' . noaway_fact_i18n( 'benefit.short', 'en' ) . ' One-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac and Windows.';
  } elseif ( $template === 'page-teams-away-status.php' ) {
    $data['title']       = 'Why Does Teams Show Away? Idle, Lock Screen & Status | NoAway';
    $data['description'] = 'Diagnose why Microsoft Teams shows Away: idle, lock screen, sleep, calendar, calls, other devices, and company policy. Desktop, browser, and mobile differ. Link to Microsoft presence docs.';
  } elseif ( $template === 'page-keep-slack-active.php' ) {
    $data['title']       = 'How to Keep Slack Active (Away After 10 Min) – Mac & Windows | NoAway';
    $data['description'] = 'Slack’s desktop app sets you to away after ten minutes of inactivity. Mobile apps do it when you leave or close the app. NoAway keeps this computer from going idle.';
  } elseif ( $template === 'page-prevent-computer-sleep.php' ) {
    $data['title']       = 'Prevent Computer Sleep on Mac & Windows (Without Admin Rights) | NoAway';
    $data['description'] = 'OS sleep settings keep the machine on but do not stop idle status. Prevent sleep without admin rights with NoAway—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
  } elseif ( $template === 'page-is-noaway-safe.php' ) {
    $data['title']       = 'Is NoAway Safe? Legit, Privacy & Company PCs | NoAway';
    $data['description'] = 'Keep Active runs on your computer; the only network request is the license check. See admin rights, IT policy, and support—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
  } elseif ( $template === 'page-compare.php' && function_exists( 'noaway_get_comparison_for_current_page' ) ) {
    $cmp = noaway_get_comparison_for_current_page();
    if ( is_array( $cmp ) ) {
      if ( ! empty( $cmp['seo_title'] ) ) {
        $data['title'] = $cmp['seo_title'];
      }
      if ( ! empty( $cmp['seo_description'] ) ) {
        $data['description'] = $cmp['seo_description'];
      }
    }
  } elseif ( $template === 'page-downloads.php' || $template === 'page-download.php' ) {
    $data['title']       = 'Download NoAway – Keep Teams & Slack Active | Mac & Windows';
    $data['description'] = 'Download NoAway for macOS or Windows. One-time €' . NOAWAY_SEO_PRICE_AMOUNT . '. ' . noaway_fact_i18n( 'benefit.short', 'en' );
  } elseif ( $template === 'page-thank-you.php' ) {
    $data['title']       = 'Thank You – Your NoAway Download | Purchase Confirmed';
    $data['description'] = 'Your NoAway purchase is confirmed. Download NoAway for macOS or Windows. One-time €' . NOAWAY_SEO_PRICE_AMOUNT . '. ' . noaway_fact( 'license.lifetime_updates_short' ) . ' Need help? Visit Help or Contact.';
  } elseif ( $template === 'page-help.php' ) {
    $data['title']       = 'Help Center | NoAway – Installation, Activation, Troubleshooting';
    $data['description'] = 'Find quick answers about installing, activating, and using NoAway. Installation guide for macOS and Windows, license activation, and troubleshooting.';
  } elseif ( $template === 'page-contatti.php' ) {
    $data['title']       = 'Contact NoAway | Support & Help';
    $data['description'] = 'Get in touch with NoAway support. Questions about installation, licensing, or technical support? We\'re happy to help.';
    $data['canonical']   = noaway_seo_canonical_url( home_url( '/contacts/' ) );
  } elseif ( $template === 'page-faq.php' ) {
    $data['title']       = 'FAQ – How NoAway Keeps Teams Active, Safety & Pricing | NoAway';
    $data['description'] = 'Common questions about NoAway: how it keeps Teams and Slack active, whether it\'s detectable by IT, how it handles privacy, pricing, and why alternatives like mouse jigglers don\'t work.';
  } elseif ( $template === 'page-releases.php' ) {
    $data['title']       = 'NoAway Releases | Current Version & Signed Installers';
    $data['description'] = 'Current NoAway version ' . noaway_fact( 'publisher.app_version' ) . ' for Mac and Windows, release notes, and how to verify the signed installer from ' . noaway_fact( 'publisher.signer_display' ) . '.';
  } elseif ( $template === 'page-sitemap.php' ) {
    $data['title']       = 'Sitemap | NoAway';
    $data['description'] = 'Navigate all pages of the NoAway website: Features, How it works, Download, Help, Contacts, Privacy, Terms.';
  } elseif ( $template === 'page-privacy-policy.php' ) {
    $data['title']       = 'Privacy Policy | NoAway';
    $data['description'] = 'NoAway privacy policy: what information we collect, how we use it, and how we protect your data.';
    $privacy_page = get_page_by_path( 'privacy-policy' );
    if ( $privacy_page instanceof WP_Post && $privacy_page->post_status === 'publish' ) {
      $data['canonical'] = noaway_seo_canonical_url( home_url( '/privacy-policy/' ) );
    }
  } elseif ( $template === 'page-terms-of-service.php' ) {
    $data['title']       = 'Terms of Service | NoAway';
    $data['description'] = 'NoAway terms of service: license, use, and legal terms for the NoAway application.';
  }

  if ( function_exists( 'noaway_i18n_current_landing' ) ) {
    $landing = noaway_i18n_current_landing();
    if ( is_array( $landing ) ) {
      $data['og_locale']   = noaway_i18n_og_locale( $landing['lang'] );
      $data['in_language'] = noaway_i18n_bcp47( $landing['lang'] );
      $copy = noaway_i18n_landing_copy( $landing['family'], $landing['lang'] );
      if ( ! empty( $copy['seo_title'] ) ) {
        $data['title'] = $copy['seo_title'];
      }
      if ( ! empty( $copy['seo_description'] ) ) {
        $data['description'] = $copy['seo_description'];
      }
      // Self-canonical for every language in the cluster (en + localized).
      $self_url = noaway_i18n_landing_url( $landing['family'], $landing['lang'] );
      if ( is_string( $self_url ) && $self_url !== '' ) {
        $data['canonical']        = $self_url;
        $data['canonical_branch'] = 'permalink';
      }
    }
  }

  $data['og_image'] = isset( $data['og_image'] ) ? $data['og_image'] : $default_image;
  if ( strpos( $data['og_image'], 'http' ) !== 0 ) {
    $data['og_image'] = home_url( $data['og_image'] );
  }
  $data['og_image'] = noaway_seo_canonical_url( $data['og_image'] );
  return $data;
}

/**
 * Output SEO meta tags (description, canonical, Open Graph, Twitter Card).
 */
function noaway_seo_wp_head() {
  $d = noaway_seo_get_page_data();
  $title = $d['title'];
  $desc  = $d['description'];
  $canonical = isset( $d['canonical'] ) ? $d['canonical'] : '';
  $branch = isset( $d['canonical_branch'] ) ? $d['canonical_branch'] : 'home';
  if ( ! is_string( $canonical ) || trim( $canonical ) === '' ) {
    $canonical = noaway_seo_request_canonical_url();
    $branch = 'request';
  }
  $image = isset( $d['og_image'] ) ? $d['og_image'] : '';
  if ( ! is_string( $image ) || strpos( $image, 'http' ) !== 0 ) {
    $image = home_url( is_string( $image ) ? $image : '' );
  }
  $image = noaway_seo_canonical_url( $image );

  echo "\n";
  if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    $allowed_branches = array( 'permalink', 'request', 'front_page', 'home' );
    if ( ! in_array( $branch, $allowed_branches, true ) ) {
      $branch = 'request';
    }
    echo '<!-- noaway-canonical: ' . esc_html( $branch ) . " -->\n";
  }
  echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
  $canonical_href = esc_url( $canonical );
  if ( $canonical_href !== '' ) {
    echo '<link rel="canonical" href="' . $canonical_href . '">' . "\n";
  }
  $landing_alt = function_exists( 'noaway_i18n_current_landing' ) ? noaway_i18n_current_landing() : null;
  if ( is_array( $landing_alt ) ) {
    foreach ( noaway_i18n_hreflang_pairs( $landing_alt['family'] ) as $pair ) {
      $alt_href = isset( $pair['href'] ) ? esc_url( $pair['href'] ) : '';
      if ( $alt_href === '' ) {
        continue;
      }
      echo '<link rel="alternate" hreflang="' . esc_attr( $pair['hreflang'] ) . '" href="' . $alt_href . '">' . "\n";
    }
  }

  echo '<!-- Open Graph -->' . "\n";
  echo '<meta property="og:type" content="website">' . "\n";
  echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
  echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
  echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
  if ( $canonical_href !== '' ) {
    echo '<meta property="og:url" content="' . $canonical_href . '">' . "\n";
  }
  echo '<meta property="og:site_name" content="NoAway">' . "\n";
  $og_locale = ( isset( $d['og_locale'] ) && is_string( $d['og_locale'] ) && $d['og_locale'] !== '' ) ? $d['og_locale'] : 'en_US';
  echo '<meta property="og:locale" content="' . esc_attr( $og_locale ) . '">' . "\n";
  if ( is_array( $landing_alt ) ) {
    foreach ( noaway_i18n_og_locale_alternates( $landing_alt['lang'] ) as $alt_locale ) {
      echo '<meta property="og:locale:alternate" content="' . esc_attr( $alt_locale ) . '">' . "\n";
    }
  }

  echo '<!-- Twitter Card -->' . "\n";
  echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
  echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
  echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
  echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
  echo "\n";
}
add_action( 'wp_head', 'noaway_seo_wp_head', 2 );

/**
 * Override document title with SEO title.
 */
function noaway_seo_document_title( $title_parts ) {
  $d = noaway_seo_get_page_data();
  $title_parts['title']   = $d['title'];
  $title_parts['site']    = '';
  $title_parts['tagline'] = '';
  return $title_parts;
}
add_filter( 'document_title_parts', 'noaway_seo_document_title', 10, 1 );

/**
 * FAQ items per lo schema FAQPage (usato solo sulla pagina FAQ).
 * Fonte unica: evita "Campo duplicato FAQPage" nei risultati avanzati Google.
 */
function noaway_seo_faq_schema_entities() {
  $entities = array(
    array( 'name' => 'Will I always appear Active on Teams or Slack?', 'text' => 'No. NoAway prevents this computer from entering an idle state while it is running, which helps during long tasks such as downloads, builds, or presentations. It does not control calendar status, a locked screen, company policy, or other devices.' ),
    array( 'name' => 'Is using NoAway safe?', 'text' => 'NoAway is a desktop utility that keeps the system from entering an idle state while enabled. It does not read your files or messages. ' . noaway_fact_data_sent_paragraph( false ) . ' For a full breakdown (admin rights, company PCs, what it does not do), see the Is NoAway safe page at /is-noaway-safe/.' ),
    array( 'name' => 'Does NoAway slow down my computer?', 'text' => 'No. The application runs quietly in the background and is designed to use minimal system resources.' ),
    array( 'name' => 'Can I start NoAway automatically?', 'text' => 'Yes. NoAway can be configured to start automatically when your computer boots so it is ready whenever you need it.' ),
    array( 'name' => 'Do I need to keep the app open?', 'text' => 'No. ' . noaway_fact( 'requirements.process' ) . ' NoAway can also start automatically when your computer boots.' ),
    array( 'name' => 'Do I need an internet connection?', 'text' => 'Keep Active runs on your computer. A connection is needed to download the app and to activate your license. ' . noaway_fact( 'data_sent.when_label' ) ),
    array( 'name' => 'Is NoAway a subscription?', 'text' => 'No. NoAway is a one-time purchase. ' . noaway_fact( 'license.devices_label' ) . ' ' . noaway_fact( 'license.lifetime_updates' ) ),
    array( 'name' => 'Will my boss or IT department know I\'m using this?', 'text' => noaway_fact_data_sent_paragraph( false ) . ' While Keep Active is on, your operating system sees the computer as active. Every workplace has its own policies regarding software, so follow your company\'s guidelines.' ),
    array( 'name' => 'Is NoAway detectable by Microsoft Teams?', 'text' => 'NoAway does not interact with Microsoft Teams directly. Instead, it prevents your computer from entering an idle state at the system level. Applications that rely on system activity signals may therefore continue to show an active status while the system is active.' ),
    array( 'name' => 'Does NoAway interact with Microsoft Teams directly?', 'text' => 'No. NoAway does not modify or control Microsoft Teams. It simply keeps the operating system active while it runs, which may help prevent applications from detecting inactivity during long-running tasks.' ),
    array( 'name' => 'Does NoAway collect any personal data?', 'text' => noaway_fact_data_sent_paragraph( true ) ),
    array( 'name' => 'Why does Teams switch to Away after only a few minutes?', 'text' => 'Microsoft Teams automatically updates your presence based on system activity. If the system detects no keyboard or mouse input for a certain period of time, the status may change to Away. This can happen even when you\'re still working, such as during downloads, builds, or when reading documentation.' ),
    array( 'name' => 'Why can\'t I just set my Teams status to "Available"?', 'text' => 'Setting your status to Available manually does not prevent Teams from changing it later. Microsoft Teams automatically updates your presence based on system activity. If your computer becomes idle for several minutes, Teams may switch your status to Away, even if you previously set it to Available.' ),
    array( 'name' => 'Why does Teams show "Away" even when I\'m still working?', 'text' => 'Teams determines your status primarily from system activity, such as keyboard or mouse input. If you\'re reading documentation, watching dashboards, waiting for downloads, or monitoring builds, your computer may appear idle even though you\'re actively working. When this happens, Teams may automatically switch your status to Away.' ),
    array( 'name' => 'Why doesn\'t changing Windows or macOS sleep settings fix the problem?', 'text' => 'Power or sleep settings control when your computer goes to sleep, but they do not control how Teams determines presence. Your system can remain fully awake while Teams still detects a period of inactivity and updates your status to Away.' ),
    array( 'name' => 'Do tricks like moving the mouse slightly or using scripts work?', 'text' => 'Some people try small scripts or manual tricks to simulate activity, but these solutions are usually unreliable. They may stop working after system updates, require constant adjustment, or interfere with normal workflows. Most of these approaches were not designed for long-term use.' ),
    array( 'name' => 'Why doesn\'t a simple setting exist in Teams to stay active?', 'text' => 'Presence status in Microsoft Teams is designed to reflect recent activity on the device, and much of this behavior is managed automatically by the application and system signals. Because of this design, there is no official setting that permanently forces a user\'s status to remain Available.' ),
    array( 'name' => 'Is there a reliable way to keep Teams from switching to Away during long tasks?', 'text' => 'When your computer remains active, Teams typically continues to show your status as Available. Tools designed to prevent the system from becoming idle during long-running tasks can help maintain consistent activity while you work, download files, run builds, or attend meetings.' ),
    array( 'name' => 'Does this only affect Microsoft Teams?', 'text' => 'No. Many communication tools determine presence based on system activity. Applications like Slack and others may behave similarly, switching to Away when the system detects no keyboard or mouse activity for a period of time.' ),
    array( 'name' => 'Is keeping the computer active the same as faking activity?', 'text' => 'No. Preventing a computer from entering an idle state simply keeps the system active during long tasks. For example, developers running builds, designers rendering files, or professionals downloading large datasets may remain actively working while the computer shows little input activity.' ),
    // Domande cercate su Google (ordine di ricerca) + Reddit – SEO long-tail
    // Keyword "how to stay active on microsoft teams" integrated in question and answer.
    array( 'name' => 'How do I stop Microsoft Teams from showing away?', 'text' => 'Microsoft Teams switches to Away when it detects no keyboard or mouse activity. To stay active on Microsoft Teams, use an app that keeps your computer active—like NoAway—so your status stays Available during downloads, builds, or deep work. No need to move the mouse or use unreliable tricks.' ),
    // Keyword "how to keep Teams stay active" + "app that keeps teams active" in answer.
    array( 'name' => 'How to keep Teams stay active?', 'text' => 'Use an app that keeps Teams active, such as NoAway: a lightweight app that simulates natural activity so your system never goes idle. One click and your Teams status stays Available during long tasks, builds, or downloads. It’s one of the most reliable ways to stay active on Microsoft Teams.' ),
    // Keyword "how to keep teams icon green" in answer (same query as "Teams turns yellow").
    array( 'name' => 'How many minutes until Teams turns yellow?', 'text' => 'Microsoft Teams typically turns your status to Away (yellow) after about 5 minutes of no keyboard or mouse input. Keeping the system active is what stops that idle timer. Whether Teams shows Available also depends on permissions and Help conditions.' ),
    array( 'name' => 'How to keep Teams status active hack?', 'text' => 'So-called "hacks" like moving the mouse or running scripts are unreliable and can break after updates. NoAway is a proper solution: it runs in the tray, keeps your system active, and works consistently with Teams without hacks.' ),
    array( 'name' => 'How do I stop my team from turning yellow?', 'text' => 'If you mean your own status in Microsoft Teams: Teams turns status yellow (Away) after about 5 minutes of inactivity. NoAway keeps this computer from going idle during long tasks. Whether Teams shows Available also depends on permissions and Help conditions.' ),
    array( 'name' => 'How to stay online on Teams without moving the mouse?', 'text' => 'NoAway simulates activity at the system level so you don\'t have to move the mouse or touch the keyboard. Just enable it from the tray and your status stays Available—no wiggling or scripts needed. It’s an app that keeps Teams active so you can stay active on Microsoft Teams without manual tricks.' ),
    // Keyword "app that keeps teams active" in answer.
    array( 'name' => 'Forced to use Teams, how to avoid being \'away\'?', 'text' => 'Many workers are required to use Teams; appearing Away during long tasks can be misunderstood. NoAway keeps this computer from going idle during builds, downloads, or focused work. Calendar, a locked screen, company policy, and other devices can still change presence; see Help for the full list of conditions.' ),
    // New FAQ for query "how to keep teams icon green" (distinct from "Teams turns yellow").
    array( 'name' => 'How to keep the Teams icon green?', 'text' => 'The Teams icon turns green (Available) when Microsoft Teams detects system activity, and yellow after about 5 minutes without input. NoAway keeps this computer from going idle while Keep Active is on. Whether the icon stays green also depends on permissions and Help conditions.' ),
    // Troubleshooting: what to do if Teams still shows Away
    array( 'name' => 'What should I do if Teams still shows Away?', 'text' => 'Make sure NoAway is running and Keep Active is enabled. Use the latest version of NoAway (updates improve timing so Teams does not go Away after a few minutes). After updating, use "Restart Activity Engine" from the tray menu. Check "Open Logs" in the menu: if you see "simulated" lines every few minutes, the app is working; if you see errors, contact support. On Windows, try running NoAway as Administrator once and ensure your antivirus is not blocking it.' ),
  );
  return apply_filters( 'noaway_faq_schema_entities', $entities );
}

/**
 * Homepage FAQ. Visible markup and FAQPage JSON-LD both use this list.
 *
 * @return array<int, array{name:string,text:string}>
 */
function noaway_front_page_faqs() {
  $teams = function_exists( 'noaway_keep_teams_active_page_url' ) ? noaway_keep_teams_active_page_url() : home_url( '/keep-teams-active/' );
  $icon  = esc_url( $teams . '#keep-teams-icon-green' );
  return array(
    array(
      'name' => 'How do I stop Microsoft Teams from showing away?',
      'text' => 'Microsoft Teams switches to Away when it detects no keyboard or mouse activity. NoAway keeps this computer from going idle, which is the signal Teams uses, during downloads, builds, or deep work. Whether Teams shows Available also depends on permissions and Help conditions.',
    ),
    array(
      'name' => 'How to keep Teams stay active? Is there an app that keeps Teams active?',
      'text' => 'Use an app that keeps the computer from going idle, like NoAway, so Teams is less likely to flip to Away during a long build, a render, or a large download. Presence on another device is separate.',
    ),
    array(
      'name' => 'How to keep the Teams icon green?',
      'text' => 'Teams turns the icon yellow (Away) after about 5 minutes with no keyboard or mouse activity. Keeping this computer active is what the desktop app reads. NoAway does that while Keep Active is on. A locked screen, calendar, or company policy can still change the icon. <a href="' . $icon . '" class="text-primary font-semibold hover:underline">How to keep the Teams icon green on Mac and Windows</a>.',
    ),
    array(
      'name' => 'How many minutes until Teams turns yellow?',
      'text' => 'Microsoft Teams typically turns your status to Away (yellow) after about 5 minutes of no keyboard or mouse input on the desktop app. Keeping the system active is what stops that idle timer. It does not cover calendar, calls, or other devices.',
    ),
    array(
      'name' => 'Will my status stay Available while I am working?',
      'text' => 'Not always. While NoAway is on, this computer does not go idle and does not sleep. Teams and Slack read that signal, so they are less likely to show Away during a build, a render, or a large download. Calendar, a locked screen, company policy, and other devices can still change presence.',
    ),
    array(
      'name' => 'Is using NoAway safe?',
      'text' => 'NoAway is a desktop utility. It does not read files or messages. ' . noaway_fact_data_sent_paragraph( false ) . ' Details are on the Is NoAway safe page.',
    ),
    array(
      'name' => 'Does NoAway slow down my computer?',
      'text' => 'Not at all. NoAway is extremely lightweight and uses almost no CPU or memory.',
    ),
    array(
      'name' => 'Does NoAway send my activity anywhere?',
      'text' => noaway_fact_data_sent_paragraph( true ) . ' See the privacy page for the full list.',
    ),
    array(
      'name' => 'Do I need to keep the app open?',
      'text' => 'No. ' . noaway_fact( 'requirements.process' ) . ' NoAway can also start automatically when your computer boots.',
    ),
    array(
      'name' => 'Is this a subscription?',
      'text' => 'No. NoAway is a one-time purchase. ' . noaway_fact( 'license.devices_label' ) . ' ' . noaway_fact( 'license.lifetime_updates' ),
    ),
  );
}

/**
 * FAQPage entities for the homepage. Plain text of noaway_front_page_faqs().
 *
 * @return array<int, array{name:string,text:string}>
 */
function noaway_seo_front_page_faq_schema_entities() {
  $entities = array();
  foreach ( noaway_front_page_faqs() as $faq ) {
    $entities[] = array(
      'name' => $faq['name'],
      'text' => wp_strip_all_tags( $faq['text'] ),
    );
  }
  return apply_filters( 'noaway_front_page_faq_schema_entities', $entities );
}

/**
 * Versione app/tema per SoftwareApplication JSON-LD.
 */
function noaway_seo_theme_version_for_schema() {
  // App version from installer filenames (NoAway-1.0.6-*). Not the theme version.
  // The homepage badge "Anti-idle engine v2.0" is the idle-prevention engine, not this version.
  if ( function_exists( 'noaway_fact' ) ) {
    $v = noaway_fact( 'publisher.app_version', '' );
    if ( is_string( $v ) && $v !== '' ) {
      return $v;
    }
  }
  if ( defined( 'NOAWAY_APP_VERSION' ) && is_string( NOAWAY_APP_VERSION ) && NOAWAY_APP_VERSION !== '' ) {
    return NOAWAY_APP_VERSION;
  }
  return '1.0.6';
}

/**
 * Article dates from the WordPress page, else the template file's mtime.
 *
 * @return array{0:string,1:string} datePublished, dateModified (Y-m-d).
 */
function noaway_seo_article_dates( $template_slug ) {
  $published = '';
  $modified  = '';
  if ( is_singular() ) {
    $post = get_queried_object();
    if ( $post instanceof WP_Post ) {
      $published = mysql2date( 'Y-m-d', $post->post_date_gmt, false );
      $modified  = mysql2date( 'Y-m-d', $post->post_modified_gmt, false );
    }
  }
  $file_day = '';
  if ( is_string( $template_slug ) && $template_slug !== '' ) {
    $file = get_stylesheet_directory() . '/' . ltrim( $template_slug, '/' );
    if ( file_exists( $file ) ) {
      $file_day = gmdate( 'Y-m-d', (int) filemtime( $file ) );
    }
  }
  if ( ! is_string( $published ) || $published === '' ) {
    $published = $file_day;
  }
  if ( ! is_string( $modified ) || $modified === '' ) {
    $modified = $file_day;
  }
  if ( $published !== '' && $modified !== '' && $modified < $published ) {
    $modified = $published;
  }
  return array( $published, $modified );
}

/**
 * FAQ JSON-LD per landing specifiche — allineate al contenuto visibile.
 *
 * @return array<int, array{name:string,text:string}>|null
 */
function noaway_seo_landing_faq_items( $template_slug ) {
  if ( $template_slug === 'page-keep-slack-active.php' && function_exists( 'noaway_i18n_landing_copy' ) ) {
    $lang = 'en';
    if ( function_exists( 'noaway_i18n_current_landing' ) ) {
      $landing = noaway_i18n_current_landing();
      if ( is_array( $landing ) && isset( $landing['family'], $landing['lang'] ) && $landing['family'] === 'slack' ) {
        $lang = $landing['lang'];
      }
    }
    $copy = noaway_i18n_landing_copy( 'slack', $lang );
    if ( is_array( $copy ) && ! empty( $copy['faqs'] ) && is_array( $copy['faqs'] ) ) {
      return $copy['faqs'];
    }
  }
  $map = array(
    'page-teams-away-status.php' => array(
      array(
        'name' => 'Why does Teams show Away while I am working?',
        'text' => 'Teams sets presence from activity, calendar, calls, and which client you use. Reading without input, a locked screen, a meeting, or another device can change status even though you are still working. See Microsoft’s presence documentation for admin details.',
      ),
      array(
        'name' => 'What is the difference between Away, Offline, and Appear away?',
        'text' => 'Away means you are signed in and Teams treats you as inactive or Away. Offline means that client is not showing you as present (closed, signed out, or disconnected). Appear away is a manual status you choose so others see Away even if you are active.',
      ),
      array(
        'name' => 'Does locking the screen make Teams show Away?',
        'text' => 'A locked screen stops keyboard and mouse input. Teams can switch that device to Away.',
      ),
      array(
        'name' => 'Can a meeting or calendar event change my status?',
        'text' => 'Yes. A call or a calendar block can set Busy, In a meeting, or Out of office. Keeping the computer active does not override calendar or call presence.',
      ),
      array(
        'name' => 'Do desktop, web, and mobile follow the same rule?',
        'text' => 'No. The desktop app commonly follows the computer idle timer (about 5 minutes). The browser follows the browser session. Mobile can change when you leave the app or lock the phone. Activity on one device does not keep the others Available.',
      ),
      array(
        'name' => 'Why does changing sleep settings not keep me Available?',
        'text' => 'Sleep settings decide when the display or the computer sleeps. Teams still looks for recent input. A machine that is awake but idle can still show Away.',
      ),
    ),
    'page-keep-slack-active.php' => array(
      array(
        'name' => 'How long before Slack shows Away?',
        'text' => 'On the Slack desktop app, Slack marks you as Away after approximately 10 minutes of no keyboard or mouse activity. Browser and mobile clients follow different presence rules and are not tied to that same desktop idle window.',
      ),
      array(
        'name' => 'How do I keep my Slack status active?',
        'text' => 'Use a lightweight background app like NoAway that prevents your computer from going idle. Slack detects activity at the OS level, so keeping the system active keeps your Slack status active on Mac and Windows.',
      ),
      array(
        'name' => 'Does Slack show how long you have been away?',
        'text' => 'Slack shows a general Away status but does not display an exact duration to other users. It may still use last-active information internally for notification routing.',
      ),
      array(
        'name' => 'How long does Slack stay active?',
        'text' => 'On desktop, Slack keeps you Active until the idle window is reached—about 10 minutes without keyboard or mouse input. There is no setting that permanently extends that timer.',
      ),
      array(
        'name' => 'When does Slack show inactive or Away?',
        'text' => 'Slack shows Away when it stops seeing recent user activity on that client. On desktop that is typically after about 10 minutes without input; web and mobile can change under different conditions.',
      ),
      array(
        'name' => 'What is the difference between Slack Away, Do Not Disturb, and custom status?',
        'text' => 'Away is inferred presence after idle time. Do Not Disturb pauses notifications. A custom status is a message for teammates. Neither DND nor a custom status stops Slack from switching to Away after desktop inactivity.',
      ),
    ),
    'page-prevent-computer-sleep.php' => array(
      array(
        'name' => 'How do I prevent my Mac from going to sleep?',
        'text' => 'Lengthen the sleep timer in System Settings → Displays → Advanced, or use NoAway to keep the Mac awake on demand without a permanent power-plan change.',
      ),
      array(
        'name' => 'How do I prevent my Windows PC from going to sleep?',
        'text' => 'Set Sleep to Never under Settings → System → Power & sleep, or use NoAway to keep the PC awake only when you need it without a permanent setting change.',
      ),
      array(
        'name' => 'Why does my computer sleep and make Teams show Away?',
        'text' => 'Teams treats system idle as Away. Sleep settings keep the machine awake but do not create keyboard or mouse input, so Teams can still show Away. Keeping the system active is a separate step; whether Teams shows Available also depends on permissions and Help conditions.',
      ),
    ),
    'page-is-noaway-safe.php' => array(
      array(
        'name' => 'Is NoAway safe to install?',
        'text' => 'NoAway is a lightweight desktop utility that runs locally to prevent system idle. It does not keylog, capture your screen, or access Teams or Slack accounts or messages. Always download from the official NoAway site.',
      ),
      array(
        'name' => 'Is NoAway a legit company product?',
        'text' => 'Yes. NoAway is a commercial one-time-purchase app for Mac and Windows from OLIVEE SRLS, with published Privacy Policy and Terms of Service.',
      ),
      array(
        'name' => 'Does NoAway need administrator rights?',
        'text' => 'NoAway is designed to install and run without admin rights on a typical personal Mac or Windows PC. Company-managed devices may still block third-party apps through IT policy.',
      ),
      array(
        'name' => 'Can I use NoAway on a work laptop?',
        'text' => 'Only if your company policy allows it. Some managed devices block third-party software. Follow your IT rules; NoAway does not bypass MDM or endpoint protection.',
      ),
      array(
        'name' => 'Does NoAway send my activity data anywhere?',
        'text' => noaway_fact_data_sent_paragraph( false ) . ' See the Privacy Policy for the full list.',
      ),
      array(
        'name' => 'Do you offer refunds? How do I get support?',
        'text' => noaway_fact( 'license.refund' ) . ' For purchase or activation help, use the contact page or Help Center with your order email. License terms are in the Terms of Service.',
      ),
      array(
        'name' => 'Is NoAway code-signed on Mac and Windows?',
        'text' => 'Yes. Official installers are signed in our GitHub Actions release pipeline: Developer ID and notarization on macOS, Authenticode on Windows. Download only from the official NoAway site.',
      ),
    ),
  );

  // Comparison landings: FAQ from the active comparison slug.
  if ( $template_slug === 'page-compare.php' && function_exists( 'noaway_get_comparison_for_current_page' ) ) {
    $cmp = noaway_get_comparison_for_current_page();
    if ( is_array( $cmp ) && ! empty( $cmp['faqs'] ) && is_array( $cmp['faqs'] ) ) {
      $items = array();
      foreach ( $cmp['faqs'] as $faq ) {
        if ( empty( $faq['name'] ) || empty( $faq['text'] ) ) {
          continue;
        }
        $items[] = array(
          'name' => $faq['name'],
          'text' => $faq['text'],
        );
      }
      return $items ? $items : null;
    }
  }

  return isset( $map[ $template_slug ] ) ? $map[ $template_slug ] : null;
}

/**
 * HowTo JSON-LD per guide Teams/Slack.
 *
 * @return array<string,mixed>|null
 */
function noaway_seo_howto_schema( $template_slug, $download_url ) {
  $download_url = noaway_seo_canonical_url( $download_url );
  $maps = array(
    'page-keep-teams-active.php' => array(
      'name'          => 'How to keep Teams active and the icon green on Mac and Windows',
      'description'   => 'Keep Microsoft Teams Available, including a green icon, on Mac and Windows by keeping the computer active during builds, downloads, and deep work.',
      'totalTime'     => 'PT2M',
      'step3_text'    => 'On Windows, open NoAway from the system tray. On Mac, open it from the menu bar. Turn Keep Active on so Teams does not mark the session idle.',
    ),
    'page-keep-slack-active.php' => array(
      'name'        => 'How to keep Slack active and prevent Away status',
      'description' => 'On the Slack desktop app, Away starts after about 10 minutes of inactivity. Here is how to keep this computer from going idle on Mac and Windows.',
      'totalTime'   => 'PT2M',
      'step3_text'  => 'Turn Keep Active on. NoAway keeps this computer from going idle, which is the signal Slack reads. Whether Slack shows Active also depends on permissions and Help conditions.',
    ),
    'page-prevent-computer-sleep.php' => array(
      'name'        => 'How to prevent computer sleep on Mac or Windows',
      'description' => 'Keep your PC awake during long tasks and avoid idle detection in Teams and Slack by using a lightweight tray app.',
      'totalTime'   => 'PT2M',
      'step3_text'  => 'Enable NoAway from the tray or menu bar. It reduces display sleep and system idle so your status stays Available.',
    ),
  );
  if ( ! isset( $maps[ $template_slug ] ) ) {
    return null;
  }
  $m = $maps[ $template_slug ];
  return array(
    '@type'       => 'HowTo',
    'name'        => $m['name'],
    'description' => $m['description'],
    'totalTime'   => $m['totalTime'],
    'step'        => array(
      array(
        '@type'    => 'HowToStep',
        'name'     => 'Download NoAway',
        'text'     => 'Download NoAway for macOS or Windows from ' . $download_url,
        'position' => 1,
      ),
      array(
        '@type'    => 'HowToStep',
        'name'     => 'Install and launch',
        'text'     => 'Install NoAway and open it. The app appears in your system tray or menu bar.',
        'position' => 2,
      ),
      array(
        '@type'    => 'HowToStep',
        'name'     => 'Enable NoAway',
        'text'     => $m['step3_text'],
        'position' => 3,
      ),
    ),
  );
}

/**
 * Article JSON-LD per landing lunghe (stesso ruolo del precedente blocco in pagina).
 *
 * @return array<string,mixed>|null
 */
function noaway_seo_article_schema_for_template( $template_slug, $canonical_url, $home_url ) {
  $canonical_url = noaway_seo_canonical_url( $canonical_url );
  $home_url      = noaway_seo_canonical_url( $home_url );
  $pub  = array( '@type' => 'Organization', 'name' => 'NoAway', 'url' => $home_url );
  list( $date_published, $date_modified ) = noaway_seo_article_dates( $template_slug );
  $base = array(
    '@type'            => 'Article',
    'publisher'        => $pub,
    'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => $canonical_url ),
  );
  if ( $date_published !== '' ) {
    $base['datePublished'] = $date_published;
  }
  if ( $date_modified !== '' ) {
    $base['dateModified'] = $date_modified;
  }
  $by_template = array(
    'page-teams-away-status.php' => array(
      'headline'    => 'Why Teams shows Away while you\'re working',
      'description' => 'Teams can show Away while you work because of a locked screen, a calendar event or call, or idle time. Desktop, web, and mobile differ. Sleep settings alone do not keep you Available.',
    ),
    'page-keep-slack-active.php' => array(
      'headline'    => 'How to Keep Slack Active and Prevent Away Status',
      'description' => 'On the Slack desktop app, Away starts after about 10 minutes of inactivity. Mobile apps set you to away when you leave or close the app. NoAway keeps this computer from going idle.',
    ),
    'page-prevent-computer-sleep.php' => array(
      'headline'    => 'How to Prevent Computer Sleep and Keep Your Computer Awake',
      'description' => 'To prevent computer sleep and keep your computer awake on Mac or Windows, use a small app that keeps the system active so it never goes idle. That also keeps Teams, Slack, and other apps showing you as available during long downloads, builds, or remote work.',
    ),
    'page-keep-teams-active.php' => array(
      'headline'    => 'Never Go Away on Teams Again — Keep Teams Active',
      'description' => 'How to keep Microsoft Teams Available on Mac and Windows, including a green icon, without mouse jigglers. NoAway keeps your computer active during builds, downloads, and deep work.',
    ),
    'page-is-noaway-safe.php' => array(
      'headline'    => 'Is NoAway Safe?',
      'description' => 'NoAway is a local desktop utility that prevents system idle. It does not keylog, capture your screen, or access Teams or Slack accounts. Honest notes on admin rights, company PCs, and support.',
    ),
    'page-features.php' => array(
      'headline'    => 'NoAway Features — Lightweight App to Keep Teams & Slack Active',
      'description' => 'NoAway features: lightweight tray app, Mac & Windows, minimal resources, simple setup, automatic startup, scheduled wake. Built to stay out of your way.',
    ),
    'page-how-it-works.php' => array(
      'headline'    => 'How NoAway Works — Install, Enable, Stay Available',
      'description' => 'Install NoAway once, enable Keep Active from the tray, and your computer stays active automatically. No complicated setup. Works with Teams, Slack, Zoom.',
    ),
    'page-thank-you.php' => array(
      'headline'    => 'Thank You — Your NoAway Purchase Is Confirmed',
      'description' => 'Your NoAway purchase is confirmed. Download NoAway for macOS or Windows. One-time €' . NOAWAY_SEO_PRICE_AMOUNT . '. ' . noaway_fact( 'license.lifetime_updates_short' ),
    ),
  );
  if ( $template_slug === 'page-compare.php' && function_exists( 'noaway_get_comparison_for_current_page' ) ) {
    $cmp = noaway_get_comparison_for_current_page();
    if ( is_array( $cmp ) ) {
      return array_merge(
        $base,
        array(
          'headline'    => isset( $cmp['h1'] ) ? $cmp['h1'] : 'NoAway comparison',
          'description' => isset( $cmp['verdict'] ) ? $cmp['verdict'] : ( isset( $cmp['intro'] ) ? $cmp['intro'] : '' ),
        )
      );
    }
  }

  if ( ! isset( $by_template[ $template_slug ] ) ) {
    return null;
  }
  return array_merge( $base, $by_template[ $template_slug ] );
}

/**
 * WebPage JSON-LD per pagine legali/contatti/mappa (senza Article duplicato).
 *
 * @return array<string,mixed>|null
 */
function noaway_seo_webpage_supplemental_schema( $template_slug, $canonical_url, $home_url ) {
  $templates = array(
    'page-privacy-policy.php',
    'page-terms-of-service.php',
    'page-sitemap.php',
    'page-contatti.php',
    'page-faq.php',
    'page-help.php',
    'page-releases.php',
    'page-downloads.php',
    'page-download.php',
  );
  if ( ! in_array( $template_slug, $templates, true ) ) {
    return null;
  }
  $canonical_url = noaway_seo_canonical_url( $canonical_url );
  $home_url      = noaway_seo_canonical_url( $home_url );
  $d             = noaway_seo_get_page_data();
  return array(
    '@type'       => 'WebPage',
    '@id'         => $canonical_url . '#webpage',
    'url'         => $canonical_url,
    'name'        => wp_strip_all_tags( $d['title'] ),
    'description' => $d['description'],
    'inLanguage'  => 'en',
    'isPartOf'    => array(
      '@type' => 'WebSite',
      'name'  => 'NoAway',
      'url'   => $home_url,
    ),
  );
}

/**
 * Logo organizzazione: PNG se presente, altrimenti logo.svg.
 */
function noaway_seo_organization_logo_url() {
  $file = 'logo.svg';
  $dir  = get_stylesheet_directory();
  if ( is_string( $dir ) && file_exists( $dir . '/assets/images/logo.png' ) ) {
    $file = 'logo.png';
  }
  return noaway_seo_canonical_url( get_stylesheet_directory_uri() . '/assets/images/' . $file );
}

/**
 * Profili esterni (AlternativeTo, Product Hunt, YouTube, …).
 *
 * @return array<int, string>
 */
function noaway_seo_same_as_urls() {
  $urls = apply_filters( 'noaway_same_as', array() );
  if ( ! is_array( $urls ) ) {
    return array();
  }
  $clean = array();
  foreach ( $urls as $url ) {
    if ( is_string( $url ) && trim( $url ) !== '' ) {
      $clean[] = trim( $url );
    }
  }
  return $clean;
}

/**
 * @param array<int, array<string, mixed>> $graph
 */
function noaway_seo_graph_has_type( $graph, $type ) {
  foreach ( $graph as $node ) {
    if ( is_array( $node ) && isset( $node['@type'] ) && $node['@type'] === $type ) {
      return true;
    }
  }
  return false;
}

/**
 * SoftwareApplication + Offer. Un solo nodo per pagina.
 *
 * @return array<string, mixed>
 */
function noaway_seo_software_application_node( $url ) {
  $home         = trailingslashit( noaway_seo_canonical_url( home_url( '/' ) ) );
  $download_url = function_exists( 'noaway_downloads_page_url' ) ? noaway_downloads_page_url() : trailingslashit( $home ) . 'downloads/';
  $download_url = noaway_seo_canonical_url( $download_url );
  $screenshot   = noaway_seo_canonical_url( get_stylesheet_directory_uri() . '/assets/images/landing-hero-section.png' );
  if ( ! is_string( $url ) || $url === '' ) {
    $url = $home;
  }
  return array(
    '@type'               => 'SoftwareApplication',
    'name'                => 'NoAway',
    'applicationCategory' => 'ProductivityApplication',
    'operatingSystem'     => 'macOS, Windows',
    'description'         => noaway_fact_i18n( 'benefit.short', 'en' ) . ' One-time purchase (EUR) for Mac and Windows.',
    'url'                 => $url,
    'downloadUrl'         => $download_url,
    'softwareVersion'     => noaway_seo_theme_version_for_schema(),
    'screenshot'          => $screenshot,
    'featureList'         => array(
      'Prevents Teams Away status',
      'Keeps Slack status active',
      'Prevents computer sleep',
      'System tray app for Mac and Windows',
      'No admin rights required',
      'No subscription',
    ),
    'offers'              => array(
      '@type'         => 'Offer',
      'price'         => NOAWAY_SEO_PRICE_AMOUNT,
      'priceCurrency' => NOAWAY_SEO_PRICE_CURRENCY,
      'availability'  => 'https://schema.org/InStock',
      'priceValidUntil' => date( 'Y-m-d', strtotime( '+1 year' ) ),
      'description'   => 'One-time purchase (EUR). ' . noaway_fact( 'license.lifetime_updates_short' ) . ' ' . noaway_fact( 'license.devices_label' ) . ' Launch price.',
    ),
  );
}

/**
 * JSON-LD: SoftwareApplication, Organization, WebSite; homepage FAQPage; /faq/ FAQPage completo;
 * landing: Article + FAQPage (3) + HowTo dove previsto; BreadcrumbList pagine interne.
 */
function noaway_seo_structured_data() {
  $home         = trailingslashit( noaway_seo_canonical_url( home_url( '/' ) ) );
  $logo         = noaway_seo_organization_logo_url();
  $download_url = function_exists( 'noaway_downloads_page_url' ) ? noaway_downloads_page_url() : trailingslashit( $home ) . 'downloads/';
  $download_url = noaway_seo_canonical_url( $download_url );

  $graph = array(
    array(
      '@type'        => 'Organization',
      'name'         => 'NoAway',
      'url'          => $home,
      'logo'         => array(
        '@type' => 'ImageObject',
        'url'   => $logo,
      ),
      'contactPoint' => array(
        '@type'       => 'ContactPoint',
        'email'       => 'support@noaway.app',
        'contactType' => 'customer support',
      ),
    ),
    array(
      '@type'       => 'WebSite',
      'name'        => 'NoAway',
      'url'         => $home,
      'description' => noaway_fact_i18n( 'benefit.short', 'en' ) . ' One-time purchase (€' . NOAWAY_SEO_PRICE_AMOUNT . ') for Mac and Windows.',
      'inLanguage'  => 'en',
      'publisher'   => array( '@type' => 'Organization', 'name' => 'NoAway', 'url' => $home ),
    ),
  );
  $same_as = noaway_seo_same_as_urls();
  if ( $same_as ) {
    $graph[0]['sameAs'] = $same_as;
  }

  $template = get_page_template_slug();
  $product_templates = array(
    'page-keep-slack-active.php',
    'page-keep-teams-active.php',
    'page-teams-away-status.php',
    'page-prevent-computer-sleep.php',
    'page-is-noaway-safe.php',
    'page-compare.php',
  );
  $product_url = $home;
  if ( is_singular() && ! is_front_page() && in_array( $template, $product_templates, true ) ) {
    $page_url = get_permalink();
    $page_url = noaway_seo_canonical_url( is_string( $page_url ) ? $page_url : '' );
    if ( $page_url !== '' ) {
      $product_url = $page_url;
    }
  }
  if ( ! noaway_seo_graph_has_type( $graph, 'SoftwareApplication' ) ) {
    array_unshift( $graph, noaway_seo_software_application_node( $product_url ) );
  }

  // FAQPage homepage: solo le domande mostrate in front-page.php.
  if ( is_front_page() ) {
    $main_entity_home = array();
    foreach ( noaway_seo_front_page_faq_schema_entities() as $item ) {
      $main_entity_home[] = array(
        '@type'          => 'Question',
        'name'           => $item['name'],
        'acceptedAnswer' => array(
          '@type' => 'Answer',
          'text'  => $item['text'],
        ),
      );
    }
    $graph[] = array(
      '@type'      => 'FAQPage',
      'mainEntity' => $main_entity_home,
    );
  }

  $template = get_page_template_slug();

  // FAQPage pagina /faq/: elenco completo (unico blocco su quell'URL).
  if ( $template === 'page-faq.php' ) {
    $main_entity = array();
    foreach ( noaway_seo_faq_schema_entities() as $item ) {
      $main_entity[] = array(
        '@type'          => 'Question',
        'name'           => $item['name'],
        'acceptedAnswer' => array(
          '@type' => 'Answer',
          'text'  => $item['text'],
        ),
      );
    }
    $graph[] = array(
      '@type'      => 'FAQPage',
      'mainEntity' => $main_entity,
    );
  }

  $localized = null;
  if ( function_exists( 'noaway_i18n_current_landing' ) ) {
    $maybe_landing = noaway_i18n_current_landing();
    if ( is_array( $maybe_landing ) && isset( $maybe_landing['lang'] ) && $maybe_landing['lang'] !== 'en' ) {
      $localized = $maybe_landing;
    }
  }

  if ( $localized ) {
    $shared   = noaway_i18n_schema_shared( $localized['lang'] );
    $page_url = noaway_i18n_landing_url( $localized['family'], $localized['lang'] );
    foreach ( $graph as $node_index => $node ) {
      if ( ! is_array( $node ) || empty( $node['@type'] ) ) {
        continue;
      }
      if ( $node['@type'] === 'SoftwareApplication' ) {
        $graph[ $node_index ]['description'] = $shared['app_description'];
        $graph[ $node_index ]['featureList'] = $shared['features'];
        $graph[ $node_index ]['url']         = $page_url;
        if ( isset( $graph[ $node_index ]['offers'] ) && is_array( $graph[ $node_index ]['offers'] ) ) {
          $graph[ $node_index ]['offers']['description']   = $shared['offer'];
          $graph[ $node_index ]['offers']['price']         = NOAWAY_SEO_PRICE_AMOUNT;
          $graph[ $node_index ]['offers']['priceCurrency'] = NOAWAY_SEO_PRICE_CURRENCY;
        }
      }
      if ( $node['@type'] === 'WebSite' ) {
        $graph[ $node_index ]['inLanguage']  = noaway_i18n_bcp47( $localized['lang'] );
        $graph[ $node_index ]['description'] = $shared['website'];
      }
    }
  }

  // Breadcrumb: pagine singole, oppure landing localizzata servita dal router.
  if ( $localized ) {
    $copy     = noaway_i18n_landing_copy( $localized['family'], $localized['lang'] );
    $shared   = noaway_i18n_schema_shared( $localized['lang'] );
    $page_url = noaway_i18n_landing_url( $localized['family'], $localized['lang'] );
    $graph[]  = array(
      '@type'           => 'BreadcrumbList',
      'itemListElement' => array(
        array(
          '@type'    => 'ListItem',
          'position' => 1,
          'name'     => $shared['home'],
          'item'     => $home,
        ),
        array(
          '@type'    => 'ListItem',
          'position' => 2,
          'name'     => isset( $copy['breadcrumb'] ) ? $copy['breadcrumb'] : '',
          'item'     => $page_url,
        ),
      ),
    );
  } elseif ( is_singular() && ! is_front_page() ) {
    $page_url = noaway_seo_canonical_url( get_permalink() );
    $graph[]  = array(
      '@type'           => 'BreadcrumbList',
      'itemListElement' => array(
        array(
          '@type'    => 'ListItem',
          'position' => 1,
          'name'     => 'Home',
          'item'     => $home,
        ),
        array(
          '@type'    => 'ListItem',
          'position' => 2,
          'name'     => get_the_title(),
          'item'     => $page_url,
        ),
      ),
    );
  }

  // Landing: Article + FAQ + HowTo — JSON-LD centralizzato (niente duplicati nel template).
  if ( ( is_singular() && $template ) || $localized ) {
    $copy = null;
    if ( $localized ) {
      $canonical       = noaway_i18n_landing_url( $localized['family'], $localized['lang'] );
      $schema_template = $localized['family'] === 'teams' ? 'page-keep-teams-active.php' : 'page-keep-slack-active.php';
      $copy            = noaway_i18n_landing_copy( $localized['family'], $localized['lang'] );
    } else {
      $canonical       = noaway_seo_canonical_url( get_permalink() );
      $schema_template = $template;
    }

    $article = noaway_seo_article_schema_for_template( $schema_template, $canonical, $home );
    if ( $article && is_array( $copy ) ) {
      $article['headline']    = $copy['article_headline'];
      $article['description'] = $copy['article_description'];
      $article['inLanguage']  = noaway_i18n_bcp47( $localized['lang'] );
    }
    if ( $article ) {
      $graph[] = $article;
    }

    $faq_items = noaway_seo_landing_faq_items( $schema_template );
    if ( is_array( $copy ) && $localized['family'] === 'slack' && ! empty( $copy['faqs'] ) ) {
      $faq_items = $copy['faqs'];
    }
    if ( is_array( $copy ) && $localized['family'] === 'teams' ) {
      // FAQPage is printed in the Teams template, next to the visible questions.
      $faq_items = null;
    }
    if ( $faq_items ) {
      $main_entity_ld = array();
      foreach ( $faq_items as $item ) {
        $main_entity_ld[] = array(
          '@type'          => 'Question',
          'name'           => $item['name'],
          'acceptedAnswer' => array(
            '@type' => 'Answer',
            'text'  => $item['text'],
          ),
        );
      }
      $faq_node = array(
        '@type'      => 'FAQPage',
        'mainEntity' => $main_entity_ld,
      );
      if ( is_array( $copy ) ) {
        $faq_node['inLanguage'] = noaway_i18n_bcp47( $localized['lang'] );
      }
      $graph[] = $faq_node;
    }

    $howto = noaway_seo_howto_schema( $schema_template, $download_url );
    if ( $howto && is_array( $copy ) ) {
      $steps                 = noaway_i18n_howto_common( $localized['lang'] );
      $howto['name']         = $copy['howto_name'];
      $howto['description']  = $copy['howto_description'];
      $howto['inLanguage']   = noaway_i18n_bcp47( $localized['lang'] );
      $howto['step'][0]['name'] = $steps['s1_name'];
      $howto['step'][0]['text'] = $steps['s1_text'] . $download_url;
      $howto['step'][1]['name'] = $steps['s2_name'];
      $howto['step'][1]['text'] = $steps['s2_text'];
      $howto['step'][2]['name'] = $steps['s3_name'];
      $howto['step'][2]['text'] = $copy['howto_step3'];
    }
    if ( $howto ) {
      $graph[] = $howto;
    }

    $webpage_extra = noaway_seo_webpage_supplemental_schema( $schema_template, $canonical, $home );
    if ( $webpage_extra ) {
      $graph[] = $webpage_extra;
    }
  }

  $schema = array(
    '@context' => 'https://schema.org',
    '@graph'   => $graph,
  );
  echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'noaway_seo_structured_data', 5 );
