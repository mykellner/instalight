<?php
require "register.php";
$title = 'Sign Up';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>

<body>

    <div class="signup-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2>Create an account</h2>

            <div class="form-group">
                <input type="text" id="fname" name="fname" placeholder="First Name">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="lname" placeholder="Last Name">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
                <span class="input-icon"><i class="fa fa-globe-europe"></i> <?php echo $usernameErr; ?></span>
            </div>
            <div class="form-group">
                <input type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>">
                <span class="input-icon"><i class="fa fa-envelope"></i> <?php echo $emailErr; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
                <span class="input-icon"><i class="fa fa-lock"></i> <?php echo $passErr; ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                <span class="input-icon"><i class="fa fa-lock"></i> <?php echo $cpassErr; ?></span>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Create your account</button>
            <a class="create-acc" href="index.php">I already have an account</a>
        </form>

</body>

</html>