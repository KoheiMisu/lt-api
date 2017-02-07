<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Support\SlackWebhookTokenAuthenticated;

class ScheduleController extends BaseRestController implements ClassResourceInterface,SlackWebhookTokenAuthenticated
{

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

    /**
     * @param Request $request
     */
    public function postSkipAction(Request $request)
    {
        $this->get('schedule_manager')->skip();
    }
}
