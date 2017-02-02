<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class PostController extends BaseRestController implements ClassResourceInterface
{


    /**
     * @return array
     */
    public function cgetAction()
    {
        $posts = $this->getPostRepository()->findAll();

        return $posts;
    }

    /**
     * get the post
     *
     * @param $id
     *
     * @return Post
     */
    public function getAction(int $id)
    {
        $post = $this->getPostRepository()->find($id);
        return $post;
    }

    /**
     * @param Request $request
     *
     * @return Post|\Symfony\Component\Form\Form
     */
    public function postAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', new PostType(), $post = new Post(), [
            'csrf_protection' => false,
        ]);

        /**
         * HttpFoundationRequestHandlerのhandleRequestが動く
         */
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($post);
            $this->getEntityManager()->flush();

            return $post;
        }

        return $form;
    }

    /**
     * get collection of comments under the post
     *
     * @param $id
     *
     * @return Comment
     */
    public function getCommentsAction(int $id)
    {
        $comments = $this->getPostRepository()->find($id)->getComments();
        return $comments;
    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return Comment|\Symfony\Component\Form\Form
     */
    public function postCommentAction(int $id, Request $request)
    {
        $comment = new Comment();
        $comment->setPost($this->getPostRepository()->find($id));

        $form = $this->get('form.factory')->createNamed('', new CommentType(), $comment, [
            'csrf_protection' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush();

            return $comment;
        }

        return $form;
    }
}