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

// Absolute path to installers for api/download.php (signed email links).
// Can be the same folder as public uploads below so you upload each file once.
// Example: .../public_html/wp-content/uploads/noaway-releases
define( 'NOAWAY_RELEASES_PATH', '/home/YOUR_USER/public_html/wp-content/uploads/noaway-releases' );

// Filenames must match the files you upload to NOAWAY_RELEASES_PATH.
// api/download.php maps signed links: mac_universal / legacy "mac" → universal DMG; mac_arm64 → arm64 DMG.
define( 'NOAWAY_RELEASE_MACOS', 'NoAway-1.0.6-universal.dmg' );
define( 'NOAWAY_RELEASE_MACOS_ARM64', 'NoAway-1.0.6-arm64.dmg' );
define( 'NOAWAY_RELEASE_WINDOWS', 'NoAway Setup 1.0.6.exe' );

// Optional: if you prefer a separate constant name for universal (otherwise NOAWAY_RELEASE_MACOS is used).
// define( 'NOAWAY_RELEASE_MACOS_UNIVERSAL', 'NoAway-1.0.6-universal.dmg' );

// Public URLs for the theme Downloads page (anonymous visitors). NOT used by license emails.
// Put the DMGs in: wp-content/uploads/noaway-releases/ (same filenames as above).
// Use https + the SAME host as Settings → General (e.g. www if your site uses www).
// define( 'NOAWAY_MAC_ARM64_DMG', 'https://www.noaway.app/wp-content/uploads/noaway-releases/NoAway-1.0.6-arm64.dmg' );
// define( 'NOAWAY_MAC_UNIVERSAL_DMG', 'https://www.noaway.app/wp-content/uploads/noaway-releases/NoAway-1.0.6-universal.dmg' );

// Optional: contact form reCAPTCHA
// define( 'NOAWAY_RECAPTCHA_SITE_KEY', '...' );
// define( 'NOAWAY_RECAPTCHA_SECRET_KEY', '...' );
// --- NoAway block end ---
