<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Twig;

class ElapsedTime extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('elapsed', [$this, 'elapsed']),
        ];
    }

    /**
     * @param \DateTime|int $timestamp
     *
     * @return string
     */
    public function elapsed($timestamp)
    {
        if ($timestamp instanceof \DateTime) {
            $timestamp = $timestamp->getTimestamp();
        }

        $time = time() - $timestamp; // time since that moment

        $tokens = [
            31536000 => 'year',
            2592000  => 'month',
            604800   => 'week',
            86400    => 'day',
            3600     => 'hour',
            60       => 'minute',
            1        => 'second',
        ];

        foreach ($tokens as $unit => $text) {
            // sub-second edge case
            if ($time < 1) {
                return 'just now';
            }
            if ($time < $unit) {
                continue;
            }
            $numberOfUnits = floor($time / $unit);

            return $numberOfUnits.' '.$text.(($numberOfUnits > 1) ? 's ago' : ' ago');
        }
    }
}
