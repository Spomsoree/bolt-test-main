<?php

namespace App\Service;

use Bolt\Entity\Content;
use Bolt\Factory\ContentFactory;
use Bolt\Storage\Query;

class SSCDataFetcher
{
    private $factory;

    public function __construct(ContentFactory $factory)
    {
        $this->factory = $factory;
    }

    private function upsert(Content $content) {
        $criteria = [
            'title' => $content->getFieldValue('headline'),
        ];

        $existingContent = $this->factory->upsert('test', $criteria);

        $existingContent->setFieldValue('title', $content->getFieldValue('headline'));

        $this->factory->save($existingContent);
    }

    public function handleGame(Content $game) {
        // Maybe reuse the getGame method to change data
        $this->upsert($game);
    }

    public function handleEvent(Content $event) {
        // Maybe reuse the getEvent method to change data
        $this->upsert($event);
    }

    /*

    public function getGames(): array
    {
        $sscgames = [];

        $entries = $this->query->getContent('games', [
            'status'   => Statuses::PUBLISHED,
            'datefrom' => '>=' . Date::helper()->today,
        ]);
        $entries->setMaxPerPage(200);

        foreach ($entries as $entry) {
            $e_datefrom = new \DateTime($entry->getFieldValue('datefrom'));
            $e_headline = $entry->getFieldValue('headline') ?? '';

            if ($e_datefrom->format('Y-m-d') >= Date::helper()->today) {
                $item = (object)[
                    'id'       => $entry->getId(),
                    'group'    => 'games',
                    'date'     => $e_datefrom,
                    'headline' => $e_headline,
                ];

                $sscgames[] = $item;
            }
        }

        return $sscgames;
    }

    public function getEvents(): array
    {
        $sscevents = [];

        $entries = $this->query->getContent('events', [
            'status'   => Statuses::PUBLISHED,
            'datefrom' => '>=' . Date::helper()->today,
        ]);
        $entries->setMaxPerPage(200);

        foreach ($entries as $entry) {
            $e_datefrom = new \DateTime($entry->getFieldValue('datefrom'));
            $e_headline = $entry->getFieldValue('headline') ?? '';

            if ($e_datefrom->format('Y-m-d') >= Date::helper()->today) {
                $item = (object)[
                    'id'       => $entry->getId(),
                    'group'    => 'events',
                    'date'     => $e_datefrom,
                    'headline' => $e_headline,
                ];

                $sscevents[] = $item;
            }
        }

        return $sscevents;
    }
    */
}
