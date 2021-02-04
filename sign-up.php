<?php
require "register.php";
$title = 'Sign Up';

?>

<?php include 'templates/header-notsignedin.php'; ?>

    <div class="signup-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2>Create an account</h2>

            <div class="form-group">
                <input type="text" id="fname" name="fname" placeholder="First Name" value="<?php echo $fname; ?>">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname; ?>">
                <span class="input-icon"><i class="fa fa-user"></i></span>
            </div>
            <div class="form-group">
            <?php echo $usernameErr; ?>
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
                <span class="input-icon"><i class="fa fa-globe-europe"></i> </span>
            </div>
            <div class="form-group">
            <?php echo $emailErr; ?>
                <input type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>">
                <span class="input-icon"><i class="fa fa-envelope"></i> </span>
            </div>
            <div class="form-group">
            <?php echo $passErr; ?>
                <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
                <span class="input-icon"><i class="fa fa-lock"></i> </span>
            </div>
            <div class="form-group">
            <?php echo $cpassErr; ?>
                <input type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                <span class="input-icon"><i class="fa fa-lock"></i> </span>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Create your account</button>
            <a class="create-acc" href="index.php">I already have an account</a>
        </form>

</body>

</html>