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
  $default_title = 'NoAway – Stay Active on Teams and Slack. Never appear Away again.';
  $default_desc  = 'Keep your computer active automatically so your status stays Available during downloads, builds, and long tasks. Works with Microsoft Teams, Slack, Zoom.';

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
    $data['title']       = 'NoAway – Stop Teams Away, Keep Icon Green | Mac & Windows';
    $data['description'] = 'NoAway keeps your computer active so Teams and Slack never show Away. One click from the tray—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
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
  if ( $template === 'page-features.php' ) {
    $data['title']       = 'Features | NoAway – Lightweight App to Keep Teams & Slack Active';
    $data['description'] = 'NoAway features: lightweight tray app, Mac & Windows, minimal resources, simple setup, automatic startup, scheduled wake. Built to stay out of your way.';
  } elseif ( $template === 'page-how-it-works.php' ) {
    $data['title']       = 'How NoAway Works | Install, Enable, Stay Available';
    $data['description'] = 'Install NoAway once, enable Keep Active from the tray, and your computer stays active automatically. No complicated setup. Works with Teams, Slack, Zoom.';
  } elseif ( $template === 'page-keep-teams-active.php' ) {
    $data['title']       = 'Stop Teams Showing Away After 5 Minutes – Keep Status Green | NoAway';
    $data['description'] = 'Teams turns Away after about 5 minutes of no keyboard or mouse input. NoAway keeps your status green—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
  } elseif ( $template === 'page-teams-away-status.php' ) {
    $data['title']       = 'Why Does Teams Show Away? (After 5 Min) & How to Stop It | NoAway';
    $data['description'] = 'Teams shows Away after about 5 minutes of no input. There is no always-available setting; NoAway stops it—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
  } elseif ( $template === 'page-keep-slack-active.php' ) {
    $data['title']       = 'How to Keep Slack Active (Stop Away After 30 Min) – Mac & Windows | NoAway';
    $data['description'] = 'Slack desktop goes Away after about 30 minutes of idle. See timing by platform, then keep Slack active on Mac & Windows with NoAway—no mouse jiggling.';
  } elseif ( $template === 'page-prevent-computer-sleep.php' ) {
    $data['title']       = 'Prevent Computer Sleep on Mac & Windows (Without Admin Rights) | NoAway';
    $data['description'] = 'OS sleep settings keep the machine on but do not stop idle status. Prevent sleep without admin rights with NoAway—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
  } elseif ( $template === 'page-is-noaway-safe.php' ) {
    $data['title']       = 'Is NoAway Safe? Legit, Privacy & Company PCs | NoAway';
    $data['description'] = 'NoAway runs locally: no keylogging, no screen capture, no Teams/Slack access. See admin rights, IT policy, and support—one-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', Mac & Windows.';
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
    $data['description'] = 'Download NoAway for macOS or Windows. One-time purchase, €' . NOAWAY_SEO_PRICE_AMOUNT . ' launch price. Keeps Teams, Slack, and Zoom status green automatically. No subscription.';
  } elseif ( $template === 'page-thank-you.php' ) {
    $data['title']       = 'Thank You – Your NoAway Download | Purchase Confirmed';
    $data['description'] = 'Your NoAway purchase is confirmed. Download NoAway for macOS or Windows. One-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', lifetime updates. Need help? Visit Help or Contact.';
  } elseif ( $template === 'page-help.php' ) {
    $data['title']       = 'Help Center | NoAway – Installation, Activation, Troubleshooting';
    $data['description'] = 'Find quick answers about installing, activating, and using NoAway. Installation guide for macOS and Windows, license activation, and troubleshooting.';
  } elseif ( $template === 'page-contatti.php' ) {
    $data['title']       = 'Contact NoAway | Support & Help';
    $data['description'] = 'Get in touch with NoAway support. Questions about installation, licensing, or technical support? We\'re happy to help.';
  } elseif ( $template === 'page-faq.php' ) {
    $data['title']       = 'FAQ – How NoAway Keeps Teams Active, Safety & Pricing | NoAway';
    $data['description'] = 'Common questions about NoAway: how it keeps Teams and Slack active, whether it\'s detectable by IT, how it handles privacy, pricing, and why alternatives like mouse jigglers don\'t work.';
  } elseif ( $template === 'page-sitemap.php' ) {
    $data['title']       = 'Sitemap | NoAway';
    $data['description'] = 'Navigate all pages of the NoAway website: Features, How it works, Download, Help, Contacts, Privacy, Terms.';
  } elseif ( $template === 'page-privacy-policy.php' ) {
    $data['title']       = 'Privacy Policy | NoAway';
    $data['description'] = 'NoAway privacy policy: what information we collect, how we use it, and how we protect your data.';
  } elseif ( $template === 'page-terms-of-service.php' ) {
    $data['title']       = 'Terms of Service | NoAway';
    $data['description'] = 'NoAway terms of service: license, use, and legal terms for the NoAway application.';
  }

  if ( function_exists( 'noaway_i18n_current_landing' ) ) {
    $landing = noaway_i18n_current_landing();
    if ( is_array( $landing ) ) {
      $data['og_locale']   = noaway_i18n_og_locale( $landing['lang'] );
      $data['in_language'] = noaway_i18n_bcp47( $landing['lang'] );
      if ( $landing['lang'] !== 'en' ) {
        $copy = noaway_i18n_landing_copy( $landing['family'], $landing['lang'] );
        if ( ! empty( $copy['seo_title'] ) ) {
          $data['title'] = $copy['seo_title'];
        }
        if ( ! empty( $copy['seo_description'] ) ) {
          $data['description'] = $copy['seo_description'];
        }
        $localized_url = noaway_i18n_landing_url( $landing['family'], $landing['lang'] );
        if ( is_string( $localized_url ) && $localized_url !== '' ) {
          $data['canonical']        = $localized_url;
          $data['canonical_branch'] = 'permalink';
        }
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
    array( 'name' => 'Will I always appear Active on Teams or Slack?', 'text' => 'NoAway prevents your computer from entering an idle state while it is running. This helps your system remain active during long tasks such as downloads, builds, or presentations.' ),
    array( 'name' => 'Is using NoAway safe?', 'text' => 'Yes. NoAway is designed as a simple desktop utility that runs locally on your computer. It does not access your files, read messages, or track personal data. Its only function is preventing the system from entering an idle state while enabled. For a full breakdown (admin rights, company PCs, what it does not do), see the Is NoAway safe page at /is-noaway-safe/.' ),
    array( 'name' => 'Does NoAway slow down my computer?', 'text' => 'No. The application runs quietly in the background and is designed to use minimal system resources.' ),
    array( 'name' => 'Can I start NoAway automatically?', 'text' => 'Yes. NoAway can be configured to start automatically when your computer boots so it is ready whenever you need it.' ),
    array( 'name' => 'Do I need an internet connection?', 'text' => 'No. NoAway works locally on your device. An internet connection is only required for downloading the app or activating your license.' ),
    array( 'name' => 'Is NoAway a subscription?', 'text' => 'No. NoAway is a one-time purchase with lifetime access and future updates.' ),
    array( 'name' => 'Will my boss or IT department know I\'m using this?', 'text' => 'NoAway runs locally on your computer and does not send usage data, logs, or activity information to external servers. It simply prevents the system from entering an idle state while it is enabled. From the perspective of your operating system, your computer remains active during that time. However, every workplace has its own policies regarding software usage, so it\'s always a good idea to follow your company\'s guidelines.' ),
    array( 'name' => 'Is NoAway detectable by Microsoft Teams?', 'text' => 'NoAway does not interact with Microsoft Teams directly. Instead, it prevents your computer from entering an idle state at the system level. Applications that rely on system activity signals may therefore continue to show an active status while the system is active.' ),
    array( 'name' => 'Does NoAway interact with Microsoft Teams directly?', 'text' => 'No. NoAway does not modify or control Microsoft Teams. It simply keeps the operating system active while it runs, which may help prevent applications from detecting inactivity during long-running tasks.' ),
    array( 'name' => 'Does NoAway collect any personal data?', 'text' => 'No. NoAway does not access your files, messages, or personal information. The application runs locally on your device and does not monitor your activity.' ),
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
    array( 'name' => 'How many minutes until Teams turns yellow?', 'text' => 'Microsoft Teams typically turns your status to Away (yellow) after about 5 minutes of no keyboard or mouse input. To keep the Teams icon green, use an app like NoAway that keeps your system active so your status stays green (Available).' ),
    array( 'name' => 'How to keep Teams status active hack?', 'text' => 'So-called "hacks" like moving the mouse or running scripts are unreliable and can break after updates. NoAway is a proper solution: it runs in the tray, keeps your system active, and works consistently with Teams without hacks.' ),
    array( 'name' => 'How do I stop my team from turning yellow?', 'text' => 'If you mean your own status in Microsoft Teams: Teams turns status yellow (Away) after about 5 minutes of inactivity. NoAway keeps your computer active so your status stays green (Available) during long tasks.' ),
    array( 'name' => 'How to stay online on Teams without moving the mouse?', 'text' => 'NoAway simulates activity at the system level so you don\'t have to move the mouse or touch the keyboard. Just enable it from the tray and your status stays Available—no wiggling or scripts needed. It’s an app that keeps Teams active so you can stay active on Microsoft Teams without manual tricks.' ),
    // Keyword "app that keeps teams active" in answer.
    array( 'name' => 'Forced to use Teams, how to avoid being \'away\'?', 'text' => 'Many workers are required to use Teams; appearing Away during long tasks can be misunderstood. Use an app that keeps Teams active, like NoAway: it keeps your computer active so your status stays Available and the Teams icon stays green during builds, downloads, or focused work—no mouse wiggling needed.' ),
    // New FAQ for query "how to keep teams icon green" (distinct from "Teams turns yellow").
    array( 'name' => 'How to keep the Teams icon green?', 'text' => 'The Teams icon turns green (Available) when Microsoft Teams detects system activity. To keep the Teams icon green, keep your computer active at the system level. NoAway is an app that keeps Teams active by preventing idle—one click and your icon stays green during long tasks.' ),
    // Troubleshooting: what to do if Teams still shows Away
    array( 'name' => 'What should I do if Teams still shows Away?', 'text' => 'Make sure NoAway is running and Keep Active is enabled. Use the latest version of NoAway (updates improve timing so Teams does not go Away after a few minutes). After updating, use "Restart Activity Engine" from the tray menu. Check "Open Logs" in the menu: if you see "simulated" lines every few minutes, the app is working; if you see errors, contact support. On Windows, try running NoAway as Administrator once and ensure your antivirus is not blocking it.' ),
  );
  return apply_filters( 'noaway_faq_schema_entities', $entities );
}

/**
 * FAQ presenti in front-page.php (sezione FAQ homepage). Testo allineato al contenuto visibile per FAQPage.
 * Separato da noaway_seo_faq_schema_entities() perché la pagina /faq/ ha elenco più ampio.
 */
function noaway_seo_front_page_faq_schema_entities() {
  $entities = array(
    array(
      'name' => 'How do I stop Microsoft Teams from showing away?',
      'text' => 'Microsoft Teams switches to Away when it detects no keyboard or mouse activity. NoAway keeps your computer active automatically so your status stays Available during downloads, builds, or deep work—no need to move the mouse or use unreliable tricks.',
    ),
    array(
      'name' => 'How to keep Teams stay active? Is there an app that keeps Teams active?',
      'text' => 'Use an app that keeps Teams active, like NoAway: it simulates natural activity so your system never goes idle. One click and your Teams status stays Available during long tasks, builds, or downloads. It’s a simple way to stay active on Microsoft Teams without mouse wiggling.',
    ),
    array(
      'name' => 'How to keep the Teams icon green?',
      'text' => 'Teams turns your icon yellow (Away) after about 5 minutes with no keyboard or mouse activity. To keep the Teams icon green, keep your computer active at the system level. NoAway does this automatically—one click and your status stays Available. The Mac and Windows steps are in the keep Teams active guide.',
    ),
    array(
      'name' => 'How many minutes until Teams turns yellow?',
      'text' => 'Microsoft Teams typically turns your status to Away (yellow) after about 5 minutes of no keyboard or mouse input. NoAway prevents this by keeping your system active so your status stays green (Available).',
    ),
    array(
      'name' => 'Will I always appear Active on Teams or Slack?',
      'text' => 'Yes. NoAway simulates natural activity so your computer never goes idle. As long as NoAway is running, your status will remain Available on apps like Microsoft Teams or Slack. No more stress about suddenly appearing Away during work hours.',
    ),
    array(
      'name' => 'Is using NoAway safe?',
      'text' => 'Yes. NoAway is a simple desktop utility that runs locally. It does not access your files, read messages, or track personal data—it only prevents the system from going idle while enabled. More detail is on the Is NoAway safe page (/is-noaway-safe/).',
    ),
    array(
      'name' => 'Does NoAway slow down my computer?',
      'text' => 'Not at all. NoAway is extremely lightweight and uses almost no CPU or memory.',
    ),
    array(
      'name' => 'Will anyone know I\'m using NoAway?',
      'text' => 'NoAway runs locally on your computer and does not collect or transmit activity data. It simply keeps your computer from becoming idle during long tasks such as downloads, builds, or presentations.',
    ),
    array(
      'name' => 'Do I need to keep the app open?',
      'text' => 'No. NoAway runs quietly in the background and can start automatically when your computer boots.',
    ),
    array(
      'name' => 'Is this a subscription?',
      'text' => 'No. NoAway is a one-time purchase. You pay once and receive lifetime access, including future updates.',
    ),
  );
  return apply_filters( 'noaway_front_page_faq_schema_entities', $entities );
}

/**
 * Versione app/tema per SoftwareApplication JSON-LD.
 */
function noaway_seo_theme_version_for_schema() {
  $v = wp_get_theme()->get( 'Version' );
  return $v ? $v : '1.1.0';
}

/**
 * FAQ JSON-LD per landing specifiche — allineate al contenuto visibile.
 *
 * @return array<int, array{name:string,text:string}>|null
 */
function noaway_seo_landing_faq_items( $template_slug ) {
  $map = array(
    'page-teams-away-status.php' => array(
      array(
        'name' => 'How long before Teams shows Away?',
        'text' => 'Microsoft Teams switches your status to Away after approximately 5 minutes of keyboard and mouse inactivity. This cannot be changed in Teams settings.',
      ),
      array(
        'name' => 'Why does Teams show Away when I am still working?',
        'text' => 'Teams does not ask if you are at your desk. It reads keyboard and mouse activity from the operating system. Reading, a long call, or a build with no input looks idle, so the status turns Away.',
      ),
      array(
        'name' => 'Can Teams be set to stay Available permanently?',
        'text' => 'No. Teams has no setting that forces Available. It overwrites a manual status when it detects inactivity. How to keep the status Available is covered in the keep Teams active guide.',
      ),
    ),
    'page-keep-slack-active.php' => array(
      array(
        'name' => 'How long before Slack shows Away?',
        'text' => 'On the Slack desktop app, Slack marks you as Away after approximately 30 minutes of no keyboard or mouse activity. Browser and mobile clients follow different presence rules and are not tied to that same desktop idle window.',
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
        'text' => 'On desktop, Slack keeps you Active until the idle window is reached—about 30 minutes without keyboard or mouse input. There is no setting that permanently extends that timer.',
      ),
      array(
        'name' => 'When does Slack show inactive or Away?',
        'text' => 'Slack shows Away when it stops seeing recent user activity on that client. On desktop that is typically after about 30 minutes without input; web and mobile can change under different conditions.',
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
        'text' => 'Because Teams treats system idle as Away. When the computer sleeps or sits idle with no input, Teams changes your status; keeping the system active also keeps Teams and Slack Available.',
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
        'text' => 'Keep Active runs locally and does not stream your work activity. License activation and downloading the app require a network connection. See the Privacy Policy for what is and is not collected.',
      ),
      array(
        'name' => 'Do you offer refunds? How do I get support?',
        'text' => 'No. All sales are final; we do not offer refunds. For purchase or activation help, use the contact page or Help Center with your order email. License terms are in the Terms of Service.',
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
      'description' => 'On the Slack desktop app, Away starts after about 30 minutes of inactivity. Here is how to keep your Slack status active automatically on Mac and Windows.',
      'totalTime'   => 'PT2M',
      'step3_text'  => 'Toggle Enable. NoAway keeps your system active so Slack continues to show your status as Active.',
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
  $base = array(
    '@type'            => 'Article',
    'datePublished'    => '2025-01-01',
    'dateModified'     => gmdate( 'Y-m-d' ),
    'publisher'        => $pub,
    'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => $canonical_url ),
  );
  $by_template = array(
    'page-teams-away-status.php' => array(
      'headline'    => 'Why Teams Shows Away, and After How Long',
      'description' => 'Teams shows Away when it sees no keyboard or mouse input, usually after about 5 minutes. There is no always-available setting. This page explains how presence detection works.',
    ),
    'page-keep-slack-active.php' => array(
      'headline'    => 'How to Keep Slack Active and Prevent Away Status',
      'description' => 'On the Slack desktop app, Away starts after about 30 minutes of no keyboard or mouse activity. Browser and mobile differ. Keep the computer active at the OS level—with NoAway—so Slack stays Active on Mac and Windows.',
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
    'page-help.php' => array(
      'headline'    => 'NoAway Help Center — Installation, Activation, Troubleshooting',
      'description' => 'Find quick answers about installing, activating, and using NoAway. Installation guide for macOS and Windows, license activation, and troubleshooting.',
    ),
    'page-downloads.php' => array(
      'headline'    => 'Download NoAway for macOS and Windows',
      'description' => 'Download NoAway for macOS or Windows. One-time purchase, €' . NOAWAY_SEO_PRICE_AMOUNT . ' launch price. Keeps Teams, Slack, and Zoom status green automatically. No subscription.',
    ),
    'page-download.php' => array(
      'headline'    => 'Download NoAway for Mac',
      'description' => 'Download NoAway for macOS or Windows. One-time purchase, €' . NOAWAY_SEO_PRICE_AMOUNT . ' launch price. Keeps Teams, Slack, and Zoom status green automatically. No subscription.',
    ),
    'page-thank-you.php' => array(
      'headline'    => 'Thank You — Your NoAway Purchase Is Confirmed',
      'description' => 'Your NoAway purchase is confirmed. Download NoAway for macOS or Windows. One-time €' . NOAWAY_SEO_PRICE_AMOUNT . ', lifetime updates.',
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
    'description'         => 'NoAway keeps your computer active so Microsoft Teams, Slack, and Zoom never show you as Away. One-time purchase (EUR) for Mac and Windows.',
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
      'description'   => 'One-time purchase (EUR), lifetime updates. Launch price.',
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
      'sameAs'       => noaway_seo_same_as_urls(),
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
      'description' => 'NoAway keeps your computer active so Teams and Slack stay Available. Download for Mac and Windows; one-time purchase (€' . NOAWAY_SEO_PRICE_AMOUNT . ').',
      'inLanguage'  => 'en',
      'publisher'   => array( '@type' => 'Organization', 'name' => 'NoAway', 'url' => $home ),
    ),
  );

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
