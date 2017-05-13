<?php

namespace BlogBundle\Repository;

use CommonBundle\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CommentRepository
 *
 * @package BlogBundle\Repository
 */
class CommentRepository extends AbstractBaseRepository
{
    /**
     * @return string
     */
    public function getAlias ()
    {
        return 'comment';
    }

    /**
     * @param QueryBuilder   $queryBuilder
     * @param int|int[]|null $id
     *
     * @return bool
     */
    public function addCriterionPost(QueryBuilder $queryBuilder, $id)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'post', $id);
    }

    /**
     * @param QueryBuilder   $queryBuilder
     * @param string|string[]|null $locale
     *
     * @return bool
     */
    public function addCriterionLocale(QueryBuilder $queryBuilder, $locale)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'locale', $locale);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param bool         $proceed
     *
     * @return bool
     */
    public function addCriterionNoParent (QueryBuilder $queryBuilder, $proceed)
    {
        if (true === $proceed) {
            return $this->addCriterion($queryBuilder, $this->getAlias(), 'parent', 'NULL');
        }

        return false;
    }
}