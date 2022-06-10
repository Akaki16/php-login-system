<?php

/*
    @return array
*/
function get_users(): array {
    global $pdo;

    $sql = "SELECT * from users";

    $statement = $pdo->query($sql);
    $users = $statement->fetchAll($pdo::FETCH_ASSOC);

    return $users;
}

/*
    @param array $options
    @return array
*/
function get_user(array $options): array | bool {
    global $pdo;

    $sql = "SELECT * from users where email=?";
    $statement = $pdo->prepare($sql);
    $statement->execute($options);

    $user = $statement->fetch($pdo::FETCH_ASSOC);
    
    return $user;
}

/*
    @param array $user
    @return void
*/
function register_user(array $user): void {
    global $pdo;

    // define SQL statement to inser user into users table
    $sql = "INSERT into users (username, email, pwd) VALUES (:username, :email, :user_pwd)";

    // prepare SQL statement
    $statement = $pdo->prepare($sql);
    // execute SQL statement
    $statement->execute($user);
}

/*
    @param string $password
    @param string @pwd_to_compare
    @return bool
*/
function login_user(string $password, string | null $pwd_to_compare): bool {
    return password_verify($password, $pwd_to_compare);
}