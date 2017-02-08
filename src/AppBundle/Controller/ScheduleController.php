<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Support\SlackWebhookTokenAuthenticated;

class ScheduleController extends BaseRestController implements SlackWebhookTokenAuthenticated
{

    public function postCancelAction()
    {
        $this->get('schedule_cancel_logic')->execute();
    }

    public function postPostponeAction()
    {
        $this->get('schedule_postpone_logic')->execute();
    }

    public function postSkipAction()
    {
        $this->get('schedule_skip_logic')->execute();
    }
}
