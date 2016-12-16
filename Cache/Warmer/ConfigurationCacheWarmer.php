<?php

namespace KunicMarko\ConfigurationPanelBundle\Cache\Warmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\FilesystemCache;
use KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\DateType;

class ConfigurationCacheWarmer implements CacheWarmerInterface
{
    private $em;
    private $cacheDirectory;
    public function __construct(EntityManager $em, $cacheDirectory) {
        $this->em = $em;
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($dir = null)
    {
        $cacheDriver = new FilesystemCache($this->cacheDirectory);
        $cacheDriver->save('ConfigurationPanel', $this->getCacheableData());
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

    private function getCacheableData()
    {
        $data = array();
        foreach ($this->getConfigurationData() as $item) {
            $cacheKey = $item->getName();
            // Due to lazy loading, $media will not get initialized,
            // therefore we need to explicitly get it 
            if(strpos(get_class($item), 'Media') !== false){
                $mediaType = $this
                    ->em
                    ->getRepository('ConfigurationPanelBundle:Configuration')
                    ->getMediaTypeById($item->getId());
                if(!$mediaType) {
                    $data[$cacheKey] = null;
                    continue;
                }
                $data[$cacheKey] = $mediaType;
            }elseif ($item instanceof DateType){
                $data[$cacheKey] = $item->getDate();
            }else {
                $data[$cacheKey] = $item->getValue();
            }
        }
        return $data;
    }

    public function getConfigurationData()
    {
        return $this
            ->em
            ->getRepository('ConfigurationPanelBundle:Configuration')
            ->findAll();
    }
}