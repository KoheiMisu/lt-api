<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class ScheduleController extends BaseRestController implements ClassResourceInterface
{
    /**
     *
     */
    public function cgetAction()
    {
        //次週のスケジュール作成をしてから通知
        $this->get('schedule_manager')->notice();
    }

    /**
     * @param Request $request
     */
    public function postCancelAction(Request $request)
    {
        $this->get('schedule_manager')->cancel();
    }

    /**
     * @param Request $request
     */
    public function postPostponeAction(Request $request)
    {
        $this->get('schedule_manager')->postpone();
    }
}
