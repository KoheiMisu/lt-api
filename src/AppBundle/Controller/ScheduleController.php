<?php

namespace AppBundle\Controller;

use AppBundle\Services\Slack;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use AppBundle\Controller\Support\SlackWebhookTokenAuthenticated;
use JMS\DiExtraBundle\Annotation as DI;

class ScheduleController extends BaseRestController implements SlackWebhookTokenAuthenticated
{
    /**
     * @var Slack
     * @DI\Inject("slack")
     */
    private $slack;

    public function postHelpAction()
    {
        $this->slack->send(file_get_contents($this->container->getParameter('help_content_file')));
    }

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
