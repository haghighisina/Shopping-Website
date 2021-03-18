<?php
if (isServer("edit.php")) {
    if (isPost()) {
        $errors = [];
        $hasErrors = false;
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password');
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $userData = getUserData($username, $password);
        if (false === (bool)$username) {
            $errors[] = "name is empty";
        }
        if (false === (bool)$password) {
            $errors[] = "Password ist empty";
        }
        if (false === (bool)$email) {
            $errors[] = "Email ist empty";
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
            if (mb_strlen($password) < 6) {
                $errors[] = "Password is too short";
            }
        }
        if (true === (bool)$email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is not valid";
            }
            $ifEmailExist = ifEmailExist($email);
            if (true === $ifEmailExist) {
                $errors[] = "The Email is already exist";
            }
        }
        $hasErrors = count($errors) > 0;
        if (false === $hasErrors) {
            changeUser($username, $password, $email, $userId);
            notificationMessage('Your edit has successfully done');
            header('location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}
