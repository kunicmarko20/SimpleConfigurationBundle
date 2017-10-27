<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\Validator\Constraints;

use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use KunicMarko\SimpleConfigurationBundle\Validator\Constraints\UniqueName;
use KunicMarko\SimpleConfigurationBundle\Validator\Constraints\UniqueNameValidator;

class UniqueNameTest extends AbstractTest
{
    public function testGetTargets()
    {
        $constraint = new UniqueName();

        $this->assertSame('class', $constraint->getTargets());
    }

    public function testValidateBy()
    {
        $constraint = new UniqueName();

        $this->assertSame(UniqueNameValidator::class, $constraint->validatedBy());
    }
}
