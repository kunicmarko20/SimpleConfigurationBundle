<?php

namespace KunicMarko\ConfigurationPanelBundle\Twig;

class IsImage extends \Twig_Extension
{
    private $uploadDirectory;
    
    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('isImage', array($this, 'isImageFilter')),
        );
    }

    public function isImageFilter($file, $type = null)
    {
        if ($type === 'media') {
            return $this->check($file);
        }
        $file = "$this->uploadDirectory/$file";
        if (file_exists($file)) {
            return $this->check(mime_content_type($file));
        }
    }
    
    public function check($file)
    {
        return strpos($file, 'image') !== false ?: false;
    }
    
    public function getName()
    {
        return 'isImage';
    }
}
