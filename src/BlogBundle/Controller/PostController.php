<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 *
 * @package BlogBundle\Controller
 */
class PostController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function listAction ()
    {
        $posts = $this->getPostRepository()->getManyByCriteria(
            [
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_ACTIVE
            ]
        );

        return $this->render(
            'BlogBundle:Post:list.html.twig',
            [
                'posts' => $posts
            ]
        );
    }

    /**
     * @param string $slug
     *
     * @return Response
     */
    public function detailsAction ($slug)
    {
        $post = $this->getPostRepository()->getOneByCriteria(
            [
                'slug' => $slug,
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_ACTIVE
            ]
        );

        if (!$post) {
            throw new NotFoundHttpException();
        }

        return $this->render(
            'BlogBundle:Post:details.html.twig',
            [
                'post' => $post
            ]
        );
    }
}
