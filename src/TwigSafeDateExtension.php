<?php

namespace Vivait\TwigSafeDate;

class TwigSafeDateExtension extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_Filter(
                'safedate',
                [$this, 'safeDate']
            ),
            new \Twig_Filter(
                'safeDate',
                [$this, 'safeDate']
            ),
        ];
    }

    /**
     * @param \DateTimeInterface|string|array|null $date
     * @param string                               $format
     * @param string                               $contentIfNull
     *
     * @return string
     */
    public function safeDate($date, $format = 'F j, Y H:i.', $contentIfNull = '-')
    {
        if ($date === null) {
            return $contentIfNull;
        }

        if ($date instanceof \DateTimeInterface) {
            return $date->format($format);
        }

        $timezone = null;
        /*
         * If you've json_decoded a DateTimeInterface object (that was previously json_encoded), you'll have a key of `date` in it
         */
        if (is_array($date) && isset($date['date'])) {
            $date = $date['date'];
            $timezone = isset($date['timezone']) ? new \DateTimeZone($date['timezone']) : null;
        }

        if (is_string($date) && trim($date) !== '') {
            try {
                return (new \DateTimeImmutable($date, $timezone))->format($format);
            } catch (\Exception $e) {
                return $contentIfNull;
            }
        }

        // not sure what it is here, just return the content if it were null
        return $contentIfNull;
    }
}
