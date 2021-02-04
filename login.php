<?php

session_start();

require_once ('config.php');
require 'login.php';

$pdo = connectDB($database);

// $username = trim($_POST['username']);
// $password = trim($_POST['password']);
// $fname = trim($_POST['fname']);

// $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
// $stm = connectDB($database)->prepare($sql);
// $stm->execute(array('username' => $username, 'password' => $password));
// $res = $stm->fetch(PDO::FETCH_ASSOC);


//     if(isset($res['id'])){
//         $_SESSION['id'] = $res['id'];
//         $_SESSION['email'] = $res['email'];
//         $_SESSION['username'] = $username;
//         $_SESSION['role'] = $res['role'];
//         $_SESSION['logged_in'] = true;
//         header('location: profile.php');
//         }else{
//         header('location: index.php?mess=Du har angivit felaktiga inloggningsuppgifter.');
//         }

        $statement = $pdo -> prepare("SELECT * FROM users WHERE email = :email");

        $statement -> bindParam('email', $_POST['email']);
        $statement -> execute();
        
        $user = $statement -> fetch(PDO::FETCH_ASSOC);
        
        if (isset($_POST['submit'])) {
        
            if (password_verify($_POST['password'], $user['password'])) {
                session_regenerate_id();
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                header('Location: profile.php');
            } else {
                header('Location: index.php');
            }
        }
        
        
        
        

        
               