<?php

session_start();

require_once ('config.php');


$username = trim($_POST['username']);
$password = trim($_POST['password']);
$fname = trim($_POST['fname']);

$sql = "SELECT * FROM users WHERE email = :email AND password = :password";
$stm = initDatabase($database)->prepare($sql);
$stm->execute(array('email' => $username, 'password' => $password));
$res = $stm->fetch(PDO::FETCH_ASSOC);


    if(isset($res['id'])){
        $_SESSION['id'] = $res['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $res['role'];
        $_SESSION['logged_in'] = true;
        header('location: loggedin.php');
        }else{
        header('location: index.php?mess=Du har angivit felaktiga inloggningsuppgifter.');
        }