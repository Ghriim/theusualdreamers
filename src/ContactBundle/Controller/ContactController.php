<?php

namespace ContactBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 *
 * @package ContactBundle\Controller
 */
class ContactController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render("ContactBundle:Contact:index.html.twig");
    }
}