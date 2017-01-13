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
        return plugin_dir_path(__FILE__) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if ( ! function_exists('hwp_die')) {
    /**
     * Get the path to the plugin folder.
     *
     * @param  mixed $data
     * @return string
     */
    function hwp_die($data = '')
    {
        if (is_array($data)) {
            echo '<pre>';
            wp_die(var_dump($data));
        }

        wp_die(data);
    }
}