<?php /** @noinspection ALL */
function isPost():bool{
    return strtoupper($_SERVER['REQUEST_METHOD'] === 'POST');
}
function escape(string $value):string{
    return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}
function isLoggedIn():bool{
    return isset($_SESSION['logged_in']);
}
if(!defined("SITE_URL")) define("SITE_URL","localhost/Shopping-Cart");
if (!defined("BASE_URL")) define("BASE_URL",SITE_URL);
function isServer($base):bool{
    if($_SERVER['HTTP_HOST'] == SITE_URL){
       if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']==BASE_URL."/$base"){
           return true;
       };
    }
    return $base;
}
function getRandomHash(int $length):string{
    $randomInt = random_int(0, time());
    $hash = md5($randomInt);
    $start = random_int(0, strlen($hash) - $length);
    $hashShort = substr($hash, $start, $length);
    return $hashShort;
}
function notificationMessage(?string $message = null){
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    if (!$message) {
        $messages = $_SESSION['messages'];
        $_SESSION['messages'] = [];
        return $messages;
    }
    $_SESSION['messages'][] = $message;
}
function notificationErrorMessage(?string $message = null){
    if (!isset($_SESSION['message'])) {
        $_SESSION['message'] = [];
    }
    if (!$message) {
        $messages = $_SESSION['message'];
        $_SESSION['message'] = [];
        return $messages;
    }
    $_SESSION['message'][] = $message;
}
function convertToMoney(int $cent):string{
    $money = $cent / 100;
    return number_format($money, 2, ",", " ");
}
function passwordValidate(string $password):bool{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars){
        return  false;
    }
    return $password;
}
function emailValidate(string $email):bool{
     if((!preg_match("/^([a-z0-9\+_\-]+)
       (\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)){
         return false;
     };
     return $email;
}

