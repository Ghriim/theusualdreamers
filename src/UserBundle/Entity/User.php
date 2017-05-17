<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @package UserBundle\Entity
 */
class User extends BaseUser
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId ($id)
    {
        $this->id = $id;

        return $this;
    }
}