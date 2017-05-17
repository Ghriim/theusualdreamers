<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Comment;
use BlogBundle\Entity\Post;
use BlogBundle\Form\Type\CommentType;
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
    const DEFAULT_PUBLIC_POST_PAGINATOR = 15;

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction (Request $request)
    {
        $queryBuilder = $this->getPostRepository()->getManyByCriteriaQueryBuilder(
            [
                'publicationBefore' => new \DateTime(),
                'status'            => Post::STATUS_PUBLISHED
            ],
            [],
            [
                'publication' => 'DESC'
            ]
        );

        $pagination = $this->getPaginator()->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            self::DEFAULT_PUBLIC_POST_PAGINATOR
        );

        return $this->render(
            'BlogBundle:Post:list.html.twig',
            [
                'pagination' => $pagination
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

        $locale  = $request->get('_locale');
        $comment = new Comment();
        $commentForm = $this->createForm(
            CommentType::class,
            $comment,
            [
                'method' => 'POST',
            ]
        );

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setPost($post);
            $comment->setLocale($locale);

            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'blog_post_details',
                [
                    'slug'    => $slug,
                    '_locale' => $locale,
                    '_fragment' => 'comment-' . $comment->getId()
                ]
            );
        }

        $viewParams = $this->buildDetailsParameters($post, $request->get('_locale'));
        $viewParams['commentForm'] = $commentForm->createView();

        return $this->render('BlogBundle:Post:details.html.twig', $viewParams);
    }

    /**
     * @param Post   $post
     * @param string $locale
     *
     * @return array
     */
    protected function buildDetailsParameters (Post $post, $locale)
    {
        $comments = $this->getCommentRepository()->getManyByCriteria(
            [
                'post'     => $post->getId(),
                'locale'   => $locale,
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

        return [
            'post'         => $post,
            'relatedPosts' => $relatedPosts,
            'comments'     => $comments,
        ];
    }
}
