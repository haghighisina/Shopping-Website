<?php
if (isServer("login.php")){
    if (isPost()) {
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
            if ((bool)$password && isset($userData['password']) && false === password_verify($password, $userData['password'])) {
                $errors[] = "Password is not right";
            }
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
            }
            if (!$captcha) {
                $errors[] = "Check the captcha please";
            }
            $secretKey = "6LdsrtgZAAAAAKG6YhYiTwNPfXiwCHqROkCnxpjW";
            $responseKey = $_POST['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
            $hasErrors = count($errors) > 0;
            if (false === $hasErrors) {
                if (0 === count($errors)) {
                    session_regenerate_id(true);
                    $userID = getCurrentUserId();
                    ChangeUserId($userID,$userData['id']);
                    ChangeUserIdForCart($userID,$userData['user_id']);
                    $userInfo = getUserDataForUsername($username);
                    $userNewID = (int)$userInfo['user_id'];
                    setcookie('userId',$userNewID, strtotime('+30 days'), '/');
                    notificationMessage('Welcome back '.$userData['username']);
                    header("location: index.php");
                    exit();
                }
            }
        }
    }
}