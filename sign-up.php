<?php

$title = 'Sign Up';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/minty/bootstrap.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>

<body>

    <div class="login-form">
        <form action="signup-auth.php" method="POST">
            <h4>Create an account</h4>

            <div class="form-group">
                <input type="text" id="first_name" name="fname" placeholder="First Name">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="lname" placeholder="Last name">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Country">
                <span class="input-icon"><i class="fa fa-globe-europe"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="email" placeholder="E-mail Address" required>
                <span class="input-icon"><i class="fa fa-envelope"></i></span>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password">
                <span class="input-icon"><i class="fa fa-lock"></i></span>
            </div>

            <button type="submit" name="submit-signup" class="btn btn-primary">Create your account</button>
            <a class="create-acc" href="index.php">I already have an account</a>
        </form>

</body>

</html>