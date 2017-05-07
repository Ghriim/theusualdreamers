<?php

namespace CommonBundle\Entity;

/**
 * Class AbstractBaseEntity
 *
 * @package CommonBundle\Entity
 */
abstract class AbstractBaseEntity
{
    const STATUS_DELETED = 'deleted';

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var \DateTime $created
     */
    protected $created;

    /**
     * @return string
     */
    abstract public function getDefaultStatus ();

    public function __construct ()
    {
        $this->setStatus($this->getDefaultStatus());
    }

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

    /**
     * @return string
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus ($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated ()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated ($created)
    {
        $this->created = $created;

        return $this;
    }

    public function logCreated ()
    {
        if (!$this->created) {
            $created = new \DateTime();
            $this->setCreated($created);
        }
    }

    /**
     * @return bool
     */
    public function isNew ()
    {
        return $this->id ? false : true;
    }
}