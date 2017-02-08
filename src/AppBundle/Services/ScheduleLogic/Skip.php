<?php

namespace AppBundle\Services\ScheduleLogic;

use Carbon\Carbon;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * 忙しくてlt自体を次の人にパスする場合
 * または、飛び込みでやって自分の発表を一周ずらす場合
 *
 * @DI\Service("schedule_skip_logic")
 */
class Skip extends BaseLogic
{
    public function execute()
    {
        $skipPresenter = $this->em->getRepository('AppBundle:Presenter')->findOneByName($this->getSlackUserName());
        $targetSchedule = $this->em->getRepository('AppBundle:Schedule')->findLatestByPresenter($skipPresenter);

        if (!$targetSchedule) {
            $this->response('今週のLTを担当されていません。');
            return;
        }

        /** スケジュールの削除 */
        $this->em->remove($targetSchedule);
        $this->em->flush();

        /** 発表者を発表したとして発表日を更新 */
        $skipPresenter->setLastPublishDate(Carbon::now());
        $this->em->persist($skipPresenter);
        $this->em->flush();

        $this->response($this->makeMentionName() . ' LTを次の人に回るようにしました。');
    }
}