<?php

namespace AppBundle\Services;

use AppBundle\Services\ScheduleCreator;
use AppBundle\Services\ScheduleNotifier;
use JMS\DiExtraBundle\Annotation as DI;
use AppBundle\Services\Support\LogicExecute;

/**
 * @DI\Service("schedule_manager")
 */
class ScheduleManager
{
    /** @var ScheduleCreator */
    private $scheduleCreator;

    /** @var ScheduleNotifier  */
    private $scheduleNotifier;

    /**
     * ScheduleManager constructor.
     *
     * @DI\InjectParams({
     *     "scheduleCreator" = @DI\Inject("schedule_creator"),
     *     "scheduleNotifier" = @DI\Inject("schedule_notifier")
     * })
     *
     * @param \AppBundle\Services\ScheduleCreator  $scheduleCreator
     * @param \AppBundle\Services\ScheduleNotifier $scheduleNotifier
     */
    public function __construct(
        ScheduleCreator $scheduleCreator,
        ScheduleNotifier $scheduleNotifier
    )
    {
        $this->scheduleCreator = $scheduleCreator;
        $this->scheduleNotifier = $scheduleNotifier;
    }

    public function scheduleChange(LogicExecute $logic)
    {
        $logic->execute();
    }

    /**
     * 次週のスケジュール作成(延期の場合はスキップ)
     * 延期でない場合、スケジュールに紐づく発表者の最終発表日を更新
     * 次週のスケジュールに紐づくユーザを通知
     */
    public function notice()
    {
        $this->scheduleCreator->create();
        $this->scheduleNotifier->notice($this->scheduleCreator->getNextWeekSchedules());
    }
}