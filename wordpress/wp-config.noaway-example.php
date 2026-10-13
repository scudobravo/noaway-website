<?php
/**
 * NoAway — constants to copy into wp-config.php (production, e.g. noaway.app).
 * Paste the block below in wp-config.php before "That's all, stop editing!".
 */
// --- NoAway block start ---
// Canonical domain (must match server-level redirect target).
define( 'WP_HOME', 'https://www.noaway.app' );
define( 'WP_SITEURL', 'https://www.noaway.app' );

// Checkout: License Server (creates Stripe Checkout Session)
define( 'NOAWAY_STRIPE_CHECKOUT_URL', 'https://license.noaway.app/create-checkout-session' );

// License API base (Electron app + theme helpers)
define( 'NOAWAY_LICENSE_API_URL', 'https://license.noaway.app' );

// Protected downloads: same secret as license-server .env DOWNLOAD_SECRET
define( 'NOAWAY_DOWNLOAD_SECRET', 'GENERATE_A_LONG_RANDOM_STRING' );

// Absolute path to installers for api/download.php (signed post-purchase links only).
// Prefer a path OUTSIDE the web root so .dmg/.exe are not publicly URL-guessable.
// Example: /home/YOUR_USER/noaway-releases
// If you must keep files under uploads/, deploy the Deny-all .htaccess from
// wordpress/wp-content/uploads/noaway-releases/.htaccess into that folder.
define( 'NOAWAY_RELEASES_PATH', '/home/YOUR_USER/noaway-releases' );

// Filenames must match the files you place in NOAWAY_RELEASES_PATH.
// api/download.php maps signed links: mac_universal / legacy "mac" → universal DMG; mac_arm64 → arm64 DMG.
define( 'NOAWAY_RELEASE_MACOS', 'NoAway-1.0.6-universal.dmg' );
define( 'NOAWAY_RELEASE_MACOS_ARM64', 'NoAway-1.0.6-arm64.dmg' );
define( 'NOAWAY_RELEASE_WINDOWS', 'NoAway Setup 1.0.6.exe' );

// Optional: if you prefer a separate constant name for universal (otherwise NOAWAY_RELEASE_MACOS is used).
// define( 'NOAWAY_RELEASE_MACOS_UNIVERSAL', 'NoAway-1.0.6-universal.dmg' );

// Do NOT define NOAWAY_MAC_*_DMG or NOAWAY_WINDOWS_SETUP_EXE for public theme links.
// The Downloads page always sends visitors to checkout; installers are only via
// thank-you page + license email (api/download.php).

// Optional: contact form reCAPTCHA
// define( 'NOAWAY_RECAPTCHA_SITE_KEY', '...' );
// define( 'NOAWAY_RECAPTCHA_SECRET_KEY', '...' );
// --- NoAway block end ---
