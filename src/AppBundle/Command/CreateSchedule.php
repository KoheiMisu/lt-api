<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * 次週のスケジュールを作成して通知を行う
 *
 * Class CreateSchedule
 * @package AppBundle\Command
 */
class CreateSchedule extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:notice-LT')
            ->setDescription('Create NextWeekSchedule And Notice Presenter');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //次週のスケジュール作成をしてから通知
        $this->getContainer()->get('schedule_manager')->notice();
    }
}