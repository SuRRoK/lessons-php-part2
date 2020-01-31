<?php

//Not work :(
return [
    Engine::class => function () {
        return new Engine('../app/views');
    },

    PDO::class => function () use ($password, $username, $db_name, $host, $driver) {
        return new PDO("$driver:host=$host;dbname=$db_name", $username, $password);
        //d(PDO::class);
    },

    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    },

    Auth::class => function ($container) {
        return new Auth($container->get('PDO'));
    },

    Swift_SmtpTransport::class =>  function () use ($smtp_host,$smtp_port,$protocol) {
        return new Swift_SmtpTransport ($smtp_host,$smtp_port, $protocol);
    }

];

