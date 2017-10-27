<?php

namespace KunicMarko\SimpleConfigurationBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

class DiscriminatorMapListener
{
    private $types;

    public function __construct(array $types)
    {
        $this->types = $types;
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

        $reader = new AnnotationReader();

        $discriminatorMapAnnotation = $reader->getClassAnnotation($class, DiscriminatorMap::class);

        if ($discriminatorMapAnnotation !== null) {
            return;
        }

        $newDiscriminatorMap = array_merge($discriminatorMapAnnotation->value, $this->types);

        $metadata->setDiscriminatorMap($newDiscriminatorMap);
    }
}
