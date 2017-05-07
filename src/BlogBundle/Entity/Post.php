<?php

namespace BlogBundle\Entity;

use CommonBundle\Entity\AbstractBaseEntity;
use CommonBundle\Utils\StringTools;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var string $cover
     */
    protected $cover;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @var string $category
     */
    protected $category;

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
        $this->slug  = StringTools::slugify($title);

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
     * @return string
     */
    public function getCover ()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     *
     * @return $this
     */
    public function setCover ($cover)
    {
        $this->cover = $cover;

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
    public function getCategory ()
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return $this
     */
    public function setCategory ($category)
    {
        $this->category = $category;

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

    /**
     * @param ExecutionContextInterface $context
     *
     * @param                           $payload
     */
    public function validate (ExecutionContextInterface $context, $payload)
    {
        $isComplete = !empty($this->getContent())
                         && null !== $this->getCover()
                         && null !== $this->getCategory()
                         && null !== $this->getPublication();

        if (self::STATUS_ACTIVE === $this->getStatus() && false === $isComplete) {
            $context->buildViolation('A Post can only be published if it is entirely written')
                    ->atPath('global')
                    ->addViolation();
        }
    }
}