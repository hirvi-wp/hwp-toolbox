<?php

namespace HWP\Toolbox\Plugin;

use WPBMap;

class VcUtils
{
    /**
     * Whitelist only certain modules.
     * Other modules will be disabled
     *
     * @param array $whitelist
     */
    public function enableModules($whitelist = [])
    {
        add_action('wp_loaded', function() use ($whitelist) {
            $modules = array_keys(WPBMap::getShortCodes());

            foreach ($modules as $module) {
                if ( ! in_array($module, $whitelist)) {
                    vc_remove_element($module);
                }
            }
        });
    }

    /**
     * Disables VC CSS
     */
    public function deregisterFrontendStyles()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_style('js_composer_front');
        });
    }

    /**
     * Disables frontend editor
     */
    public function disableFrontend()
    {
        vc_disable_frontend();
    }

}