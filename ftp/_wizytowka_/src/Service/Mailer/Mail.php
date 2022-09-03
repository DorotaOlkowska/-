<?php

namespace App\Service\Mailer;

class Mail
{
    private $bodyText, $fromAddress, $fromName, $toAddress, $toName, $subject;

    /**
     * @return mixed
     */
    public function getBodyText()
    {
        return $this->bodyText;
    }

    /**
     * @param $message
     * @param $phone
     */
    public function setMessage($message)
    {
        $this->bodyText = $message;
    }

    /**
     * @param mixed $bodyText
     */
    public function setBodyText($bodyText)
    {
        $this->bodyText = $bodyText;
    }

    /**
     * @return mixed
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * @param mixed $toName
     */
    public function setToName($toName)
    {
        $this->toName = $toName;
    }

    /**
     * @return mixed
     */
    public function getToAddress()
    {
        return $this->toAddress;
    }

    /**
     * @param mixed $toAddress
     */
    public function setToAddress($toAddress)
    {
        $this->toAddress = $toAddress;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param mixed $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return mixed
     */
    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    /**
     * @param mixed $fromAddress
     */
    public function setFromAddress($fromAddress)
    {
        $this->fromAddress = $fromAddress;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return sprintf('%s <%s>', $this->getToName(), $this->getToAddress());
    }

    public function getFrom()
    {
        return sprintf('%s <%s>', $this->getFromName(), $this->getFromAddress());
    }

}