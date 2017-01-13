<?php

namespace HWP\Toolbox\Plugin;

class TGMPA
{

    /**
     * @var array
     */
    protected static $plugins = [];

    /**
     * @var array
     */
    protected static $config = [
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'is_automatic' => false,
    ];

    /**
     * Register plugins and configuration
     *
     * @param array $plugins
     * @param array $userConfig
     */
    public static function setup(array $plugins, $userConfig = [])
    {
        require_once plugin_path() . '/dependencies/class-tgm-plugin-activation.php';

        static::$plugins = $plugins;
        static::$config = array_merge(static::$config, $userConfig);

        add_action('tgmpa_register', function() {
            tgmpa(static::$plugins, static::$config);
        });
    }

    /**
     * Register plugins and configuration
     *
     * @return void
     */
    public function register()
    {
        tgmpa(static::$plugins, static::$config);
    }

}