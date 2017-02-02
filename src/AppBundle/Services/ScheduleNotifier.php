<?php

namespace AppBundle\Services;

class ScheduleNotifier
{
    /** @var Slack  */
    private $client;

    public function __construct(Slack $slack)
    {
        $this->client = $slack;
    }

    public function notice($schedules)
    {
        $this->client->send($this->makeMessage($schedules));
    }

    /**
     * @param $schedules
     *
     * @return string
     */
    private function makeMessage($schedules): string
    {
        $message = "";
        return $message;
    }
}
