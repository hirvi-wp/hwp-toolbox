<?php

namespace HWP\Toolbox\Plugin;

class TGMPA {

    /**
     * @var array
     */
    protected static $plugins = [];

    /**
     * @var array
     */
    protected static $config = [
        'id'           => 'hirvi',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    ];

    /**
     * Register plugins and configuration
     *
     * @param array $plugins
     * @param array $userConfig
     */
    public static function setup(array $plugins, $userConfig = [])
    {
        static::$plugins = $plugins;
        static::$config = array_merge_recursive(static::$config, $userConfig);

        add_action('tgmpa_register', [self, 'register']);
    }

    public function register()
    {
        tgmpa(static::$plugins, static::$config);
    }

}