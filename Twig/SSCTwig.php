<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SSCTwig extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'testMethod',
                [$this, 'testMethodAction']
            ),
        ];
    }

    /**
     * @return string
     */
    public function testMethodAction(): string
    {
        return 'Hello World!';
    }
}
