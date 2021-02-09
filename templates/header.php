<?php session_start(); 

/*if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}*/


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalight</title>
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/flatly/bootstrap.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="icon" class="fab fa-instagram">


</head>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
<div class="container">
    <a class="navbar-brand mr-auto" href="feed.php">Instalight</a>

    <!-- If you're on a small screen the menu will collapse -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="feed.php">Feed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">My Profile</a>
            </li>
           
        </ul>

        <form class="form-inline" action="searchresults.php" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="Search users" name="query">
            <button class="btn btn-secondary mr-sm-2" type="submit-search" name="submit-search">Search</button>
        </form>

        <ul class="navbar-nav">
        <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>
</div>

<!-- Start container, base on every page -->
<div class="container">