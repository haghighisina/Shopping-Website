<?php
session_start();
error_reporting(-1);
ini_set('display_errors','on');
require_once __DIR__.'/includes.php';
logData("INFO", $_SERVER['HTTP_REFERER'],[
    'user_id'=>$userId,
    'user_ip' => getIPAddress(),
    'user_rights'=>$_SESSION['userRights']??'anonymous',
    'user_products'=>json_decode($_COOKIE['allProductsInCartForUser']??[])
]);
require_once __DIR__.'/template/main.php';
require_once __DIR__.'/template/footer.php';
?>

