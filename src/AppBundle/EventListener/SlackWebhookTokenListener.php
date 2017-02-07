<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\Support\SlackWebhookTokenAuthenticated;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class SlackWebhookTokenListener
{
    /**
     * @var array
     */
    private $outGoingWebhookTokens;

    /**
     * SlackWebhookTokenListener constructor.
     *
     * @param array $outGoingWebhookTokens
     */
    public function __construct(array $outGoingWebhookTokens)
    {
        $this->outGoingWebhookTokens = $outGoingWebhookTokens;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof SlackWebhookTokenAuthenticated) {
            $token = $event->getRequest()->get('token');
            if (!in_array($token, $this->outGoingWebhookTokens)) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
        }
    }
}
