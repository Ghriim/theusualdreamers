<?php

namespace BlogBundle\Entity;

use CommonBundle\Entity\AbstractBaseEntity;
use CommonBundle\Utils\DateTools;
use CommonBundle\Utils\StringTools;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use UserBundle\Entity\User;

/**
 * Class Post
 *
 * @package BlogBundle\Entity
 */
class Post extends AbstractBaseEntity
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT     = 'draft';
    const STATUS_BACK_LOG  = 'back-log';

    /**
     * @var string $englishTitle
     */
    protected $englishTitle;

    /**
     * @var string $englishSlug
     */
    protected $englishSlug;

    /**
     * @var string $frenchTitle
     */
    protected $frenchTitle;

    /**
     * @var string $frenchSlug
     */
    protected $frenchSlug;

    /**
     * @var string $cover
     */
    protected $cover;

    /**
     * @var string $englishContent
     */
    protected $englishContent;

    /**
     * @var string $frenchContent
     */
    protected $frenchContent;

    /**
     * @var string $category
     */
    protected $category;

    /**
     * @var \DateTime $publication
     */
    protected $publication;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    public function getDefaultStatus ()
    {
        return self::STATUS_BACK_LOG;
    }


    /**
     * @return string
     */
    public function getEnglishTitle ()
    {
        return $this->englishTitle;
    }

    /**
     * @param string $englishTitle
     *
     * @return $this
     */
    public function setEnglishTitle ($englishTitle)
    {
        $this->englishTitle = $englishTitle;
        $this->englishSlug  = StringTools::slugify($englishTitle);

        return $this;
    }

    /**
     * @return string
     */
    public function getEnglishSlug ()
    {
        return $this->englishSlug;
    }

    /**
     * @return string
     */
    public function getFrenchTitle ()
    {
        return $this->frenchTitle;
    }

    /**
     * @param string $frenchTitle
     *
     * @return $this
     */
    public function setFrenchTitle ($frenchTitle)
    {
        $this->frenchTitle = $frenchTitle;
        $this->frenchSlug  = StringTools::slugify($frenchTitle);

        return $this;
    }

    /**
     * @return string
     */
    public function getFrenchSlug ()
    {
        return $this->frenchSlug;
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
    public function getEnglishContent ()
    {
        return $this->englishContent;
    }

    /**
     * @param string $englishContent
     *
     * @return $this
     */
    public function setEnglishContent ($englishContent)
    {
        $this->englishContent = $englishContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrenchContent ()
    {
        return $this->frenchContent;
    }

    /**
     * @param string $frenchContent
     *
     * @return $this
     */
    public function setFrenchContent ($frenchContent)
    {
        $this->frenchContent = $frenchContent;

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
     * @return User
     */
    public function getUser ()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser ($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedTitle($locale = 'en')
    {
        if ('en' === $locale) {
            return $this->getEnglishTitle();
        } elseif ('fr' === $locale) {
            return $this->getFrenchTitle();
        }

        throw new \LogicException();
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedSlug($locale = 'en')
    {
        if ('en' === $locale) {
            return $this->getEnglishSlug();
        } elseif ('fr' === $locale) {
            return $this->getFrenchSlug();
        }

        throw new \LogicException();
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedContent($locale = 'en')
    {
        if ('en' === $locale) {
            return $this->getEnglishContent();
        } elseif ('fr' === $locale) {
            return $this->getFrenchContent();
        }

        throw new \LogicException();
    }



    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedAbstract($locale = 'en')
    {
        if ('en' === $locale) {
            return StringTools::getStringBetween($this->getEnglishContent(), '<p>', '</p>');
        } elseif ('fr' === $locale) {
            return StringTools::getStringBetween($this->getFrenchContent(), '<p>', '</p>');
        }

        throw new \LogicException();
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedPublicationDate($locale = 'en')
    {
        if ($publication = $this->getPublication()) {
            return $this->getPublication()->format(DateTools::getLocalizedDateFormat($locale));
        }

        return null;
    }

    /**
     * @param ExecutionContextInterface $context
     *
     * @param                           $payload
     */
    public function validate (ExecutionContextInterface $context, $payload)
    {
        $isComplete = !empty($this->getEnglishContent())
                         && !empty($this->getFrenchContent())
                         && null !== $this->getCover()
                         && null !== $this->getCategory()
                         && null !== $this->getPublication();

        if (self::STATUS_PUBLISHED === $this->getStatus() && false === $isComplete) {
            $context->buildViolation('A Post can only be published if it is entirely written')
                    ->atPath('global')
                    ->addViolation();
        }
    }
}