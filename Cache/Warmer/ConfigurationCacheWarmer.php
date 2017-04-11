<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Cache\Warmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\FilesystemCache;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;

class ConfigurationCacheWarmer implements CacheWarmerInterface
{
    /** @var EntityManager  */
    private $em;
    /** @var string */
    private $cacheDirectory;

    public function __construct(EntityManager $em, $cacheDirectory)
    {
        $this->em = $em;
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * Warms up the cache.
     *
     * @param string $dir The cache directory
     */
    public function warmUp($dir = null)
    {
        $cacheDriver = new FilesystemCache($this->cacheDirectory);
        $cacheDriver->save(AbstractConfiguration::CACHE_KEY, $this->getCacheableData());
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * Optional warmers can be ignored on certain conditions.
     *
     * A warmer should return true if the cache can be
     * generated incrementally and on-demand.
     *
     * @return Boolean true if the warmer is optional, false otherwise
     */
    public function isOptional()
    {
        return true;
    }

    /**
     * Gets data that will be cached
     * @return array
     */
    private function getCacheableData()
    {
        $data = [];

        foreach ($this->getConfigurationData() as $item) {
            $data[$item->getName()] = $item->getValue();
        }
        return $data;
    }

    /**
     * @return array|AbstractConfiguration[]
     */
    public function getConfigurationData()
    {
        return $this
            ->em
            ->getRepository('ConfigurationPanelBundle:AbstractConfiguration')
            ->findAll();
    }
}
