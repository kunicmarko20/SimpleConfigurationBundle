<?php

namespace KunicMarko\ConfigurationPanelBundle\Twig;


class ElapsedTime extends \Twig_Extension
{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('elapsed', array($this, 'elapsedTimeFilter')),
        );
    }

    /**
     * Human readable difference since $dt in past
     *
     * @param mixed $timestamp
     * @return string
     */
    public function elapsedTimeFilter($timestamp)
    {
        if($timestamp instanceof \DateTime){
            $timestamp = $timestamp->getTimestamp();           
        }

        $time = time() - $timestamp; // time since that moment

        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            // sub-second edge case
            if ($time < 1) return 'just now';
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':' ago');
        }
    }
    public function getName()
    {
        return 'elapsed';
    }
}