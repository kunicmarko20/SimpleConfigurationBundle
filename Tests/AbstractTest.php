<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    protected function mock($className)
    {
        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
