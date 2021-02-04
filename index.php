
<?php

session_start();

include 'templates/header-notsignedin.php';

?>


  <div class="container">

  <div class="row login-form">

  <div class="col-6">
    <form action="login.php" method="POST">
     <h2 class="login">Login</h2>
      <div class="form-group">
        <input class="form-control" type="email" name="email" placeholder="E-mail Address">
       
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">

      </div>      
      <button type="submit" name="submit-login" class="btn-primary">Login</button>      
      <a class="register" href="sign-up.php">Create new account</a>
    </form>
    </div>
  </div>
  </div>
</body>
</html>
