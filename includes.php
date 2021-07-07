<?php
require_once __DIR__.'/config/database.php';
require_once __DIR__.'/functions/utilities.php';
require_once __DIR__.'/functions/database.php';
require_once __DIR__.'/functions/cart.php';
require_once __DIR__.'/functions/user.php';
require_once __DIR__.'/template/header.php';
require_once __DIR__.'/template/navbar.php';

logData("INFO",$_SERVER['PHP_SELF'],['user_id'=>$userId,'user_ip' => getIPAddress()]);



