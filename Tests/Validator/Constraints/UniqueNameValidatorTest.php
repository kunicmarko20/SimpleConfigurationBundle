<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\Validator\Constraints;

use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use Kunicmarko\SimpleConfigurationBundle\Tests\Repository\MockConfigurationRepository;
use KunicMarko\SimpleConfigurationBundle\Validator\Constraints\UniqueName;
use KunicMarko\SimpleConfigurationBundle\Validator\Constraints\UniqueNameValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class UniqueNameValidatorTest extends AbstractTest
{
    public function testValidateFail()
    {
        $configurationRepository = MockConfigurationRepository::getValueForMock('nameExists');

        $validator = new UniqueNameValidator($configurationRepository);
        $context = $this->mockContextWithViolation();
        $validator->initialize($context);

        $configuration = $this->mockConfiguration();
        $validator->validate($configuration, new UniqueName());
    }

    private function mockContextWithViolation()
    {
        $context = $this->mock(ExecutionContextInterface::class);
        $violationBuilder = $this->mock(ConstraintViolationBuilderInterface::class);

        $violationBuilder->expects($this->once())
            ->method('atPath')
            ->will($this->returnValue($violationBuilder));

        $violationBuilder->expects($this->once())
            ->method('addViolation')
            ->will($this->returnValue($violationBuilder));

        $context->expects($this->once())
            ->method('buildViolation')
            ->will($this->returnValue($violationBuilder));

        return $context;
    }

    private function mockConfiguration()
    {
        $configuration = $this->mock(AbstractConfigurationType::class);
        $configuration->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('string'));

        return $configuration;
    }

    public function testValidateValid()
    {
        $configurationRepository = MockConfigurationRepository::getValueForMock(null);

        $validator = new UniqueNameValidator($configurationRepository);

        $configuration = $this->mockConfiguration();
        $validator->validate($configuration, new UniqueName());
    }
}
