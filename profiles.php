<?php

session_start();

require 'config.php';

$userid = $_GET['user'];

$thisUser = getUserById($pdo, $userid);
$userImages = getUserImages($pdo, $userid);
$userAmount = getAmountOfPictures($pdo,$userid);



function getUserImages($pdo, $userid)
{

    $sql = 'SELECT filename FROM users
    JOIN images
    ON users.id = images.user_id
    WHERE users.id = :id';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $userid,
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getUserById($pdo, $id)
{

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        'id' => $id
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


function getAmountOfPictures($pdo, $userid){


    $sql = 'SELECT COUNT(*) FROM images as TOTAL WHERE user_id = :id';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $userid
    ]);

    return ($statement->fetchColumn());

}

include 'templates/header.php';

?>

<div class="row profile-header">
<div class="col-12 d-flex justify-content-between"">
<?php foreach ($thisUser as $user) : ?>
    <h3><?php echo $user['username'] ?></h3>
<?php endforeach; ?> 
<?php if(isset($_SESSION['search'])) : ?>

<a class="results" href="searchresults.php">Back to search</a>

<?php endif; ?>
</div></div>

<div class="row profile-info">
    <div class="col-4">
<p class="userinfo"> <?php foreach ($thisUser as $user) : ?>
        <?php echo $user['fname'] . " " . $user['lname'] ?>
    <?php endforeach; ?> </p>

</div>
  <p> Posts </i> <b><?php echo $userAmount; ?></b></p>
</div>

<div class="row profile-images-feed">
    <?php foreach ($userImages as $image) : ?>
        <div class="col-4">
            <div class="profile-images">
                <img src='images/<?php echo $image['filename'] ?>'>
            </div>
        </div>
    <?php endforeach; ?>
</div>



</body>

</html>