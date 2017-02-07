<?php

namespace AppBundle\Services\ScheduleLogic;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use JMS\DiExtraBundle\Annotation as DI;
use AppBundle\Services\Support\LogicExecute;

/**
 * 今週のltをキャンセルする場合
 * 来週やる意思がある場合のロジック
 *
 * @DI\Service("schedule_cancel_logic")
 */
class Cancel extends BaseLogic implements LogicExecute
{
    public function execute()
    {
        $cancelPresenter = $this->em->getRepository('AppBundle:Presenter');
    }
}