<?php

namespace CommonBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use CommonBundle\Entity\AbstractBaseEntity;

/**
 * Class AbstractBaseRepository
 *
 * @package LDMR\CommonBundle\Repository
 */
abstract class AbstractBaseRepository extends EntityRepository implements RepositoryInterface
{
    const ORDER_DIRECTION_ASC  = 'ASC';
    const ORDER_DIRECTION_DESC = 'DESC';

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder ()
    {
        return $this->createQueryBuilder($this->getAlias())
                    ->select('DISTINCT ' . $this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function getOneByCriteria (array $criteria = [], array $selects = [])
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addSelects($queryBuilder, $this->addDefaultSelect($selects));

        $this->cleanQueryBuilder($queryBuilder);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getManyByCriteriaQueryBuilder (array $criteria = [], array $selects = [], array $orders = [])
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addOrderBys($queryBuilder, $orders)
             ->addSelects($queryBuilder, $this->addDefaultSelect($selects));
        $this->cleanQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    /**
     * @param array $criteria
     * @param array $selects
     * @param array $orders
     * @param int   $limit
     *
     * @return array
     */
    public function getManyByCriteria (array $criteria = [], array $selects = [], array $orders = [], $limit = null)
    {
        $queryBuilder = $this->getManyByCriteriaQueryBuilder($criteria, $selects, $orders);
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $criteria
     *
     * @return $this
     */
    public function addCriteria (QueryBuilder $queryBuilder, array $criteria = [])
    {
        foreach ($criteria as $field => $value) {
            if ($field) {
                $this->{'addCriterion' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param mixed        $value
     * @param boolean      $exclude If true, we search different value
     *
     * @return boolean Condition was added or not
     */
    public function addCriterion (QueryBuilder $queryBuilder, $alias, $fieldName, $value, $exclude = false)
    {
        list($condition, $parameter, $value) = $this->computeCriterionCondition($alias, $fieldName, $value, $exclude);
        if (is_null($condition)) {
            return false;
        }
        $queryBuilder->andWhere($condition);
        if (!is_null($parameter)) {
            $queryBuilder->setParameter($parameter, $value);
        }

        return true;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param string       $value
     *
     * @return bool
     */
    public function addCriterionLike (QueryBuilder $queryBuilder, $alias, $fieldName, $value)
    {
        if (is_null($value)) {
            return false;
        }
        $parameter = $alias . "_" . $fieldName;
        $value     = "%" . $value . "%";
        $queryBuilder->andWhere("$alias.$fieldName LIKE :" . $parameter);
        $queryBuilder->setParameter($parameter, $value);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionId (QueryBuilder $queryBuilder, $id)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'id', $id);
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionExcludedStatus (QueryBuilder $queryBuilder, $excludedStatus)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $excludedStatus, true);
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionStatus (QueryBuilder $queryBuilder, $status)
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $status);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $orderBys
     *
     * @return $this
     */
    public function addOrderBys (QueryBuilder $queryBuilder, array $orderBys = [])
    {
        foreach ($orderBys as $orderBy => $direction) {
            if ($orderBy) {
                $this->{'addOrderBy' . ucfirst($orderBy)}($queryBuilder, $direction);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param string       $direction
     */
    public function addOrderBy (QueryBuilder $queryBuilder, $alias, $fieldName, $direction)
    {
        if (!in_array($direction, [self::ORDER_DIRECTION_DESC, self::ORDER_DIRECTION_ASC])) {
            throw new \LogicException($direction . ' is not a valid value for order by "direction" parameter.');
        }
        $queryBuilder->addOrderBy($alias . '.' . $fieldName, $direction);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $selects
     *
     * @return $this
     */
    public function addSelects (QueryBuilder $queryBuilder, array $selects = [])
    {
        foreach ($selects as $select) {
            if ($select) {
                $this->{'addSelect' . ucfirst($select)}($queryBuilder);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function cleanQueryBuilder (QueryBuilder $queryBuilder)
    {
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'join');
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'select');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $dqlPartName ("join", "select", ...)
     */
    public function cleanQueryBuilderDqlPart (QueryBuilder $queryBuilder, $dqlPartName)
    {
        $dqlPart    = $queryBuilder->getDQLPart($dqlPartName);
        $newDqlPart = [];
        if (count($dqlPart)) {
            $queryBuilder->resetDQLPart($dqlPartName);
            if ($dqlPartName == 'join') {
                foreach ($dqlPart as $root => $elements) {
                    foreach ($elements as $element) {
                        preg_match(
                            '/^(?P<joinType>[^ ]+) JOIN (?P<join>[^ ]+) (?P<alias>[^ ]+)/', $element->__toString(),
                            $matches
                        );
                        if (!array_key_exists($matches['alias'], $newDqlPart)) {
                            $newDqlPart[$matches['alias']] = $element;
                        }
                    }
                    $dqlPart[$root] = array_values($newDqlPart);
                }
                $dqlPart = array_shift($dqlPart);
                foreach ($dqlPart as $element) {
                    $queryBuilder->add($dqlPartName, [$element], true);
                }

                return;
            }
            foreach ($dqlPart as $element) {
                $newDqlPart[$element->__toString()] = $element;
            }
            $dqlPart = array_values($newDqlPart);
            foreach ($dqlPart as $element) {
                $queryBuilder->add($dqlPartName, $element, true);
            }
        }
    }

    /**
     * @param string  $alias
     * @param string  $fieldName
     * @param mixed   $value
     * @param boolean $exclude If true, we search different value
     *
     * @return array
     */
    public function computeCriterionCondition ($alias, $fieldName, $value, $exclude = false)
    {
        $operator       = $exclude ? '!=' : '=';
        $condition      = $alias . '.' . $fieldName . ' ' . $operator . ' :' . $alias . '_' . $fieldName;
        $parameterField = $alias . '_' . $fieldName;
        $parameterValue = $value !== false && empty($value) ? null : $value;
        if (is_null($value)) {
            return [null, null, null];
        }
        elseif (is_array($value)) {
            $operator  = $exclude ? 'NOT IN' : 'IN';
            $condition = $alias . '.' . $fieldName . ' ' . $operator . ' (:' . $alias . '_' . $fieldName . ')';

            return [$condition, $parameterField, $parameterValue];
        }
        elseif ('NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NULL';

            return [$condition, null, null];
        }
        elseif ('NOT NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NOT NULL';

            return [$condition, null, null];
        }

        return [$condition, $parameterField, $parameterValue];
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function addGenericCriteria (array $criteria = [])
    {
        if (property_exists($this->getEntityName(), 'status')
            && (!array_key_exists('status', $criteria)
                || is_null(
                    $criteria['status']
                ))
        ) {
            $excludedStatus             = isset($criteria['excludedStatus']) ? $criteria['excludedStatus'] : [];
            $excludedStatus             = is_array($excludedStatus) ? $excludedStatus : [$excludedStatus];
            $criteria['excludedStatus'] = array_merge([AbstractBaseEntity::STATUS_DELETED], $excludedStatus);
        }

        return $criteria;
    }

    /**
     * @param array $selects
     *
     * @return array
     */
    public function addDefaultSelect (array $selects = [])
    {
        return array_merge($selects, $this->getDefaultSelects());
    }

    /**
     * @return array
     */
    protected function getDefaultSelects ()
    {
        return [];
    }
}