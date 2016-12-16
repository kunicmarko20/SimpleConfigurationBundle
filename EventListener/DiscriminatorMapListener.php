<?php

namespace KunicMarko\ConfigurationPanelBundle\EventListener;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use KunicMarko\ConfigurationPanelBundle\Entity\Configuration;

class DiscriminatorMapListener
{
    /**
     * @var array
     */
    protected $fileType;

    public function __construct($fileType)
    {
        $this->fileType = $fileType;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        $metadata = $event->getClassMetadata();
        $class = $metadata->getReflectionClass();
        if ($class->getName() !== Configuration::class) return;

        $reader = new AnnotationReader;
        if (null !== $discriminatorMapAnnotation = $reader->getClassAnnotation($class, 'Doctrine\ORM\Mapping\DiscriminatorMap')) {
            $discriminatorMap = $discriminatorMapAnnotation->value;
        }

        $discriminatorMap["file"] = $this->fileType;
        $metadata->setDiscriminatorMap($discriminatorMap);

    }
}