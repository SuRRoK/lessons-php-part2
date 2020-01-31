<?php

namespace app\models;

//use app\models\MailSend;
use Delight\Auth\Auth;
use Cake\Chronos\Chronos;

class AppModel

{
    protected $query;
    protected $auth;
    protected $mail_send;
    protected $time;
    protected $image;


    public function __construct(QueryBuilder $qb,
                                MailSend $mailSend,
                                Auth $auth,
                                ImageModel $image)
    {
        $this->query = $qb;
        $this->mail_send = $mailSend;
        $this->auth = $auth;
        $this->image = $image;
    }


}
