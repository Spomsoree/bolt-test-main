<?php

namespace App\Twig;

use Bolt\Repository\ContentRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SSCTwig extends AbstractExtension
{
    protected $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

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
    public function testMethodAction(): array
    {
        $entryById = $this->contentRepository->findBy([
            'contentType' => 'tests'
        ]);

        return $entryById;
    }
}
