<?php

session_start();
require 'config.php';
// is the person logged in?
if (!isset($_SESSION['logged_in'])) {
    // if not, show
    include "templates/header-notsignedin.php";
} else {
    // if they're logged in, show
    include "templates/header.php";
}

$image_id = $_GET['img'];

$picture = getPicture($pdo, $image_id);
$userInfo = getPicturesFromUser($pdo, $image_id);


function getPicture($pdo, $image_id)
{

    $statement = $pdo->prepare('SELECT * FROM images WHERE image_id = :id');
    $statement->execute([
        'id' => $image_id
    ]);

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function getPicturesFromUser($pdo, $image_id)
{
    // combine the users and images table by using the id from the users table and the user_id in images.
    $statement = $pdo->prepare('SELECT users.id, users.fname, users.lname, users.username, users.profile_img, images.text, images.created_at FROM images JOIN users ON images.image_id = :id AND images.user_id = users.id');

    $statement->execute([
        'id' => $image_id
    ]);

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $index => $user) {
        if (empty($user['profile_img'])) {
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

<div class="row images">

    <div class="col-6 picture">
        <?php foreach ($picture as $pic) : ?>
            <img class="picture" src="images/<?php echo $pic['filename'] ?>">
        <?php endforeach; ?>
    </div>

    <div class="col-6">

        <?php foreach ($userInfo as $info) : ?>

            <div class="card comment-box">
                <div class="card-body comment-box">
                    <h5 class="card-header">
                        <img class="profile-img" src="images/<?php echo $info['profile_img'] ?>">
                        <a href="profiles.php?user=<?php echo $info['id']; ?>"><?= $info['username'] ?></a>
                    </h5>
                    
                    <p class="card-text">
                        <a class="feed-link" href="profiles.php?user=<?php echo $info['id']; ?>"><?= $info['username'] ?></a>
                        <?= $info['text'] ?> </p>
                </div>
                <div class="card-footer text-muted">
                    Posted: <?= $timeago = get_timeago(strtotime($info['created_at'])); ?>
                </div>
            </div>


        <?php endforeach; ?>

    </div>

</div>