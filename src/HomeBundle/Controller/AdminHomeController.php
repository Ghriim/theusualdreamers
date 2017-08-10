<?php

namespace HomeBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminHomeController
 *
 * @package HomeBundle\Controller
 */
class AdminHomeController extends AbstractBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction (Request $request)
    {
        $queryBuilder = $this->getCommentRepository()->getManyByCriteriaQueryBuilder(
            [],
            ['post'],
            ['created' => 'DESC']
        );

        $pagination = $this->getPaginator()->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            self::DEFAULT_PAGINATOR
        );

        return $this->render(
            'HomeBundle:AdminHome:index.html.twig',
            [
                'pagination' => $pagination
            ]
        );
    }
}