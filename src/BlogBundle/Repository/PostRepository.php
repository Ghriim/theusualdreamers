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
     * @param QueryBuilder   $queryBuilder
     * @param int|int[]|null $id
     *
     * @return bool
     */
    public function addCriterionExcludedId (QueryBuilder $queryBuilder, $id)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'id', $id, true);
    }

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $slug
     *
     * @return bool
     */
    public function addCriterionSlug (QueryBuilder $queryBuilder, $slug)
    {
        if (!$slug) {
            return false;
        }

        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like($this->getAlias() . '.englishSlug', ':slug'),
                $queryBuilder->expr()->like($this->getAlias(). '.frenchSlug', ':slug')
            )
        );

        $queryBuilder->setParameter('slug', $slug);

        return true;
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

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $category
     *
     * @return bool
     */
    public function addCriterionCategory (QueryBuilder $queryBuilder, $category)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'category', $category);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $direction
     */
    public function addOrderByPublication (QueryBuilder $queryBuilder, $direction)
    {
        $this->addOrderBy($queryBuilder, $this->getAlias(), 'publication', $direction);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $direction
     */
    public function addOrderByCreated (QueryBuilder $queryBuilder, $direction)
    {
        $this->addOrderBy($queryBuilder, $this->getAlias(), 'created', $direction);
    }
}