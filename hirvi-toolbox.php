<?php
/**
 * Plugin Name: HWP - Toolbox
 * Plugin URI: https://hirvi.no
 * Description: A toolbox for WP development. Required by all our plugins and themes.
 * Author: Chris Magnussen
 * Author URI: https://hirvi.no/team/chris
 * Version: 0.1
 * Text Domain: vc-utils
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load dependencies
 */
$dependencies = [
    'TGMPA' => plugin_path() . '/dependencies/class-tgm-plugin-activation.php',
];

foreach($dependencies as $name => $dependency) {
    if (file_exists($dependency)) {
        require_once $dependency;
    }
}

