<?php


use App\QueryBuilder;

$db =  new QueryBuilder() ;

$logins = $db->getColumns(['login',],'users');

