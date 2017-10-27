<?php

namespace KunicMarko\SimpleConfigurationBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

class DiscriminatorMapListener
{
    private $types;
    private $annotationReader;

    public function __construct(AnnotationReader $annotationReader, array $types)
    {
        $this->types = $types;
        $this->annotationReader = $annotationReader;
    }

    /**
     * Updates discrimantor map with new types.
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $event) : void
    {
        $metadata = $event->getClassMetadata();
        $class = $metadata->getReflectionClass();

        if ($class->getName() !== AbstractConfigurationType::class) {
            return;
        }

        $discriminatorMapAnnotation = $this->annotationReader->getClassAnnotation($class, DiscriminatorMap::class);

        if ($discriminatorMapAnnotation === null) {
            return;
        }

        $newDiscriminatorMap = array_merge($discriminatorMapAnnotation->value, $this->types);

        $metadata->setDiscriminatorMap($newDiscriminatorMap);
    }
}
