<?php

session_start();

require_once ('config.php');


$username = trim($_POST['username']);
$password = trim($_POST['password']);
$fname = trim($_POST['fname']);

$sql = "SELECT * FROM users WHERE username = :username AND password = :password";
$stm = $pdo->prepare($sql);
$stm->execute(array('username' => $username, 'password' => $password));
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