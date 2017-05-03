<?php

namespace HWP\Toolbox\Theme;

class Scaffold {
    /**
     * @var string
     */
    protected $namespace = 'hirvi';

    /**
     * @var array
     */
    protected $scripts = [

    ];

    /**
     * @var array
     */
    protected $styles = [

    ];

    /**
     * @var Blade
     */
    protected $viewRenderer;

    /**
     * Setup constructor.
     */
    public function __construct()
    {
        //$views = [
        //    dirname(__DIR__) . '/theme/views'
        //];
//
        //$cache = dirname(__DIR__) . '/theme/cache';
//
        //$this->viewRenderer = new Blade($views, $cache);
    }

    /**
     * Theme setup
     */
    public function after_setup_theme()
    {
        // Enable plugins to manage the document title
        add_theme_support('title-tag');

        // Custom logo
        add_theme_support('custom-logo', [
            'height'     => 41,
            'width'      => 294,
            'flex-width' => true,
        ]);

        // Register navigation
        register_nav_menus(config('theme.menus'));
    }

    /**
     * Theme scripts
     */
    public function add_assets()
    {
        foreach ($this->scripts as $i => $script) {
            wp_enqueue_script("{$this->namespace}_" . substr(md5($script), 0, 5), assets_url() . '/js/' . $script, [], false, true);
        }

        foreach ($this->styles as $i => $script) {
            wp_enqueue_style("{$this->namespace}_" . substr(md5($script), 0, 5), assets_url() . '/css/' . $script, [], config('theme.version'));
        }
    }

    /**
     * @return mixed
     */
    public function custom_search_form()
    {
        return $this->viewRenderer->view()->make('partial.searchform');
    }

    /**
     * Meta Boxes
     *
     * @return void
     */
    public function meta_boxes()
    {
        $meta = config('theme.meta_boxes');

        foreach ($meta as $meta_box) {
            $class = new $meta_box($this->viewRenderer);
            $class->setupActions();
        }
    }

    /**
     * Meta Boxes
     *
     * @return void
     */
    public function term_meta_boxes()
    {
        $meta = config('theme.term_meta_boxes');

        foreach ($meta as $meta_box) {
            $class = new $meta_box($this->viewRenderer);
            $class->setup();
        }
    }

    /**
     * Register shortcodes
     *
     * return @void
     */
    public function shortcodes()
    {
        $shortcodes = config('theme.shortcodes');

        foreach ($shortcodes as $shortcode) {
            $class = new $shortcode['shortcode']($this->viewRenderer);

            if (isset($shortcode['replace'])) {
                remove_shortcode($shortcode['replace']);
            }

            add_shortcode($class->alias, [$class, (isset($shortcode['output']) ? $shortcode['output'] : 'render')]);
        }
    }
}