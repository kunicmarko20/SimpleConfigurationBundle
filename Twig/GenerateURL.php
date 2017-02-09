<?php

namespace KunicMarko\ConfigurationPanelBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;

class GenerateURL extends \Twig_Extension
{
    protected $assets;
    private $directory;

    public function __construct(AssetsHelper $assets, string $directory)
    {
        $this->assets = $assets;
        $this->directory = $directory;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('generateURL', array($this, 'generateURLFilter')),
        );
    }

    public function generateURLFilter($name, $type = null)
    {
        if ($type === 'media') {
            return $this->assets->getUrl($name);
        }
        return $this->assets->getUrl("$this->directory/$name");
    }

    public function getName()
    {
        return 'generateURL';
    }
}
