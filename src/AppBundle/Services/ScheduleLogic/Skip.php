<?php

namespace AppBundle\Services\ScheduleLogic;

use JMS\DiExtraBundle\Annotation as DI;
use AppBundle\Services\Support\LogicExecute;

/**
 * 忙しくてlt自体を次の人にパスする場合
 * または、飛び込みでやって自分の発表を一周ずらす場合
 *
 * @DI\Service("schedule_postpone_skip")
 */
class Skip extends BaseLogic implements LogicExecute
{
    public function execute()
    {

    }
}