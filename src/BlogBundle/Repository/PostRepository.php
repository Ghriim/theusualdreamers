<?php

namespace BlogBundle\Repository;

use CommonBundle\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PostRepository
 *
 * @package BlogBundle\Repository
 */
class PostRepository extends AbstractBaseRepository
{
    /**
     * @return string
     */
    public function getAlias ()
    {
        return 'post';
    }

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $slug
     *
     * @return bool
     */
    public function addCriterionSlug (QueryBuilder $queryBuilder, $slug)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'slug', $slug);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param \DateTime    $date
     *
     * @return bool
     */
    public function addCriterionPublicationBefore (QueryBuilder $queryBuilder, \DateTime $date)
    {
        if (null === $date) {
            return false;
        }

        $queryBuilder->andWhere($this->getAlias() . '.publication <= :date');
        $queryBuilder->setParameter('date', $date);

        return false;
    }
}