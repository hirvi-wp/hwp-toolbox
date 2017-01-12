<?php

if ( ! function_exists('plugin_path')) {
    /**
     * Get the path to the plugin folder.
     *
     * @param  string $path
     * @return string
     */
    function plugin_path($path = '')
    {
        return dirname(plugin_dir_path(__FILE__)) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}