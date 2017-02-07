<?php

namespace AppBundle\Services;

use AppBundle\Services\Slack;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("schedule_notifier")
 */
class ScheduleNotifier
{
    /** @var Slack  */
    private $client;

    /**
     * ScheduleNotifier constructor
     *
     * @DI\InjectParams({
     *     "slack" = @DI\Inject("slack"),
     * })
     *
     * @param Slack $slack
     */
    public function __construct(Slack $slack)
    {
        $this->client = $slack;
    }

    /**
     * @param array $schedules
     */
    public function notice(array $schedules)
    {
        $this->client->send($this->makeMessage($schedules));
    }

    /**
     * @param array $schedules
     *
     * @return string
     */
    private function makeMessage(array $schedules): string
    {
        $presenterNames = [];
        foreach ($schedules as $schedule) {
            $presenterNames[] = $schedule->getPresenter()->getName() . 'さん';
        }

        $presenterNames = implode(', ', $presenterNames);

        $message = <<<EOF
今週もお疲れ様でした。
来週の発表者は、{$presenterNames} です。
EOF;
        return $message;
    }
}
