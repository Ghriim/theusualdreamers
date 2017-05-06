<?php

namespace CommonBundle\Controller;

use CommonBundle\Controller\Traits\RepositoryTrait;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

/**
 * Class AbstractBaseController
 *
 * @package CommonBundle\Controller
 */
abstract class AbstractBaseController extends Controller
{
    use RepositoryTrait;

    /**
     * @return EntityManager
     */
    protected function getEntityManager ()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return Router
     */
    protected function getRouter ()
    {
        return $this->get('router');
    }

    /**
     * @return Translator
     */
    protected function getTranslator ()
    {
        return $this->get('translator');
    }
}