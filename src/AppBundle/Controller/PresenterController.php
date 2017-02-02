<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\Presenter;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use AppBundle\Form\PresenterType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class PresenterController extends BaseRestController implements ClassResourceInterface
{
    /**
     * @return array
     */
    public function cgetAction()
    {
        $posts = $this->getPresenterRepository()->findAll();

        return $posts;
    }

    /**
     * @param Request $request
     *
     * @return Post|\Symfony\Component\Form\Form
     */
    public function postAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', new PresenterType(), $presenter = new Presenter(), [
            'csrf_protection' => false,
        ]);

        /**
         * HttpFoundationRequestHandlerのhandleRequestが動く
         */
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($presenter);
            $this->getEntityManager()->flush();

            return $presenter;
        }

        return $form;
    }
}
