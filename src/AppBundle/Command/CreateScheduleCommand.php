<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 次週のスケジュールを作成して通知を行う
 *
 * Class CreateSchedule
 * @package AppBundle\Command
 */
class CreateScheduleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:notice-LT')
            ->setDescription('Create NextWeekSchedule And Notice Presenter');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //次週のスケジュール作成をしてから通知
        $this->getContainer()->get('schedule_manager')->notice();
    }
}