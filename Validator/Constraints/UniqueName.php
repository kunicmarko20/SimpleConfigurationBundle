<?php

namespace KunicMarko\SimpleConfigurationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueName extends Constraint
{
    public $message = 'simple_configuration.constraint.unique_name';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return UniqueNameValidator::class;
    }
}
