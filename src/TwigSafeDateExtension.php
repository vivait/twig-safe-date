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

    public function safeDateFormatFilter(
        Environment $env,
        mixed $date,
        ?string $format = null,
        ?string $timezone = null,
        string $contentIfNull = '-'
    ): string {
        if (empty($date)) {
            return $contentIfNull;
        }

        $coreExtension = $env->getExtension(CoreExtension::class);

        if (null === $format) {
            $formats = $coreExtension->getDateFormat();

            $format = $date instanceof DateInterval ? $formats[1] : $formats[0];
        }

        if ($date instanceof DateInterval) {
            return $date->format($format);
        }

        return $coreExtension->formatDate($date, $format, $timezone);
    }
}
