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

if(isset($_SESSION['search'])) {
  unset($_SESSION['search']);
  unset($_SESSION['query']);

}

$myid = $_SESSION['userid'];

$myFriends = checkFriends($pdo, $myid);

function checkFriends ($pdo, $userid) {

    $sql = 'SELECT friendID FROM follows WHERE user_ID = :user_id';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'user_id' => $userid,
        
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

  
    $friends = [];

    foreach($results as $result) {
        array_push($friends, $result['friendID']);
    }

    return $friends;


}

if(!empty($myFriends)) {

$stringFriends = array_values($myFriends);
$users = getPicturesFromFriends($pdo, $stringFriends);

} 


function getPicturesFromFriends($pdo, $stringFriends)
{ $in  = str_repeat('?,', count($stringFriends) - 1) . '?';
    
  $statement = $pdo->prepare("SELECT users.id, users.username, users.fname, users.lname, users.profile_img, images.filename, images.text, images.created_at FROM users JOIN images ON users.id = images.user_id WHERE users.id IN ($in)");

    $statement->execute(
    $stringFriends
  );

  $users = $statement->fetchAll(PDO::FETCH_ASSOC); 

  foreach ($users as $index => $user){
    if(empty($user['profile_img'])) {
        $users[$index]['profile_img'] = '/default.png';
    }
}

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

?>

<div class="container-feed">
<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="feed.php">All</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="followsfeed.php">Following</a>
    </li>
  </ul>
  <div class="row">

<?php
   if(empty($users)) {
       echo '<h3 class="notfollowing">Du har inte valt att följa några användare.. </h3>';
   } else {
       foreach (array_reverse($users) as $user) {
           echo '<div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-header">';
            echo '<img class="profile-img" src="profile-images/'.$user["profile_img"].'"><a href="profiles.php?user='.$user['id'].'">'.$user["username"].'</a>';
            echo "</h5></a>";
            echo '<div class="feed-picture">
                    <img src="images/'.$user["filename"].'">
                  </div>';
            echo '<p class="card-text"> <a class="feed-link" href="profiles.php?user='.$user["id"].'"> '.$user["username"].'</a> &nbsp;'.$user["text"].'</p>
            </div>';
            echo '            <div class="card-footer text-muted">
              Posted: '.$timeago = get_timeago(strtotime($user['created_at'])).'
            </div>
          </div>
          </div>';
       }
   }
?>
  
    
    
    

    
  </div>


  <?php include 'templates/footer.php' ?>