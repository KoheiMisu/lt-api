<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Support\SlackWebhookTokenAuthenticated;

class ScheduleController extends BaseRestController implements SlackWebhookTokenAuthenticated
{

    /**
     * @param Request $request
     */
    public function postCancelAction(Request $request)
    {
        $logic = $this->get('schedule_cancel_logic')->setRequest($request);
        $this->get('schedule_manager')->scheduleChange($logic);
    }

    /**
     * @param Request $request
     */
    public function postPostponeAction(Request $request)
    {
        $logic = $this->get('schedule_postpone_logic')->setRequest($request);
        $this->get('schedule_manager')->scheduleChange($logic);
    }

    /**
     * @param Request $request
     */
    public function postSkipAction(Request $request)
    {
        $logic = $this->get('schedule_skip_logic')->setRequest($request);
        $this->get('schedule_manager')->scheduleChange($logic);
    }
}
