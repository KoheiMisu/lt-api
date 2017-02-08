<?php

namespace AppBundle\Services\ScheduleLogic;

use Carbon\Carbon;
use JMS\DiExtraBundle\Annotation as DI;
use AppBundle\Services\Support\LogicExecute;

/**
 * 部会等がなくなり、ltが開催されない場合
 *
 * @DI\Service("schedule_postpone_logic")
 */
class Postpone  extends BaseLogic implements LogicExecute
{
    public function execute()
    {
        //今週のスケジュールを取得
        $targetSchedules = $this->em->getRepository('AppBundle:Schedule')->findBy(['publishDate' => new Carbon('this friday')]);

        foreach ($targetSchedules as $schedule) {
            $schedule->setStatus(2);
            $this->em->persist($schedule);
            $this->em->flush();
        }

        $this->response('@here 今週のLTスケジュールを次週に延期しました。');
    }
}