<?php

namespace KunicMarko\SimpleConfigurationBundle\Service;

use KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository;

class ConfigurationService
{
    private $findConfigurations;

    public function __construct(ConfigurationRepository $findConfigurations)
    {
        $this->findConfigurations = $findConfigurations;
    }

    public function getAll() : array
    {
        return $this->findConfigurations->findAll();
    }

    /**
     * @return mixed
     */
    public function getValueFor(string $name)
    {
        return $this->findConfigurations->findOneByName($name);
    }
}
