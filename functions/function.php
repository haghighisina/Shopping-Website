<?php /** @noinspection ALL */
function changeUser(string $username, string $password, string $email, int $userId){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET username= :Username, password= :Password, email= :Email 
            WHERE id= :UserId";
    $statement = getDb()->prepare($sql);
    $data = [
        ':Username' => $username,
        ':Password' => $password,
        ':Email' => $email,
        ':UserId' => $userId
    ];
    $statement->execute($data);
    return $statement;
}
function getUserData(?string $username, ?string $password):array{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT id,username,password FROM user 
            WHERE username= :username AND password= :password";
    $statement = getDb()->prepare($sql);
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
    }
    $row = $statement->fetch();
    return $row;
}
