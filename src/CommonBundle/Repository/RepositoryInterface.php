<?php

namespace CommonBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface RepositoryInterface
 *
 * @package LDMR\CommonBundle\Repository
 */
interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getAlias ();

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder ();

    /**
     * @param array $criteria
     * @param array $selects
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function getOneByCriteria (array $criteria = [], array $selects = []);

    /**
     * @param array $criteria
     * @param array $orders
     * @param array $selects
     *
     * @return QueryBuilder
     */
    public function getManyByCriteriaQueryBuilder (array $criteria = [], array $selects = [], array $orders = []);

    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $id
     *
     * @return boolean
     */
    public function addCriterionId (QueryBuilder $queryBuilder, $id);

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $status
     *
     * @return boolean
     */
    public function addCriterionExcludedStatus (QueryBuilder $queryBuilder, $status);

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $status
     *
     * @return bool
     */
    public function addCriterionStatus (QueryBuilder $queryBuilder, $status);
}