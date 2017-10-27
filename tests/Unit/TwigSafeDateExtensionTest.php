<?php

namespace Vivait\TwigSafeDate\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vivait\TwigSafeDate\TwigSafeDateExtension;

class TwigSafeDateExtensionTest extends TestCase
{
    /** @test */
    public function it_returns_default_content_if_given_a_null_value()
    {
        $twig = $this->getTwig();

        $return = (new TwigSafeDateExtension)->safeDateFormatFilter($twig, null);

        self::assertEquals('-', $return);
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwig()
    {
        $loader = new \Twig_Loader_Array(['template' => '']);
        $twig = new \Twig_Environment($loader, ['debug' => true, 'cache' => false]);

        return $twig;
    }
}
