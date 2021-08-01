<?php
if (isServer("login.php")){
    if (isPost()) {
        $captcha = "";
        if (isset($_POST['submit'])) {
            $errors = [];
            $hasErrors = false;
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password');
            if (false === (bool)$username) {
                $errors[] = "Name is empty";
            }
            if (false === (bool)$password) {
                $errors[] = "Password is empty";
            }
            $userData = getUserDataForUsername($username);
            if ((bool)$username && 0 === count($userData)) {
                $errors[] = "Name does not exist ";
            }
            if ((bool)$password && isset($userData['password']) &&
                false === password_verify($password, $userData['password'])){
                $errors[] = "Password is not right";
            }
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
            }
            if (!$captcha) {
                $errors[] = "Check the captcha please";
            }
            $secretKey = getRandomHash(30);
            $responseKey = isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'';
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
            if (!isToken($_POST['token'])) {
                $errors[] = "The Token is invalid";
            }
            $hasErrors = count($errors) > 0;
            if (false === $hasErrors) {
                if (0 === count($errors)) {
                    $_SESSION['userRights'] = $userData['userRights'];
                    if (isset($_COOKIE['token']) && $_COOKIE['token'] === $userData['token']) {
                        setcookie('token', $_COOKIE['token'], 0, '/');
                        header("location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    //regenerate new user_id and token and replace them with the old ones every time to prevent Session Hijacking
                    session_regenerate_id(true);
                    $userId = getCurrentUserId();
                    ChangeUserId($userId, getRandomHash(30), $userData['id']);
                    ChangeUserIdForCart($userId, $userData['user_id']);
                    $userdatas = getUserDataForUsername($username);
                    //save user_agent
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                    setcookie('userId',$userdatas['user_id'], 0, '/');
                    setcookie('token', $userdatas['token'], 0, '/');
                    notificationMessage('Welcome back ' . $userData['username']);
                    header("location: " . BASE_URL);
                    exit();
                }
            }
        }
    }
}