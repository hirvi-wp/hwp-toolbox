<?php

namespace HWP\Toolbox\Plugin;

class PluginActivation {

    /**
     * @var array
     */
    private $plugins;

    /**
     * @var array
     */
    private $config;

    /**
     * PluginActivation constructor.
     *
     * @param array $plugins
     * @param array $config
     */
    public function __construct(array $plugins, array $config)
    {
        $this->plugins = $plugins;
        $this->config = $config;

        add_action('tgmpa_register', [$this, 'register']);
    }

    /**
     * Register plugins and configuration
     *
     * @return void
     */
    public function register()
    {
        tgmpa($this->plugins, $this->config);
    }

}