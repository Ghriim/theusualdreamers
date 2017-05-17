<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 *
 * @package BlogBundle\Controller
 */
class PostController extends AbstractBaseController
{
    const RELATED_POST_LIMIT = 3;

    /**
     * @return Response
     */
    public function listAction ()
    {
        $posts = $this->getPostRepository()->getManyByCriteria(
            [
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_PUBLISHED
            ],
            [],
            [
                'publication' => 'DESC'
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
     * @param Request $request
     * @param string  $slug
     *
     * @return Response
     */
    public function detailsAction (Request $request, $slug)
    {
        /** @var Post $post */
        $post = $this->getPostRepository()->getOneByCriteria(
            [
                'slug'              => $slug,
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_PUBLISHED
            ]
        );

        if (!$post) {
            throw new NotFoundHttpException();
        }

        $comments = $this->getCommentRepository()->getManyByCriteria(
            [
                'post'     => $post->getId(),
                'locale'   => $request->get('_locale'),
                'noParent' => true
            ]
        );

        $relatedPosts = $this->getPostRepository()->getManyByCriteria(
            [
                'category'          => $post->getCategory(),
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_PUBLISHED,
                'excludedId'        => $post->getId()
            ],
            [],
            [
                'publication'   => 'DESC'
            ],
            self::RELATED_POST_LIMIT
        );

        return $this->render(
            'BlogBundle:Post:details.html.twig',
            [
                'post'         => $post,
                'relatedPosts' => $relatedPosts,
                'comments'     => $comments
            ]
        );
    }
}
