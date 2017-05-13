<?php

namespace HomeBundle\Controller;

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
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction (Request $request)
    {
        return $this->render(
            'HomeBundle:Home:index.html.twig', []
        );
    }
}