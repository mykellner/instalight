<?php

session_start();
include 'config.php';
// is the person logged in?
if (!isset($_SESSION['logged_in'])) {
    // if not, show
    include "templates/header-notsignedin.php";
  } else {
    // if they're logged in, show
    include "templates/header.php";
  }

// function to get all users from datebase
function getPicturesFromUser($pdo) {
    
    // combine the users and images table by using the id from the users table and the user_id in images.
    $statement = $pdo -> prepare ('SELECT users.id, users.username, users.fname, users.lname, images.filename, images.text, images.created_at FROM users LEFT JOIN images ON users.id = images.user_id');

    $statement->execute();

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

$users = getPicturesFromUser($pdo);

?>

<div class="container-feed">

<div class="row">

  <?php foreach (array_reverse($users) as $user) : ?>
    <div class="col-12">
      <a href="profiles.php?user=<?php echo $user['id']; ?>">
        <div class="card text-center">
          <div class="card-body">
            <h5 class="card-title"><?= $user['username'] ?></h5>
            <div class="feed-picture">
              <img src='images/<?php echo $user['filename'] ?>'>
            </div>
            <p class="card-text"> <?= $user['text'] ?> </p>
          </div>
          <div class="card-footer text-muted">
            Posted: <?= $user['created_at'] ?>
          </div>
        </div>
      </a>
    </div>

  <?php endforeach; ?>

</div>


<?php include 'templates/footer.php'?>