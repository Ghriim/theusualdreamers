<?php

namespace BlogBundle\Entity;

use CommonBundle\Entity\AbstractBaseEntity;

/**
 * Class Comment
 *
 * @package BlogBundle\Entity
 */
class Comment extends AbstractBaseEntity
{
    /**
     * @var string $authorName
     */
    protected $authorName;

    /**
     * @var string $authorEmail
     */
    protected $authorEmail;

    /**
     * @var string $authorWebsite
     */
    protected $authorWebsite;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var bool $notifyOnReply
     */
    protected $notifyOnReply = false;

    /**
     * @var Comment $parent
     */
    protected $parent;

    /**
     * @var Comment[] $children
     */
    protected $children;

    /**
     * @var Post $post
     */
    protected $post;

    /**
     * {@inheritdoc}
     */
    public function getDefaultStatus ()
    {
        return self::STATUS_ACTIVE;
    }

    /**
     * @return string
     */
    public function getAuthorName ()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     *
     * @return $this
     */
    public function setAuthorName ($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorEmail ()
    {
        return $this->authorEmail;
    }

    /**
     * @param string $authorEmail
     *
     * @return $this
     */
    public function setAuthorEmail ($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorWebsite ()
    {
        return $this->authorWebsite;
    }

    /**
     * @param string $authorWebsite
     *
     * @return $this
     */
    public function setAuthorWebsite ($authorWebsite)
    {
        $this->authorWebsite = $authorWebsite;

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
     * @return string
     */
    public function getLocale ()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale ($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNotifyOnReply ()
    {
        return $this->notifyOnReply;
    }

    /**
     * @param bool $notifyOnReply
     *
     * @return $this
     */
    public function setNotifyOnReply ($notifyOnReply)
    {
        $this->notifyOnReply = $notifyOnReply;

        return $this;
    }

    /**
     * @return Comment
     */
    public function getParent ()
    {
        return $this->parent;
    }

    /**
     * @param Comment $parent
     *
     * @return $this
     */
    public function setParent ($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Comment[]
     */
    public function getChildren ()
    {
        return $this->children;
    }

    /**
     * @param Comment[] $children
     *
     * @return $this
     */
    public function setChildren ($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost ()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function setPost (Post $post)
    {
        $this->post = $post;

        return $this;
    }
}