<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\Type\PostType;
use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminPostController
 *
 * @package BlogBundle\Controller
 */
class AdminPostController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function listAction ()
    {
        $posts = $this->getPostRepository()->getManyByCriteria(
            [
                'publicationBefore' => new \DateTime(),
            ]
        );

        return $this->render(
            'BlogBundle:AdminPost:list.html.twig',
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
                'publicationBefore' => new \DateTime()
            ]
        );

        return $this->render(
            'BlogBundle:AdminPost:details.html.twig',
            [
                'post' => $post
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
            $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['slug' => $slug]);
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
            return $this->redirectToRoute('blog_admin_post_edit', ['slug' => $post->getSlug()]);
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