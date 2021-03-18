<?php
if (isServer("register.php")) {
    if (isPost()) {
        if (isset($_POST['submit'])) {
            $errors = [];
            $hasErrors = false;
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $Re_password = filter_input(INPUT_POST, 'Re-password');
            $captcha = $_POST['g-recaptcha-response'];
            $secretKey = "6LdsrtgZAAAAAKG6YhYiTwNPfXiwCHqROkCnxpjW";
            $responseKey = $_POST['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

            if (false === (bool)$username) {
                $errors[] = "Name is empty";
            }
            if (false === (bool)$password) {
                $errors[] = "Password is empty";
            }
            if (false === (bool)$Re_password) {
                $errors[] = "Re_password is empty";
            }
            if (false === (bool)$email) {
                $errors[] = "Email is empty";
            }
            if (true === (bool)$username) {
                if (mb_strlen($username) < 4) {
                    $errors[] = "Username is too short, at least 4 characters";
                }
                if (mb_strlen($username) > 10) {
                    $errors[] = "Username is too long, at the most 10 characters";
                }
                $ifUserNameExist = ifUserNameExist($username);
                if (true === $ifUserNameExist) {
                    $errors[] = "The username is already exist";
                }
            }
            if (true === (bool)$password) {
                if (mb_strlen($password) < 8) {
                    $errors[] = "Password is too short";
                }
                if (false === (bool)passwordValidate($password)) {
                    $errors[] = 'Password should include at least one upper case letter, one number, and one special character.';
                }
            }
            if ($password !== $Re_password) {
                $errors[] = "Password and repeat Password are not the same";
            }
            if (true === (bool)$email) {
                if (false === (bool)emailValidate($email)) {
                    $errors[] = "Email is not valid";
                }
                $ifEmailExist = ifEmailExist($email);
                if (true === $ifEmailExist) {
                    $errors[] = "The Email is already exist";
                }
            }
            if (!$captcha) {
                $errors[] = "Check the captcha please";
            }
            $hasErrors = count($errors) > 0;
            if (false === $hasErrors) {
                $createAccount = createAcocount($username, $password, $userId, $email);
                if (!$createAccount) {
                    $errors[] = "Something went wrong, please try again later";
                }
                $userData = getUserDataForUsername($username);
                if ($createAccount) {
                    notificationMessage('Your registration has successfully done');
                    $_SESSION['userId'] = (int)$userData['id'];
//                $_SESSION['username'] = (int)$userData['username'];
                    setcookie('userId', $_SESSION['userId'], strtotime('+30 days'), '/');
                    header("location: index.php");
                    exit();

                }
            }
        }
    }
}
