<?php

namespace App\Controller;

use App\Service\SSCDataFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SSCController extends AbstractController
{
    protected $service;

    public function __construct(SSCDataFetcher $service)
    {
        $this->service = $service;
    }

    /**
     * @return Response
     *
     * @Route("/ssc", name="scc")
     *
     * Spomsoree: Kann manuell gestartet werden (Gefährlich weil das jeder tun kann, siehe security.yaml um das zu schützen)
     */
    public function getRecordsFromAPI(): Response
    {
        dump($this->service->fetch());
        die();

        return new Response('OK');
    }

    /**
     * @return Response
     *
     * @Route("/webhook/ssc", name="scc_webhook", methods={"POST"})
     *
     * Spomsoree: Webhook startet das fetching (Sollte auch in der security.yaml geschützt werden)
     */
    public function getRecordsFromAPIWebhook(): Response
    {
        dump($this->service->fetch());
        die();

        return new Response('OK');
    }
}
