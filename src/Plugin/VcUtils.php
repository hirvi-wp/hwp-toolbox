<?php

namespace HWP\Toolbox\Plugin;

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
        if ( ! class_exists('\\WPBMap')) {
            return;
        }

        add_action('wp_loaded', function () use ($whitelist) {
            $modules = array_keys(\WPBMap::getShortCodes());

            foreach ($modules as $module) {
                if ( ! in_array($module, $whitelist)) {
                    vc_remove_element($module);
                }
            }
        });
    }

    /**
     * Disable certain params in module
     *
     * @param string $module
     * @param array|string $params
     */
    public function disableParams($module, $params)
    {
        if ( ! is_array($params)) {
            vc_remove_param($module, $params);
            return;
        }

        foreach($params as $param) {
            vc_remove_param($module, $param);
        }
    }

    /**
     * Enable only selected params
     *
     * @param string $module
     * @param array $params
     */
    public function enableParams($module, array $params)
    {
        add_action('vc_after_init', function() use ($module, $params) {
            $sc = \WPBMap::getShortCode($module);
            foreach ($sc['params'] as $param) {
                if ( ! in_array($param['param_name'], $params)) {
                    $this->disableParams($module, $param['param_name']);
                }
            }
        });
    }

    /**
     * Get all params for module
     *
     * @param string $module
     */
    public function getModuleParams($module)
    {
        add_action('vc_after_init', function() use ($module) {
            $sc = \WPBMap::getShortCode($module);
            echo "<pre>";
            print_r($sc['params']);
            wp_die();
        });
    }

    /**
     * @param string $module
     * @param array $params
     */
    public function updateParam($module, array $params)
    {
        add_action('vc_after_init', function() use ($module, $params) {
            vc_update_shortcode_param($module, $params);
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

    /**
     * Set VC as part of the theme. Disables "Custom CSS".
     */
    public function setAsTheme()
    {
        add_action('vc_before_init', function () {
            vc_set_as_theme();
        });
    }

    public function cleanClasses()
    {
        /*$tags_to_clean = [
            'vc_row',
            'vc_column',
            'vc_row_inner',
            'vc_column_inner',
            'vc_column-inner',
        ];

        add_filter('vc_shortcodes_css_class', function ($class_string, $tag) use ($tags_to_clean) {
            if (in_array($tag, $tags_to_clean)) {

                $class_string = str_replace(' wpb_row', '', $class_string);
                $class_string = str_replace(' vc_row-fluid', '', $class_string);
                $class_string = str_replace(' vc_column_container', '', $class_string);
                $class_string = str_replace('vc_column-inner', '', $class_string);
                $class_string = str_replace('wpb_column', '', $class_string);

                // replace vc_, but exclude any custom css
                // attached via vc_custom_XXX (negative lookahead)
                $class_string = preg_replace('/vc_(?!custom)/i', '', $class_string);

                // replace all vc_
                $class_string = preg_replace('/vc_/i', '', $class_string);
            }
            $class_string = preg_replace('|col-sm|', 'col-sm', $class_string);
            return $class_string;
        }, 10, 2);*/
    }

}