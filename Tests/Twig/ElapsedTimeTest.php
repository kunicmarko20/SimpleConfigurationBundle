<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\Twig;

use KunicMarko\SimpleConfigurationBundle\Tests\AbstractTest;
use KunicMarko\SimpleConfigurationBundle\Twig\ElapsedTime;

class ElapsedTimeTest extends AbstractTest
{
    /**
     * @dataProvider getDates
     */
    public function testElapsed($key, $expected)
    {
        $elapsedFilter = new ElapsedTime();

        $string = $elapsedFilter->elapsed($key);

        $this->assertSame($expected, $string);
    }

    public function testGetFilters()
    {
        $elapsedFilter = new ElapsedTime();

        $filter = $elapsedFilter->getFilters();

        $this->assertInstanceOf(\Twig_SimpleFilter::class, $filter[0]);
    }

    public function getDates()
    {
        return [
            [
                new \DateTime('now -5 minutes'),
                '5 minutes ago',
            ],
            [
                new \DateTime('now - 1 hour'),
                '1 hour ago',
            ],
            [
                strtotime('-2 hours'),
                '2 hours ago',
            ],
            [
                strtotime('-24 hours'),
                '1 day ago',
            ],
            [
                strtotime('-5 months'),
                '5 months ago',
            ],
            [
                new \DateTime('now - 1 week'),
                '1 week ago',
            ],
            [
                new \DateTime('now - 10 years'),
                '10 years ago',
            ],
        ];
    }
}
