<?php

namespace KunicMarko\SimpleConfigurationBundle\Service;

use KunicMarko\SimpleConfigurationBundle\Repository\FindConfigurations;

class ConfigurationService
{
    private static $config = [];

    public function __construct(FindConfigurations $findConfigurations)
    {
        if (empty(self::$config)) {
            self::$config = $findConfigurations();
        }
    }

    public function getAll() : array
    {
        return self::$config;
    }

    /**
     * @return mixed
     */
    public function getValueFor(string $name)
    {
        if (!array_key_exists($name, self::$config)) {
            return;
        }

        return self::$config[$name];
    }
}
