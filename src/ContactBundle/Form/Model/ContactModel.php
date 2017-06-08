<?php

namespace ContactBundle\Form\Model;

/**
 * Class ContactModel
 *
 * @package ContactBundle\Form\Model
 */
class ContactModel
{
    /**
     * @var string $senderName
     */
    protected $senderName;

    /**
     * @var string $senderEmail
     */
    protected $senderEmail;

    /**
     * @var string $subject
     */
    protected $subject;

    /**
     * @var string $content
     */
    protected $content;

    /**
     * @return string
     */
    public function getSenderName ()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     *
     * @return $this
     */
    public function setSenderName ($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderEmail ()
    {
        return $this->senderEmail;
    }

    /**
     * @param string $senderEmail
     *
     * @return $this
     */
    public function setSenderEmail ($senderEmail)
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject ()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject ($subject)
    {
        $this->subject = $subject;

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
}