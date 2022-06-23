<?php

declare(strict_types=1);

namespace Vivait\TwigSafeDateExtension\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Vivait\TwigSafeDate\TwigSafeDateExtension;

class TwigSafeDateExtensionTest extends TestCase
{
    /**
     * @test
     */
    public function itReturnsDefaultContentIfGivenANullValue(): void
    {
        $twig = $this->getTwig();

        $return = (new TwigSafeDateExtension())->safeDateFormatFilter($twig, null);

        self::assertEquals('-', $return);
    }

    private function getTwig(): Environment
    {
        return new Environment(new ArrayLoader(['template' => '']), ['debug' => true, 'cache' => false]);
    }
}
