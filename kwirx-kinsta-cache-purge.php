<?php
/**
 * Plugin Name: Kwirx - Kinsta Cache Auto-Purge
 * Description: Clears Kinsta cache every 4 hours using WP-CLI
 * Version: 1.2
 * Author: Kwirx Creative
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Schedule the cron job on plugin activation
 */
register_activation_hook(__FILE__, 'schedule_kinsta_cache_purge');

/**
 * Schedules the cache purge event if not already scheduled
 *
 * @return void
 */
function schedule_kinsta_cache_purge() {
    if (!wp_next_scheduled('kinsta_cache_purge_event')) {
        wp_schedule_event(time(), 'four_hourly', 'kinsta_cache_purge_event');
    }
}

/**
 * Add custom cron schedule
 */
add_filter('cron_schedules', 'add_four_hourly_cron_schedule');

/**
 * Adds a custom 'four_hourly' cron schedule
 *
 * @param array $schedules Existing cron schedules
 * @return array Modified cron schedules
 */
function add_four_hourly_cron_schedule($schedules) {
    $schedules['four_hourly'] = array(
        'interval' => 4 * HOUR_IN_SECONDS,
        'display'  => __('Every 4 hours'),
    );
    return $schedules;
}

/**
 * Hook our function to the cron event
 */
add_action('kinsta_cache_purge_event', 'purge_kinsta_cache');

/**
 * Purges Kinsta cache using WP-CLI command
 *
 * This function attempts to run the cache purge command either via WP-CLI
 * if available, or through exec(). It logs the result of the operation.
 *
 * @return void
 */
function purge_kinsta_cache() {
    // Check if WP-CLI is available
    if (defined('WP_CLI') && WP_CLI) {
        // Run the command via WP-CLI
        WP_CLI::runcommand('kinsta cache purge --all');
        error_log('Kinsta cache purged successfully via WP-CLI at ' . current_time('mysql'));
    } else {
        // Fallback to exec() if WP-CLI is not available
        $output = array();
        $return_var = 0;
        exec('wp kinsta cache purge --all', $output, $return_var);
        
        if ($return_var !== 0) {
            // Log error if the command failed
            error_log('Kinsta cache purge failed: ' . implode("\n", $output));
        } else {
            // Log success message
            error_log('Kinsta cache purged successfully via exec() at ' . current_time('mysql'));
        }
    }
}

/**
 * Deactivation hook to remove the scheduled event
 */
register_deactivation_hook(__FILE__, 'deactivate_kinsta_cache_purge');

/**
 * Removes the scheduled cache purge event
 *
 * @return void
 */
function deactivate_kinsta_cache_purge() {
    $timestamp = wp_next_scheduled('kinsta_cache_purge_event');
    wp_unschedule_event($timestamp, 'kinsta_cache_purge_event');
}
