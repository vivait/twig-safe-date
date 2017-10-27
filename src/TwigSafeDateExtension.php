<?php

namespace Vivait\TwigSafeDate;

use DateInterval;
use Twig_Environment;

class TwigSafeDateExtension extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_Filter(
                'date',
                [$this, 'safeDateFormatFilter'],
                ['needs_environment' => true]
            ),
        ];
    }

    /**
     * @param Twig_Environment $env
     * @param                  $date
     * @param null             $format
     * @param null             $timezone
     * @param string           $contentIfNull
     *
     * @return string
     */
    public function safeDateFormatFilter(
        Twig_Environment $env,
        $date,
        $format = null,
        $timezone = null,
        $contentIfNull = '-'
    ) {
        if ($date === null) {
            return $contentIfNull;
        }

        if (null === $format) {
            $formats = $env->getExtension('Twig_Extension_Core')->getDateFormat();
            $format = $date instanceof DateInterval ? $formats[1] : $formats[0];
        }

        if ($date instanceof DateInterval) {
            return $date->format($format);
        }

        return twig_date_converter($env, $date, $timezone)->format($format);
    }
}
