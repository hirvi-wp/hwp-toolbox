<?php
/**
 *
 */


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

