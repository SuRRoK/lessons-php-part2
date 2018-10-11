<?php

require_once '../vendor/autoload.php';


if ($_SERVER['REQUEST_URI'] == '/')
{
    require_once '../app/contollers/homepage.php';
}

exit;
