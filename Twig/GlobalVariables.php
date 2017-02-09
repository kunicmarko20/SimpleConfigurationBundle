<?php

namespace KunicMarko\ConfigurationPanelBundle\Twig;

use KunicMarko\ConfigurationPanelBundle\Services\ConfigurationService;

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
        return array(
            'configuration' => $this->configurationService
        );
    }

    public function getName()
    {
        return 'configuration';
    }
}
