<?php
/**
 * NoAway Analytics – Dashboard page.
 * Mostra statistiche da noaway_licenses (e noaway_activations se necessario).
 * Solo per amministratori. Dati in cache 5 minuti (transients).
 */

if (!defined('ABSPATH') || !current_user_can('manage_options')) {
    return;
}

global $wpdb;
$prefix   = $wpdb->prefix;
$licenses = $prefix . 'noaway_licenses';
$cache_ttl = 5 * MINUTE_IN_SECONDS;

// Helper: get cached or run query and cache
function noaway_analytics_cached($key, $callback) {
    $full_key = 'noaway_analytics_' . $key;
    $cached   = get_transient($full_key);
    if ($cached !== false) {
        return $cached;
    }
    $data = $callback();
    set_transient($full_key, $data, 5 * MINUTE_IN_SECONDS);
    return $data;
}

// --- Main metrics (Part 3) ---
$licenses_sold = noaway_analytics_cached('licenses_sold', function () use ($wpdb, $licenses) {
    return (int) $wpdb->get_var("SELECT COUNT(*) FROM `{$licenses}`");
});

$active_users_7d = noaway_analytics_cached('active_7d', function () use ($wpdb, $licenses) {
    return (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM `{$licenses}` WHERE last_validation > NOW() - INTERVAL 7 DAY"
    );
});

$total_active_hours = noaway_analytics_cached('total_hours', function () use ($wpdb, $licenses) {
    $sum = $wpdb->get_var("SELECT SUM(total_active_seconds)/3600 FROM `{$licenses}`");
    return $sum === null ? 0.0 : (float) $sum;
});

$avg_daily_hours = noaway_analytics_cached('avg_daily_hours', function () use ($wpdb, $licenses) {
    $avg = $wpdb->get_var("SELECT AVG(last_active_seconds)/3600 FROM `{$licenses}`");
    return $avg === null ? 0.0 : (float) $avg;
});

// --- Platform distribution (Part 4) ---
$platform_dist = noaway_analytics_cached('platform_dist', function () use ($wpdb, $licenses) {
    return $wpdb->get_results(
        "SELECT last_platform AS platform, COUNT(*) AS users FROM `{$licenses}` GROUP BY last_platform",
        ARRAY_A
    );
});

// --- App detection (Part 5) ---
$app_teams = noaway_analytics_cached('app_teams', function () use ($wpdb, $licenses) {
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM `{$licenses}` WHERE last_detected_apps LIKE %s",
        '%teams%'
    ));
});
$app_slack = noaway_analytics_cached('app_slack', function () use ($wpdb, $licenses) {
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM `{$licenses}` WHERE last_detected_apps LIKE %s",
        '%slack%'
    ));
});
$app_zoom = noaway_analytics_cached('app_zoom', function () use ($wpdb, $licenses) {
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM `{$licenses}` WHERE last_detected_apps LIKE %s",
        '%zoom%'
    ));
});

// --- Version distribution (Part 6) ---
$version_dist = noaway_analytics_cached('version_dist', function () use ($wpdb, $licenses) {
    return $wpdb->get_results(
        "SELECT last_version AS version, COUNT(*) AS users FROM `{$licenses}` GROUP BY last_version ORDER BY users DESC",
        ARRAY_A
    );
});

// --- Top users (Part 7) ---
$top_users = noaway_analytics_cached('top_users', function () use ($wpdb, $licenses) {
    return $wpdb->get_results(
        "SELECT license_key, total_active_seconds FROM `{$licenses}` ORDER BY total_active_seconds DESC LIMIT 10",
        ARRAY_A
    );
});

$cta_rows = function_exists( 'noaway_analytics_cta_attribution_rows' )
	? noaway_analytics_cached( 'cta_attr_30d', function () {
		return noaway_analytics_cta_attribution_rows( 30 );
	} )
	: array();

$email_link_totals = function_exists( 'noaway_analytics_email_link_totals' )
	? noaway_analytics_cached( 'email_link_30d', function () {
		return noaway_analytics_email_link_totals( 30 );
	} )
	: array( 'sent' => 0, 'clicks' => 0 );

