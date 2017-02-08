<?php

namespace AppBundle\Services\ScheduleLogic;

use AppBundle\Entity\Schedule;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseLogic
{
    /** @var EntityManager  */
    protected $em;

    /** @var Container  */
    protected $container;

    /**
     * ScheduleCreator constructor.
     *
     * @DI\InjectParams({
     *     "entityManager" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "container" = @DI\Inject("service_container")
     * })
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     */
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    abstract public function execute();

    /**
     * @param string $message
     */
    protected function response(string $message)
    {
        $slack = $this->container->get('slack');
        $slack->send($message);
    }

    /**
     * @return string
     */
    protected function makeMentionName()
    {
        return '@' . $this->getSlackUserName();
    }

    protected function getSlackUserName()
    {
        $request = $this->container->get('request');
        return $request->get('user_name');
    }
}