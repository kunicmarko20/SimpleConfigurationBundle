<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Service;

use KunicMarko\SonataConfigurationPanelBundle\Repository\FindConfigurations;

class ConfigurationService
{
    /** @var array */
    private static $config = null;

    public function __construct(FindConfigurations $findConfigurations)
    {
        if (self::$config === null) {
            self::$config = $findConfigurations();
        }
    }

    /**
     * Get All Values.
     *
     * @return array
     */
    public function getAll()
    {
        return self::$config;
    }

    /**
     * Get One value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getValueFor($name)
    {
        if (!array_key_exists($name, self::$config)) {
            return;
        }

        return self::$config[$name];
    }
}
