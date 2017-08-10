<?php

namespace HomeBundle\Controller;

use BlogBundle\Entity\Post;
use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 *
 * @package HomeBundle\Controller
 */
class HomeController extends AbstractBaseController
{
    const NUMBER_OF_POST = 4;

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction (Request $request)
    {
        $lastPosts = $this->getPostRepository()->getManyByCriteria(
            [
                'publicationBefore'    => new \DateTime(),
                'status'               => Post::STATUS_PUBLISHED,
                'availableForLanguage' => $request->get('_locale')
            ],
            [],
            [
                'publication' => 'DESC'
            ],
            self::NUMBER_OF_POST
        );

        return $this->render(
            'HomeBundle:Home:index.html.twig',
            [
                'posts' => $lastPosts
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function comingSoonAction (Request $request)
    {
        return $this->render(
            'HomeBundle:Home:coming-soon.html.twig', []
        );
    }
}