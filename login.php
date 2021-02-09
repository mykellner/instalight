<?php

session_start();

require 'config.php';

$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$statement->bindParam('email', $_POST['email']);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);

if(password_verify($_POST['password'], $user['password'])){
    session_regenerate_id();
    $_SESSION['id'] = $user['id'];
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['userid'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    header('Location: feed.php');
} else {
    header('Location: index.php');
}
