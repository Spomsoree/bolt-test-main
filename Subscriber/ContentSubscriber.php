<?php

namespace App\Subscriber;

use App\Service\SSCDataFetcher;
use Bolt\Entity\Content;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;


#[AsEntityListener(
    event: Events::postUpdate,
    method: 'postUpdate',
    entity: Content::class
)]
#[AsEntityListener(
    event: Events::postPersist,
    method: 'postPersist',
    entity: Content::class
)]
class ContentSubscriber
{
    protected SSCDataFetcher $sscDataFetcher;

    public function __construct(SSCDataFetcher $sscDataFetcher)
    {
        $this->sscDataFetcher = $sscDataFetcher;
    }

    public function postUpdate(Content $content): void
    {
        switch ($content->getContentType()) {
            case 'games':
                $this->sscDataFetcher->handleGame($content);
                break;
            case 'events':
                $this->sscDataFetcher->handleEvent($content);
                break;
        }
    }

    public function postPersist(Content $content): void
    {
        switch ($content->getContentType()) {
            case 'games':
                $this->sscDataFetcher->handleGame($content);
                break;
            case 'events':
                $this->sscDataFetcher->handleEvent($content);
                break;
        }
    }
}
