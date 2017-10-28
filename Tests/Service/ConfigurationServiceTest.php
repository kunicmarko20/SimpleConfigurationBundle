<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\Service;

use KunicMarko\SimpleConfigurationBundle\Service\ConfigurationService;
use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use KunicMarko\SimpleConfigurationBundle\Tests\Repository\MockConfigurationRepository;

class ConfigurationServiceTest extends AbstractTest
{
    public function testGetAll()
    {
        $configurationRepository = MockConfigurationRepository::getAllMock(['random' => 'value']);
        $configurationService = new ConfigurationService($configurationRepository);

        $all = $configurationService->getAll();

        $this->assertArrayHasKey('random', $all);
        $this->assertArrayNotHasKey('bla', $all);
    }

    public function testGetValueFor()
    {
        $configurationRepository = MockConfigurationRepository::getValueForMock('someRandomText');
        $configurationService = new ConfigurationService($configurationRepository);

        $one = $configurationService->getValueFor('random');

        $this->assertSame('someRandomText', $one);
    }
}
