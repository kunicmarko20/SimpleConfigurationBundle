<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Twig;

use KunicMarko\SonataConfigurationPanelBundle\Services\ConfigurationService;

class GlobalVariables extends \Twig_Extension
{
    protected $configurationService;

    /**
     * @param ConfigurationService $configurationService
     */
    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    public function getGlobals()
    {
        return [
            'configuration' => $this->configurationService
        ];
    }

    public function getName()
    {
        return 'configuration';
    }
}
