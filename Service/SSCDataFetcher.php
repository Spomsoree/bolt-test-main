<?php

namespace App\Service;

use App\Helper\Date;
use Bolt\Enum\Statuses;
use Bolt\Factory\ContentFactory;
use Bolt\Storage\Query;

class SSCDataFetcher
{
    private $query;
    private $factory;

    public function __construct(Query $query, ContentFactory $factory)
    {
        $this->query   = $query;
        $this->factory = $factory;
    }

    public function fetch(): int
    {
        // Using the generic Query::getContent()
        $rawteams = $this->query->getContent('teams', [
            'status' => Statuses::PUBLISHED,
        ]);
        $teams    = iterator_to_array($rawteams->getCurrentPageResults());

        // collector
        $entries = [];

        // get games
        $entries = array_merge($entries, $this->getGames());

        // get events
        $entries = array_merge($entries, $this->getEvents());

        // Using Query::getContentForTwig()
        // which sets default parameters, like status 'published'
        // and orderBy
        // $entries = $this->query->getContentForTwig('games', [
        //     'headline' => '%entry%', // search LIKE
        // ]);

        // Get entries and pages, without any filtering parameters
        // $gamesAndEvents = $this->query->getContentForTwig('games,events');

        /*
        // Per default PagerFanta only loads 20 items per page.
        // We do not want paging so we set value to '250'
        $entries->setMaxPerPage(250);
        // Finally, since all results are paginated using PagerFanta
        // here is a few operations we can run on them.
        $numberOfPages = $entries->getNbResults();
        $numberOfEntries = $entries->getNbResults();
        $currentPage = $entries->getCurrentPage();
        $currentPageEntries = iterator_to_array($entries->getCurrentPageResults());

        // And finally, let's just return entries that we found
        // return $currentPageEntries;
        return $currentPageEntries;
        */

        // Spomsoree: I'd save the data inside of this.
        $results = [
            ['title' => 'Title 1', 'text' => 'Text 1'],
            ['title' => 'Title 2', 'text' => 'Text 2'],
        ];

        foreach ($results as $fieldData) {
            $criteria = [
                'title' => $fieldData['title'],
            ];

            $content = $this->factory->upsert('test', $criteria);

            foreach ($fieldData as $name => $value) {
                $content->setFieldValue($name, $value);
            }

            $this->factory->save($content);
        }

        return count($results);
    }

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
}
