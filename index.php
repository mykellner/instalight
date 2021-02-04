
<?php

session_start();

include 'templates/header-notsignedin.php';

?>

  <div class="signup-form">
    <form action="login.php" method="POST">
     <h2 class="login">Login</h2>
      <div class="form-group">
        <input class="form-control" type="email" name="email" placeholder="E-mail Address">
        <span class="input-icon"><i class="fas fa-envelope"></i></span>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="input-icon"><i class="fas fa-key"></i></span>

      </div>      
      <button type="submit" name="submit-login" class="btn btn-primary">Login</button>      
      <a class="create-acc" href="sign-up.php">Create new account</a>

    </form>
  </div>

