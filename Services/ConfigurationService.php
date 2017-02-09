<?php

namespace KunicMarko\ConfigurationPanelBundle\Services;

use Doctrine\Common\Cache\FilesystemCache;

class ConfigurationService
{
    private $config;
    
    public function __construct($dir)
    {
        $cacheDriver = new FilesystemCache($dir);
        $this->config = $cacheDriver->fetch('ConfigurationPanel');
    }
    /**
     * Human readable difference since $dt in past
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
     *
     * @return string
     */
    public function getShortClassName($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }
}
