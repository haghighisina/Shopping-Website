<?php
session_start();
require_once __DIR__.'/functions/user.php';
$userId = getCurrentUserId();
setcookie('userId',$userId,strtotime('-30 days'),'/');
session_regenerate_id(true);
session_destroy();
header('location: index.php');
exit();