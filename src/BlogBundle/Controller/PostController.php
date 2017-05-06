<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController
 *
 * @package BlogBundle\Controller
 */
class PostController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        try {
            $this->getDoctrine()->getManager()->getConnection()->connect();
        } catch (\Exception $e) {
            // failed to connect
        }

        return $this->render('BlogBundle:Post:index.html.twig');
    }
}
