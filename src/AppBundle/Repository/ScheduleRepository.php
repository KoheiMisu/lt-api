<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Presenter;
use Carbon\Carbon;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findPostpone()
    {
        $qb = $this
            ->createQueryBuilder('s')
            ->where('s.status = :status')
            ->andWhere('s.publishDate = :publishDate')
            ->setParameter('status', 2)
            ->setParameter('publishDate', new Carbon('last friday'))
            ->getQuery();

        return $qb->getResult();
    }

    /**
     * @param Presenter $presenter
     *
     * @return array
     */
    public function findLatestByPresenter(Presenter $presenter)
    {
        $qb = $this
            ->createQueryBuilder('s')
            ->where('s.presenter = :presenter')
            ->orderBy("s.publishDate", 'DESC')
            ->setParameter('presenter', $presenter)
            ->getQuery();

        return $qb->getSingleResult();
    }
}
