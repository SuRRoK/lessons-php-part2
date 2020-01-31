<?php

namespace app\models;

use app\models\MailMailer;
use Swift_Message;

class MailSend
{
    private $mailer;
    private $message;

    public function __construct(MailMailer $mailer, Swift_Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    /**
     * @param $mail_login
     * @param $mail_password
     * @return \Swift_Mailer
     */
    public function InitTransport($mail_login, $mail_password)
    {
        return $this->mailer->setTransport($mail_login, $mail_password);
    }

    /**
     * @param $mail_from_mail
     * @param $mail_from_name
     * @param $mail_to
     * @param $mail_subject
     * @param $mail_content
     * @return Swift_Message
     */
    public function newMail($mail_from_mail, $mail_from_name, $mail_to, $mail_subject, $mail_content)
    {
        $this->message
            ->setFrom([$mail_from_mail => $mail_from_name])
            ->setTo([$mail_to])
            ->setSubject($mail_subject)
            ->addPart($mail_content);

        return $this->message;
    }
}