<?php

declare(strict_types=1);

namespace Vivait\TwigSafeDate;

use DateInterval;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\CoreExtension;
use Twig\TwigFilter;

/**
 * @psalm-api
 */
class TwigSafeDateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'date',
                [$this, 'safeDateFormatFilter'],
                ['needs_environment' => true],
            ),
        ];
    }

    /**
     * @param Environment $env
     * @param mixed       $date
     * @param null        $format
     * @param null        $timezone
     * @param string      $contentIfNull
     *
     * @return string
     */
    public function safeDateFormatFilter(
        Environment $env,
        $date,
        $format = null,
        $timezone = null,
        string $contentIfNull = '-'
    ): string {
        if ($date === null) {
            return $contentIfNull;
        }

        if (null === $format) {
            $formats = $env->getExtension(CoreExtension::class)->getDateFormat();

            $format = $date instanceof DateInterval ? $formats[1] : $formats[0];
        }

        if ($date instanceof DateInterval) {
            return $date->format($format);
        }

        return twig_date_converter($env, $date, $timezone)->format($format);
    }
}
