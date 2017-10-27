<?php

namespace KunicMarko\SimpleConfigurationBundle\Twig;

class ElapsedTime extends \Twig_Extension
{
    const TIME_UNITS = [
        31536000 => 'year',
        2592000  => 'month',
        604800   => 'week',
        86400    => 'day',
        3600     => 'hour',
        60       => 'minute',
        1        => 'second',
    ];

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
    public function elapsed($timestamp) : string
    {
        $time = $this->getTimeSinceThatMoment($timestamp);

        return $this->formatTime($time);
    }

    private function getTimeSinceThatMoment($timestamp) : int
    {
        if ($timestamp instanceof \DateTime) {
            return time() - $timestamp->getTimestamp();
        }

        return time() - $timestamp;
    }

    private function formatTime(int $time) : string
    {
        foreach (self::TIME_UNITS as $unit => $text) {
            // sub-second edge case
            if ($time < 1) {
                return 'just now';
            }

            if ($time < $unit) {
                continue;
            }

            $numberOfUnits = floor($time / $unit);

            return $numberOfUnits > 1 ?
                "$numberOfUnits {$text}s ago" :
                "$numberOfUnits {$text} ago";
        }
    }
}
