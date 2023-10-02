<?php

namespace App\Service;

use App\Helper\Date;
use Bolt\Enum\Statuses;
use Bolt\Storage\Query;

class SSCDataFetcher
{
    private $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function fetch(): array
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

        return $entries; // Spomsoree: I'd save the data inside of this.
        // return [];
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
