<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\DependencyInjection;

use KunicMarko\SimpleConfigurationBundle\DependencyInjection\SimpleConfigurationExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class SimpleConfigurationExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadsFormServiceDefinitionWhenSimpleConfigurationBundleIsRegistered()
    {
        $this->container->setParameter('kernel.bundles', ['SimpleConfigurationBundle' => 'whatever']);
        $this->load();
        $this->assertContainerBuilderHasService(
            'simple_configuration.service.configuration',
            'KunicMarko\SimpleConfigurationBundle\Services\ConfigurationService'
        );
    }

    protected function getContainerExtensions()
    {
        return [new SimpleConfigurationExtension()];
    }
}
