<?php

namespace AboutBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AboutController
 *
 * @package AboutBundle\Controller
 */
class AboutController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render("AboutBundle:About:index.html.twig");
    }
}