<?php

namespace BlogBundle\Entity;

use CommonBundle\Entity\AbstractBaseEntity;

/**
 * Class Post
 *
 * @package BlogBundle\Entity
 */
class Post extends AbstractBaseEntity
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $slug
     */
    protected $slug;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @var \DateTime $publication
     */
    protected $publication;

    /**
     * {@inheritdoc}
     */
    public function getDefaultStatus ()
    {
        return self::STATUS_PENDING;
    }

    /**
     * @return string
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle ($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug ()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug ($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent ()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent ($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublication ()
    {
        return $this->publication;
    }

    /**
     * @param \DateTime $publication
     *
     * @return $this
     */
    public function setPublication ($publication)
    {
        $this->publication = $publication;

        return $this;
    }
}