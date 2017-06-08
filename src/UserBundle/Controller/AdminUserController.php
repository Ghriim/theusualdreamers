<?php

namespace UserBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminUserController
 *
 * @package UserBundle\Controller
 */
class AdminUserController extends AbstractBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction (Request $request)
    {
        $queryBuilder = $this->getUserRepository()->getManyByCriteriaQueryBuilder(
            [],
            [],
            ['username' => 'ASC']
        );

        $pagination = $this->getPaginator()->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            self::DEFAULT_PAGINATOR
        );

        return $this->render(
            'UserBundle:AdminUser:list.html.twig',
            [
                'pagination' => $pagination
            ]
        );
    }
}