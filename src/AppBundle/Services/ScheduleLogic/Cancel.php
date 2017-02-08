<?php

namespace AppBundle\Services\ScheduleLogic;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * 今週のltをキャンセルする場合
 * 来週やる意思がある場合のロジック
 *
 * @DI\Service("schedule_cancel_logic")
 */
class Cancel extends BaseLogic
{
    /**
     * @return void
     */
    public function execute()
    {
        $cancelPresenter = $this->em->getRepository('AppBundle:Presenter')->findOneByName($this->getSlackUserName());
        $targetSchedule = $this->em->getRepository('AppBundle:Schedule')->findLatestByPresenter($cancelPresenter);

        if (!$targetSchedule) {
            $this->response('今週のLTを担当されていません。');
            return;
        }

        $targetSchedule->setStatus(0);
        $this->em->persist($targetSchedule);
        $this->em->flush();

        $this->response($this->makeMentionName() . ' 今週のLTをキャンセルしました。');
    }
}