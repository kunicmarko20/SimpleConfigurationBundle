<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\EventListener;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use KunicMarko\SimpleConfigurationBundle\EventListener\DiscriminatorMapListener;
use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use Mockery;

class DiscriminatorMapListenerTest extends AbstractTest
{
    public function testLoadClassMetadata()
    {
        $annotationReader = $this->mockAnnotationReader(new Annotation(['value' => ['some' => 'thing']]));
        $discriminatorMapListener = new DiscriminatorMapListener($annotationReader, ['some2' => 'thing2']);

        $loadClassMetadataArgs = $this->mockLoadClassMetadataEventArgs(
            AbstractConfigurationType::class,
            ['some' => 'thing', 'some2' => 'thing2']
        );

        $discriminatorMapListener->loadClassMetadata($loadClassMetadataArgs);
    }

    public function testLoadClassMetadataWrongClass()
    {
        $annotationReader = $this->mock(AnnotationReader::class);
        $discriminatorMapListener = new DiscriminatorMapListener($annotationReader, ['some2' => 'thing2']);

        $loadClassMetadataArgs = $this->mockLoadClassMetadataEventArgs('FakeClassName');
        $discriminatorMapListener->loadClassMetadata($loadClassMetadataArgs);
    }

    public function testLoadClassMetadataMissingDiscriminatorMap()
    {
        $annotationReader = $this->mockAnnotationReader(null);
        $discriminatorMapListener = new DiscriminatorMapListener($annotationReader, ['some2' => 'thing2']);

        $loadClassMetadataArgs = $this->mockLoadClassMetadataEventArgs(AbstractConfigurationType::class);
        $discriminatorMapListener->loadClassMetadata($loadClassMetadataArgs);
    }

    private function mockAnnotationReader($returnValue)
    {
        $annotationReader = $this->mock(AnnotationReader::class);

        $annotationReader->expects($this->once())
            ->method('getClassAnnotation')
            ->will($this->returnValue($returnValue));

        return $annotationReader;
    }

    private function mockLoadClassMetadataEventArgs($className, $expected = null)
    {
        $loadClassMetadataArgs = Mockery::mock(LoadClassMetadataEventArgs::class);
        $reflectionClass = Mockery::mock(\ReflectionClass::class);
        $metadata = Mockery::mock(ClassMetadata::class);

        $reflectionClass->shouldReceive('getName')
            ->andReturn($className);

        $metadata->shouldReceive('getReflectionClass')
            ->andReturn($reflectionClass);

        if ($expected) {
            $metadata->shouldReceive('setDiscriminatorMap')
                ->with($expected);
        }

        $loadClassMetadataArgs->shouldReceive('getClassMetadata')
            ->andReturn($metadata);

        return $loadClassMetadataArgs;
    }
}
