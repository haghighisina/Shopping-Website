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
    $sql = "SELECT * FROM user 
            WHERE username= :username";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){
        return [];
    }
    $data = [':username'=>$username];
    $statement->execute($data);
    if (0 === $statement->rowCount()){
        return [];
    }elseif($statement->rowCount()==1){
        $row = $statement->fetch();
    }
    return $row;
}
function getUserDataFormCookie($userid):array{
    $sql = "SELECT id,password,email,username,user_id,userRights FROM user 
            WHERE user_id= :userID";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){
        return [];
    }
    $data = [':userID'=>$userid];
    $statement->execute($data);
    if (0 === $statement->rowCount()){
        return [];
    }elseif($statement->rowCount()==1){
        $row = $statement->fetch();
    }
    return $row;
}
function getUserData(?string $username, ?string $password):array{
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "SELECT id,username,password FROM user 
            WHERE username= :username AND password= :password";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){
        return [];
    }
    $data = [
        ':username' => $username,
        ':password' =>$password
    ];
    $statement->execute($data);
    if (0 === $statement->rowCount()){
        return [];
    }elseif ($statement->rowCount()==1) {
        $row = $statement->fetch();
    }
    return $row;
}
function changeUser(string $username, string $password, string $email, int $userId){
    $password = password_hash($password, PASSWORD_BCRYPT );
    $sql = "UPDATE user SET username= :Username, password= :Password, email= :Email 
            WHERE user_id= :UserId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $data = [
        ':Username' => $username,
        ':Password' => $password,
        ':Email' => $email,
        ':UserId' => $userId
    ];
    $statement->execute($data);
    return $statement;
}
//change user id every time to prevent Session Hijacking
function ChangeUserId($userID, $token,$ID){
    $sql = "UPDATE user SET user_id= :UserID,token= :token WHERE id= :ID";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $data = [
        ':UserID'=>$userID,
        ':token'=>$token,
        ':ID'=>$ID
    ];
    return $statement->execute($data);
}
function ifUserAgentMatche():bool{
    if(!isset($_SESSION['user_agent'])) { return false; }
    if(!isset($_SERVER['HTTP_USER_AGENT'])) { return false; }
    return ($_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']);
}
function ChangeUserIdForCart($userID,$ID){
    $sql = "UPDATE cart SET user_id= :UserID WHERE user_id= :ID";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $data = [
        ':UserID'=>$userID,
        ':ID'=>$ID
    ];
    return $statement->execute($data);
}
function ifUserNameExist(string $username):bool{
    $sql = "SELECT 1 FROM user WHERE username= :Username";
    $statment = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statment){
        return false;
    }
    $statment->execute([':Username'=> $username]);
    return (bool)$statment->fetchColumn();
}
function ifEmailExist(string $email):bool{
    $sql = "SELECT 1 FROM user WHERE email= :Email";
    $statment = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statment){
        return false;
    }
    $statment->execute([':Email' => $email]);
    return (bool)$statment->fetchColumn();
}
function getAccountTotal():int{
    $sql = "SELECT COUNT(id) FROM user";
    $statement = getDb()->query($sql);
    if (false === $statement){
        return 0;
    }
    return (int)$statement->fetchColumn();
}
function createAcocount(string $username, string $password, int $userId, string $email):bool{
    $password = password_hash($password, PASSWORD_BCRYPT);
    $group = 'USER';
    if (getAccountTotal() === 0){
        $group = 'ADMIN';
    }
    $sql = "INSERT INTO user SET 
            username= :Username, 
            password= :Password,
            user_id= :UserId, 
            email= :Email,
            userRights= :UserRights";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){
        return false;
    }
    $data = [
        ':Username'=>$username,
        ':Password' => $password,
        ':UserId' => $userId,
        ':Email' => $email,
        ':UserRights'=>$group
    ];
    $statement->execute($data);
    $affectedRows = $statement->rowCount();
    return $affectedRows > 0;
}
function isAdmin():bool{
    return isset($_SESSION['userRights']) && $_SESSION['userRights'] == 'ADMIN';
}
//create token for hidden token value - CSRF Attack
function CreateToken(){
    return $_SESSION['token'] = base64_encode(md5(microtime()));
}
//check if the token is equall to is token session - CSRF Attack
function isToken($token):bool{
    if (isset($_SESSION['token']) && $token == $_SESSION['token']){
        unset($_SESSION['token']);
        return true;
    }
    return false;
}