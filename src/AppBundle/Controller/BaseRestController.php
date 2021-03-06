<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

class BaseRestController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getPostRepository()
    {
        return $this->getEntityManager()->getRepository('AppBundle:Post');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getPresenterRepository()
    {
        return $this->getEntityManager()->getRepository('AppBundle:Presenter');
    }
}