?>
<div class="wrap noaway-analytics-wrap">
    <h1><?php esc_html_e('NoAway Analytics', 'noaway-analytics'); ?></h1>
    <p class="noaway-analytics-intro"><?php esc_html_e('Usage statistics for the NoAway application. Data is cached for 5 minutes.', 'noaway-analytics'); ?></p>

    <div class="noaway-section">
        <h2><?php esc_html_e( 'Landing attribution (last 30 days)', 'noaway-analytics' ); ?></h2>
        <p class="description" style="margin-top:0;margin-bottom:12px;">
            <?php esc_html_e( 'Buy clicks require analytics cookie consent. Purchases are attributed from the thank-you page using the ref stored at click time (and checkout ?ref= / client_reference_id).', 'noaway-analytics' ); ?>
        </p>
        <table class="noaway-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Page', 'noaway-analytics' ); ?></th>
                    <th><?php esc_html_e( 'Buy clicks', 'noaway-analytics' ); ?></th>
                    <th><?php esc_html_e( 'Purchases', 'noaway-analytics' ); ?></th>
                    <th><?php esc_html_e( 'Conversion rate', 'noaway-analytics' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( ! empty( $cta_rows ) ) {
                    foreach ( $cta_rows as $row ) {
                        echo '<tr>';
                        echo '<td>' . esc_html( $row['page'] ) . '</td>';
                        echo '<td>' . esc_html( (string) $row['clicks'] ) . '</td>';
                        echo '<td>' . esc_html( (string) $row['purchases'] ) . '</td>';
                        echo '<td>' . esc_html( number_format_i18n( (float) $row['conversion'], 1 ) ) . '%</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">' . esc_html__( 'No CTA data yet (or analytics consent not granted by visitors).', 'noaway-analytics' ) . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <p class="description" style="margin-top:12px;">
            <?php
            printf(
                /* translators: 1: emails sent, 2: buy clicks from emailed link */
                esc_html__( 'Mobile email link (last 30 days): %1$s emails sent · %2$s buy clicks from the emailed link (ref=email-link, requires analytics consent).', 'noaway-analytics' ),
                esc_html( (string) (int) $email_link_totals['sent'] ),
                esc_html( (string) (int) $email_link_totals['clicks'] )
            );
            ?>
        </p>
    </div>

XX, 'noaway-analytics'); ?></span>
            <span class="noaway-card-value"><?php echo esc_html((string) $licenses_sold); ?></span>
        </div>
        <div class="noaway-card">
            <span class="noaway-card-label"><?php esc_html_e('Active Users (7 days)', 'noaway-analytics'); ?></span>
            <span class="noaway-card-value"><?php echo esc_html((string) $active_users_7d); ?></span>
        </div>
        <div class="noaway-card">
            <span class="noaway-card-label"><?php esc_html_e('Total Active Hours', 'noaway-analytics'); ?></span>
            <span class="noaway-card-value"><?php echo esc_html(number_format_i18n($total_active_hours, 1)); ?></span>
        </div>
        <div class="noaway-card">
            <span class="noaway-card-label"><?php esc_html_e('Average Daily Active Time (h)', 'noaway-analytics'); ?></span>
            <span class="noaway-card-value"><?php echo esc_html(number_format_i18n($avg_daily_hours, 1)); ?></span>
        </div>
    </div>

    <div class="noaway-analytics-grid">
        <div class="noaway-section">
            <h2><?php esc_html_e('Platform Distribution', 'noaway-analytics'); ?></h2>
            <table class="noaway-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Platform', 'noaway-analytics'); ?></th>
                        <th><?php esc_html_e('Users', 'noaway-analytics'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($platform_dist)) {
                        foreach ($platform_dist as $row) {
                            $platform = $row['platform'] !== null && $row['platform'] !== '' ? $row['platform'] : '—';
                            echo '<tr><td>' . esc_html($platform) . '</td><td>' . esc_html((string) $row['users']) . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">' . esc_html__('No data', 'noaway-analytics') . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="noaway-section">
            <h2><?php esc_html_e('App Detection', 'noaway-analytics'); ?></h2>
            <table class="noaway-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('App', 'noaway-analytics'); ?></th>
                        <th><?php esc_html_e('Users', 'noaway-analytics'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Teams</td><td><?php echo esc_html((string) $app_teams); ?></td></tr>
                    <tr><td>Slack</td><td><?php echo esc_html((string) $app_slack); ?></td></tr>
                    <tr><td>Zoom</td><td><?php echo esc_html((string) $app_zoom); ?></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="noaway-section">
        <h2><?php esc_html_e('App Version Distribution', 'noaway-analytics'); ?></h2>
        <table class="noaway-table">
            <thead>
                <tr>
                    <th><?php esc_html_e('Version', 'noaway-analytics'); ?></th>
                    <th><?php esc_html_e('Users', 'noaway-analytics'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($version_dist)) {
                    foreach ($version_dist as $row) {
                        $ver = $row['version'] !== null && $row['version'] !== '' ? $row['version'] : '—';
                        echo '<tr><td>' . esc_html($ver) . '</td><td>' . esc_html((string) $row['users']) . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">' . esc_html__('No data', 'noaway-analytics') . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="noaway-section">
        <h2><?php esc_html_e('Top Users (by total active time)', 'noaway-analytics'); ?></h2>
        <table class="noaway-table">
            <thead>
                <tr>
                    <th><?php esc_html_e('License Key', 'noaway-analytics'); ?></th>
                    <th><?php esc_html_e('Total Hours', 'noaway-analytics'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($top_users)) {
                    foreach ($top_users as $row) {
                        $hours = isset($row['total_active_seconds']) ? (float) $row['total_active_seconds'] / 3600 : 0;
                        echo '<tr><td>' . esc_html($row['license_key']) . '</td><td>' . esc_html(number_format_i18n($hours, 1)) . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">' . esc_html__('No data', 'noaway-analytics') . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
