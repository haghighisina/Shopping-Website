<?php  /** @noinspection ALL */
session_start();
error_reporting(-1);
ini_set('display_errors','on');
ini_set('display_startup_errors',1);
require_once __DIR__.'/includes.php';
isset($_COOKIE['allProductsInCartForUser'])? $userproduct = json_decode($_COOKIE['allProductsInCartForUser']):[''];
logData("INFO", $_SERVER['HTTP_REFERER']??'',[
    'user_id'=>$userId,
    'user_ip' => getIPAddress(),
    'user_rights'=>$_SESSION['userRights']??'anonymous',
    'user_products'=>$userproduct??['']
]);
require_once __DIR__.'/template/main.php';
require_once __DIR__.'/template/footer.php';
?>