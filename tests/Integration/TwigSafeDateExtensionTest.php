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
            ['{{ "2016-10-25"|safedate("d/m/Y") }}', '25/10/2016'],
            ['{{ myDateVariableHere|safedate("d/m/Y") }}', '25/10/2016', ['myDateVariableHere' => ['date' => "2016-10-25"]]],
            ['{{ null|safedate("d/m/Y") }}', '-'],
            ['{{ null|safedate("d/m/Y", "*") }}', '*'],
            ['{{ myDateVariableHere|safedate("d/m/Y") }}', '25/10/2016', ['myDateVariableHere' => new \DateTimeImmutable("2016-10-25")]],
            // alternative `safeDate` usage
            ['{{ "2016-10-25"|safeDate("d/m/Y") }}', '25/10/2016'],
            ['{{ myDateVariableHere|safeDate("d/m/Y") }}', '25/10/2016', ['myDateVariableHere' => ['date' => "2016-10-25"]]],
            ['{{ null|safeDate("d/m/Y") }}', '-'],
            ['{{ null|safeDate("d/m/Y", "*") }}', '*'],
            ['{{ myDateVariableHere|safeDate("d/m/Y") }}', '25/10/2016', ['myDateVariableHere' => new \DateTimeImmutable("2016-10-25")]],
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
