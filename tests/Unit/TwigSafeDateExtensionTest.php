<?php

namespace Vivait\TwigSafeDate\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vivait\TwigSafeDate\TwigSafeDateExtension;

class TwigSafeDateExtensionTest extends TestCase
{
    /** @test */
    public function it_returns_default_content_if_given_a_null_value()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate(null, 'd/m/Y');

        self::assertEquals('-', $return);
    }

    /** @test */
    public function it_returns_customised_content_if_given_a_null_value()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate(null, 'd/m/Y', 'no date');

        self::assertEquals('no date', $return);
    }

    /** @test */
    public function it_converts_a_date_object_into_a_formatted_string_with_the_default_format()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate(new \DateTimeImmutable('2016-10-24'));

        self::assertEquals('October 24, 2016 00:00.', $return);
    }

    /** @test */
    public function it_converts_a_date_object_into_a_formatted_string()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate(new \DateTimeImmutable('2016-10-24'), 'd/m/Y');

        self::assertEquals('24/10/2016', $return);
    }

    /** @test */
    public function it_converts_a_json_encoded_then_decoded_date_object_into_a_formatted_string()
    {
        $extension = new TwigSafeDateExtension;

        $dateData = json_decode(json_encode(new \DateTimeImmutable('2016-10-25')), true);
        $return = $extension->safeDate($dateData, 'd/m/Y');

        self::assertEquals('25/10/2016', $return);
    }

    /** @test */
    public function it_converts_a_date_as_a_string_into_a_formatted_string()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate('2016-10-26', 'd/m/Y');

        self::assertEquals('26/10/2016', $return);
    }

    /** @test */
    public function it_converts_strings_that_do_not_convert_to_dates_into_default_content()
    {
        $extension = new TwigSafeDateExtension;

        $return = $extension->safeDate('thisisnotadate', 'd/m/Y');

        self::assertEquals('-', $return);
    }
}
