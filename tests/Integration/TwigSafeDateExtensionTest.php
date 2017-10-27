<?php

namespace Vivait\TwigSafeDate\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Vivait\TwigSafeDate\TwigSafeDateExtension;

class TwigSafeDateExtensionTest extends TestCase
{

    /**
     * @test
     * @dataProvider twig_templating_provider
     */
    public function it_can_be_registered_as_a_twig_extension_and_used_correctly($template, $expectedOutput, $params = [])
    {
        self::assertEquals($expectedOutput, $this->getTemplate($template)->render($params));
    }

    /**
     * @return array
     */
    public function twig_templating_provider()
    {
        return [
            ['{{ "2016-10-25"|date("d/m/Y", "Europe/London") }}', '25/10/2016'],
            ['{{ null|date("d/m/Y") }}', '-'],
            ['{{ null|date("d/m/Y", "Europe/London", "*") }}', '*'],
        ];
    }

    /**
     * @param string $template
     *
     * @return \Twig_TemplateWrapper
     */
    public function getTemplate($template)
    {
        $loader = new \Twig_Loader_Array(['template' => $template]);
        $twig = new \Twig_Environment($loader, ['debug' => true, 'cache' => false]);
        $twig->addExtension(new TwigSafeDateExtension);

        return $twig->load('template');
    }
}
