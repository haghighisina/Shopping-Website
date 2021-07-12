<?php
session_start();
require_once __DIR__.'/functions/user.php';
require_once __DIR__.'/functions/utilities.php';
$userId = getCurrentUserId();
setcookie('userId',$userId,strtotime('-30 days'),'/');
setcookie('allProductsInCartForUser',$userId,strtotime('-30 days'),'/');
setcookie('token',$userId,strtotime('-30 days'),'/');
session_regenerate_id(true);
session_destroy();
header('location: '.BASE_URL);
exit();