<?php /** @noinspection ALL */
function getCurrentUserId(){
    $userId = random_int(0,time());
    if (isset($_SESSION['userId'])){
        $userId = (int)$_SESSION['userId'];
    }
    if (isset($_COOKIE['userId'])){
        $userId = (int)$_COOKIE['userId'];
    }
    return $userId;
}
function getUserDataForUsername(string $username):array{
    $sql = "SELECT id,password,username FROM user 
            WHERE username= :username";
    $statement = getDb()->prepare($sql);
    if (false === $statement){
        return [];
    }
    $data = [':username'=>$username];
    $statement->execute($data);
    if (0 === $statement->rowCount()){
        return [];
    }
    $row = $statement->fetch();
    return $row;
}
function ifUserNameExist(string $username):bool{
    $sql = "SELECT 1 FROM user WHERE username= :Username";
    $statment = getDb()->prepare($sql);
    if (false === $statment){
        return false;
    }
    $statment->execute([':Username' => $username]);
    return (bool)$statment->fetchColumn();
}
function ifEmailExist(string $email):bool{
    $sql = "SELECT 1 FROM user WHERE email= :Email";
    $statment = getDb()->prepare($sql);
    if (false === $statment){
        return false;
    }
    $statment->execute([':Email' => $email]);
    return (bool)$statment->fetchColumn();
}
function createAcocount(string $username, string $password, int $userId, string $email):bool{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user SET username= :Username, password= :Password,
            user_id= :UserId, email= :Email";
    $statement = getDb()->prepare($sql);
    if (false === $statement){return false;}
    $data = [
        ':Username'=>$username,
        ':Password' => $password,
        ':UserId' => $userId,
        ':Email' => $email
    ];
    $statement->execute($data);
    $rowCount = $statement->rowCount();
    return $rowCount > 0;
}
