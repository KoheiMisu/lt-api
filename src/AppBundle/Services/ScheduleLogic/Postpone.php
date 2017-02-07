<?php

namespace AppBundle\Services\ScheduleLogic;

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

    }
}