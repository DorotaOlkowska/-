<?php

namespace App\Service\Mailer;

use App\Service\Logger\Logger;
use App\Service\Logger\LoggerLevel;
use App\Service\ServiceInterface;

class Mailer implements ServiceInterface
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Mail $mail
     * @throws \App\Service\Logger\LoggerException
     */
    public function send(Mail $mail)
    {
        $headers = array(
            sprintf('From: %s', $mail->getFrom()),
            sprintf('Reply-To: %s', $mail->getFrom()),
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
        );

        $results = $this->sendMail($mail->getTo(), $mail->getSubject(), $mail->getBodyText(),  implode("\r\n", $headers));

        $this->logger->log(sprintf('Send mail report parameters: %s\n Status: %s', print_r(array(
            'to' => $mail->getTo(),
            'subject' => $mail->getSubject(),
            'body' => $mail->getBodyText(),
            'headers' => $headers
        ), true), $this->getStatusAsString($results)), LoggerLevel::INFO);
    }

    /**
     * @param $results
     * @return string
     */
    private function getStatusAsString($results)
    {
        if($results)
        {
            return 'Success';
        }
        else
        {
            return sprintf('Failed %s', print_r(error_get_last(), true));
        }
    }

    protected function sendMail($to, $subject, $body, $headers)
    {
        return mail($to, $subject, $body, $headers);
    }
}