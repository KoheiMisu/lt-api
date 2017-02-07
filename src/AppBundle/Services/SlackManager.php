<?php

namespace AppBundle\Services;

use Maknz\Slack\Client;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class SlackManager
 * @package AppBundle\Services
 */
class SlackManager
{
    /** @var Client  */
    private $client;

    /**
     * SlackManager constructor.
     *
     * @param Client $slack
     */
    public function __construct(Client $slack)
    {
        $this->client = $slack;
    }

    /**
     * @param $message
     */
    public function send($message)
    {
        $this->client->send($message);
    }
}