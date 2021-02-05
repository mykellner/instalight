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
function getPicturesFromUser($pdo)
{

  // combine the users and images table by using the id from the users table and the user_id in images.
  $statement = $pdo->prepare('SELECT users.id, users.username, users.fname, users.lname, users.profile_img, images.filename, images.text, images.created_at FROM users JOIN images WHERE users.id = images.user_id');

  $statement->execute();

  $users = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $users;
}


function get_timeago($ptime)
{
  $estimate_time = time() - $ptime;

  if ($estimate_time < 1) {
    return 'less than 1 second ago';
  }
  $condition = array(
    12 * 30 * 24 * 60 * 60  =>  'year',
    30 * 24 * 60 * 60       =>  'month',
    24 * 60 * 60            =>  'day',
    60 * 60                 =>  'hour',
    60                      =>  'minute',
    1                       =>  'second'
  );

  foreach ($condition as $secs => $str) {
    $d = $estimate_time / $secs;

    if ($d >= 1) {
      $r = round($d);
      return ' ' . $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
    }
  }
}

$users = getPicturesFromUser($pdo);

?>

<div class="container-feed">

  <div class="row">

    <?php foreach (array_reverse($users) as $user) : ?>
      <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-header">
                <img class="profile-img" src="profile-images/<?php echo $user['profile_img']?>"><a  href="profiles.php?user=<?php echo $user['id']; ?>"><?= $user['username'] ?></a>
              </h5>
              </a>
              <div class="feed-picture">
                <img src='images/<?php echo $user['filename'] ?>'>
              </div>
              <p class="card-text"> <a class="feed-link" href="profiles.php?user=<?php echo $user['id']; ?>"> <?= $user['username'] ?></a> &nbsp;<?= $user['text'] ?> </p>
            </div>
            <div class="card-footer text-muted">
              Posted: <?= $timeago = get_timeago(strtotime($user['created_at'])); ?>
            </div>
          </div>
      
      </div>

    <?php endforeach; ?>

  </div>


  <?php include 'templates/footer.php' ?>