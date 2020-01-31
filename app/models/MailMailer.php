<?php

namespace app\models;

use Swift_SmtpTransport;
use Swift_Mailer;


class MailMailer
{
    protected $smtpTransport;

    public function __construct(Swift_SmtpTransport $smtpTransport)
    {
        $this->smtpTransport = $smtpTransport;
        //d($this->smtpTransport);
        //(new Swift_SmtpTransport($smtp_host, 465, 'ssl'));
    }

    public function setTransport($mail_login, $mail_password)
    {

        $this->smtpTransport->setUsername($mail_login)
            ->setPassword($mail_password);

        return new Swift_Mailer ($this->smtpTransport);
    }

}
