<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Services;

use Doctrine\Common\Cache\FilesystemCache;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;

class ConfigurationService
{
    /** @var false|array  */
    private $config;
    
    public function __construct($dir)
    {
        $cacheDriver = new FilesystemCache($dir);
        $this->config = $cacheDriver->fetch(AbstractConfiguration::CACHE_KEY);
    }
    /**
     * Get All Values
     *
     * @return array
     */
    public function getAll()
    {
        return $this->config;
    }
    /**
     * Get One value
     *
     * @param string $name
     * @return mixed
     */
    public function getValueFor($name)
    {
        if (!key_exists($name, $this->config)) {
            return null;
        }
        
        return $this->config[$name];
    }
    
    /**
     * Get class Name
     * @param object $object
     * @return string
     */
    public function getShortClassName($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }
}
