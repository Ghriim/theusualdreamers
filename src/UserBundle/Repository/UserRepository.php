<?php

namespace UserBundle\Repository;

use CommonBundle\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UserRepository
 *
 * @package UserBundle\Repository
 */
class UserRepository extends AbstractBaseRepository
{
    /**
     * @return string
     */
    public function getAlias ()
    {
        return 'user';
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $direction
     */
    public function addOrderByUsername (QueryBuilder $queryBuilder, $direction)
    {
        $this->addOrderBy($queryBuilder, $this->getAlias(), 'username', $direction);
    }
}