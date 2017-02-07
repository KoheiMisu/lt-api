<?php

namespace AppBundle\Services;

use AppBundle\Entity\Schedule;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Carbon\Carbon;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("schedule_creator")
 */
class ScheduleCreator
{
    /** @var  Schedule[] */
    private $nextWeekSchedule=[];

    /** @var EntityManager  */
    private $em;

    /** @var Container  */
    private $container;

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

    /**
     * @return void
     */
    public function create()
    {
        $this->checkPostPone();

        //延期の場合は、ユーザの更新や次週のスケジュールを作らない
        if ($this->getNextWeekSchedules()) {
            return;
        }

        $this->updatePresenter();
        $this->createSchedule();
    }

    /**
     * @return \AppBundle\Entity\Schedule[]
     */
    public function getNextWeekSchedules()
    {
        return $this->nextWeekSchedule;
    }

    /**
     * @param Schedule[]
     *
     * @return \AppBundle\Entity\Schedule[]
     */
    public function setNextWeekSchedules($schedules)
    {
        $this->nextWeekSchedule = $schedules;
    }

    /**
     * 今週のスケジュールが延期でないかチェックする
     *
     * @return void
     */
    private function checkPostPone()
    {
        $postpones = $this->em->getRepository('AppBundle:Schedule')->findPostpone();
        if ($postpones) {
            $this->setNextWeekSchedules($postpones);
        }
    }

    /**
     * 発表者のlastPublishDateを更新する
     *
     * @return void
     */
    private function updatePresenter()
    {
        $schedules = $this->em->getRepository('AppBundle:Schedule')->findBy(['publishDate' => new Carbon('last friday')]);
        foreach ($schedules as $schedule) {
            //scheduleがreadyの発表者のみ更新
            if ($schedule->getStatus() === 1) {
                $presenter = $schedule->getPresenter();
                $presenter->setLastPublishDate(Carbon::now());
                $this->em->persist($presenter);
                $this->em->flush();
            }
        }
    }

    /**
     * @return void
     */
    private function createSchedule()
    {
        $schedules = [];
        $presenters = $this->em->getRepository('AppBundle:Presenter')
            ->findBy([], ['lastPublishDate' => 'ASC'], $this->container->getParameter('presenter_per_week'));

        foreach ($presenters as $presenter) {
            $schedule = new Schedule();
            $schedule
                ->setPresenter($presenter)
                ->setPublishDate(new Carbon('next friday'));
            $this->em->persist($schedule);
            $this->em->flush();
            $schedules[] = $schedule;
        }

        $this->setNextWeekSchedules($schedules);
    }
}