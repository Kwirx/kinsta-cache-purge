# Kwirx - Kinsta Cache Auto-Purge

## Description
Kwirx - Kinsta Cache Auto-Purge is a WordPress Must-Use (MU) plugin that automatically clears the Kinsta cache every 4 hours using WP-CLI. This plugin helps maintain your site's performance by ensuring that the cache is regularly refreshed.

## Disclaimer
This tool is developed by Kwirx Creative and is not affiliated with, endorsed, or sponsored by Kinsta. It is an independent project designed to work with Kinsta-hosted WordPress sites.

## Features
- Automatically purges Kinsta cache every 4 hours
- Uses WP-CLI to execute the cache purge command
- Runs as a WordPress cron job
- Easy to install and configure

## Installation
1. Download the plugin file.
2. Place the plugin file in your WordPress site's `wp-content/mu-plugins/` directory.
3. The plugin will be automatically activated.

## Requirements
- WordPress site hosted on Kinsta
- WP-CLI must be installed and configured on your Kinsta environment

## How It Works
The plugin schedules a WordPress cron job that runs every 4 hours. When the cron job executes, it runs the following WP-CLI command:

```
wp kinsta cache purge --all
```

This command purges all cache on your Kinsta-hosted WordPress site.

## Customization
If you need to change the frequency of the cache purge, you can modify the `add_four_hourly_cron_schedule` function in the plugin code.

## Troubleshooting
If the cache is not being purged as expected:
1. Ensure that WordPress cron jobs are running correctly on your site.
2. Check your WordPress error log for any error messages related to the plugin.
3. Verify that WP-CLI is properly installed and configured on your Kinsta environment.

## Support
For any issues or questions, please contact Kwirx Creative or open an issue in the plugin's repository.

## License
This plugin is released under the GPL v2 or later license.

## Author
Kwirx Creative

## Version
1.2