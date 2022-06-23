<?php

declare(strict_types=1);

namespace Vivait\TwigSafeDateExtension\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\TemplateWrapper;
use Vivait\TwigSafeDate\TwigSafeDateExtension;

class TwigSafeDateExtensionTest extends TestCase
{
    /**
     * @test
     * @dataProvider templateProvider
     *
     * @param string $template
     * @param string $expectedOutput
     * @param array $params
     */
    public function itCanBeRegisteredAsATwigExtensionAndUsedCorrectly(
        string $template,
        string $expectedOutput,
        array $params = []
    ): void {
        self::assertEquals($expectedOutput, $this->getTemplate($template)->render($params));
    }

    public function templateProvider(): array
    {
        return [
            ['{{ "2016-10-25"|date("d/m/Y", "Europe/London") }}', '25/10/2016'],
            ['{{ null|date("d/m/Y") }}', '-'],
            ['{{ null|date("d/m/Y", "Europe/London", "*") }}', '*'],
        ];
    }

    private function getTemplate(string $template): TemplateWrapper
    {
        $loader = new ArrayLoader(['template' => $template]);
        $twig = new Environment($loader, ['debug' => true, 'cache' => false]);
        $twig->addExtension(new TwigSafeDateExtension());

        return $twig->load('template');
    }
}
