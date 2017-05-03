<?php

namespace HWP\Toolbox\Theme;

use HWP\Blade\BladeExtended;

class ViewHandler
{

    /**
     * @var BladeExtended
     */
    private $viewRenderer;

    /**
     * @var array
     */
    private $map;

    /**
     * Template constructor.
     *
     * @param BladeExtended $viewRenderer
     * @param array $map
     */
    public function __construct(BladeExtended $viewRenderer, $map = [])
    {
        $this->viewRenderer = $viewRenderer;
        $this->map = $map;
    }

    /**
     * @param string $template
     * @return string
     */
    public function get_template($template = '')
    {
        //echo "is_category(): " . (int) is_category() . '<br />';
        //echo "is_post_type_archive('post'): " . (int) is_post_type_archive() . '<br />';
        //echo "is_archive(): " . (int) is_archive() . '<br />';
        //echo "post_type(): " . get_post_type() . '<br />';
        //wp_die();

        foreach ($this->map as $type => $view) {
            $conditions = explode('|', $type);

            $found = true;
            foreach ($conditions as $condition) {
                $t = explode(':', $condition);
                $func = "is_${t[0]}";
                $match = (boolean) $t[1];
                $arg = isset($t[2]) ? $t[2] : false;

                if (!function_exists($func) || $func($arg) != $match) {
                    $found = false;
                    break;
                }
            }

            if ($found) {
                echo $this->viewRenderer->view()->make($view);

                return;
            }
        }

        return $template;
    }

    /**
     * Add custom image sizes
     */
    public function image_sizes()
    {
        $sizes = config("theme.image_size");

        foreach ($sizes as $prefix => $sizes) {
            foreach ($sizes as $name => $size) {
                add_image_size("${prefix}_${name}", $size[0], $size[1], isset($size[2]) ? $size[2] : false);
                add_image_size("${prefix}_${name}_2x", $size[0] * 2, $size[1] * 2, isset($size[2]) ? $size[2] : false);
            }
        }
    }

    /**
     * Add WooCommerce theme support.
     */
    public function setup_woocommerce()
    {
        add_theme_support('woocommerce');
    }

    /**
     * Make excerpts pretty
     */
    public function tweak_excerpts()
    {
        add_filter('excerpt_length', function ($length) {
            return config('theme.excerpt.length');
        }, 999);

        add_filter('excerpt_more', function () {
            return config('theme.excerpt.readmore');
        });
    }

    /**
     *
     */
    public function pages_excerpts()
    {
        add_post_type_support('page', 'excerpt');
    }

}