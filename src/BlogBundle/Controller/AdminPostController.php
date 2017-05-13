<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\Type\PostType;
use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdminPostController
 *
 * @package BlogBundle\Controller
 */
class AdminPostController extends AbstractBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction (Request $request)
    {
        $queryBuilder = $this->getPostRepository()->getManyByCriteriaQueryBuilder();

        $pagination = $this->getPaginator()->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            self::DEFAULT_PAGINATOR
        );

        return $this->render(
            'BlogBundle:AdminPost:list.html.twig',
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
    public function previewAction (Request $request, $slug)
    {
        $post = $this->getPostRepository()->getOneByCriteria(['slug' => $slug]);
        if (!$post) {
            throw new NotFoundHttpException();
        }

        return $this->render(
            'BlogBundle:Post:details.html.twig',
            [
                'post'   => $post,
                'locale' => $request->get('_locale'),
                'mode'   => self::MODE_ADMIN
            ]
        );
    }

    /**
     * @param null|string $slug
     * @param Request     $request
     *
     * @return RedirectResponse|Response
     */
    public function saveAction (Request $request, $slug = null)
    {
        $post = new Post();
        if (null !== $slug) {
            $post = $this->getPostRepository()->getOneByCriteria(['slug' => $slug]);
            if (!$post) {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(
            PostType::class,
            $post,
            [
                'method' => $slug ? 'PUT' : 'POST',
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            $messageKey = $slug ? 'blog.post.edit.success' : 'blog.post.create.success';
            $this->addFlash(
                'success',
                $this->getTranslator()->trans($messageKey, [], 'messages')

            );

            return $this->redirectToRoute('blog_admin_post_edit', ['slug' => $post->getEnglishSlug()]);
        }

        return $this->render(
            'BlogBundle:AdminPost:save.html.twig',
            [
                'form' => $form->createView(),
                'post' => $post
            ]
        );
    }
}