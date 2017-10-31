<?php

namespace KunicMarko\SimpleConfigurationBundle\Validator\Constraints;

use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueNameValidator extends ConstraintValidator
{
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param AbstractConfigurationType $configuration
     * @param Constraint                $constraint
     */
    public function validate($configuration, Constraint $constraint)
    {
        if (($object = $this->configurationRepository->findOneByName($configuration->getName())) &&
            $object->getId() !== $configuration->getId()
        ) {
            $this->context->buildViolation($constraint->message)
                ->atPath('name')
                ->addViolation();
        }
    }
}
