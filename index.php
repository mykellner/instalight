<?php

$mess = "";

$mess = isset($_GET['mess']) ? "<p class='text-error'>" . $_GET['mess'] . "</p>" : "";
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instalight</title>
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-loggin">
    <div class="container">
        <div>
            <h1 class="h1-header">Instalight</h1>
            <div class="column col-3">
                <?php echo $mess; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input class="form-input" id="username" name="username" type="text" placeholder="Email" required>
                        <label class="form-label" for="password">Password</label>
                        <input class="form-input" id="password" name="password" type="password" placeholder="Password" required>
                        <label class="form-checkbox">
                            <input type="checkbox" name="keepLoggedIn">
                            <i class="form-icon"></i> Keep me logged in
                        </label>
                        <input class="button" type="submit" value="Logga in">
                        <p></p>
                        <?php session_abort() ?>
                        <a class="button" href="register.php">Sign up</a>

                        <div class="text-sm"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>