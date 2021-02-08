<?php

session_start();

require 'config.php';

$userid = $_GET['user'];

$thisUser = getUserById($pdo, $userid);
$userImages = getUserImages($pdo, $userid);
$userAmount = getAmountOfPictures($pdo, $userid);
$myid = $_SESSION['userid'];
checkIfFollow($pdo, $myid, $userid);
$follows;

function checkIfFollow ($pdo, $userid, $friendID) {

    $sql = 'SELECT id FROM follows WHERE user_ID = :user_id AND friendID = :friendID';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'user_id' => $userid,
        'friendID' => $friendID,
    ]);


    global $follows;
    if($statement->rowCount() > 1){
        $follows = 'true';
        } else {
            $follows = 'false';
        }


}


if(isset($_POST['submit-follow'])) {

    addToFollow($pdo, $myid, $userid);
}

function addToFollow($pdo, $userid, $friendID) {
    $sql = 'INSERT INTO follows (user_id, friendID) VALUES (:user_id, :friendID)';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'user_id' => $userid,
        'friendID' => $friendID,
    ]);

    global $follows;
    $follows = 'true';
}

if(isset($_POST['submit-unfollow'])) {

    unFollow($pdo, $myid, $userid);
}

function unFollow($pdo, $userid, $friendID) {
    $sql = 'DELETE FROM follows WHERE user_id = :user_id AND friendID = :friendID';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'user_id' => $userid,
        'friendID' => $friendID,
    ]);

    global $follows;
    $follows = 'false';
}

function getUserImages($pdo, $userid)
{

    $sql = 'SELECT * FROM users
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

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // loop to see if file_name is empty, if it is, a deafult picture will be added.
    foreach ($users as $index => $user){
        if(empty($user['profile_img'])) {
            $users[$index]['profile_img'] = 'default.png';
        }
    }
    return $users;
}


function getAmountOfPictures($pdo, $userid)
{

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

    <div class="col-3">
        <?php foreach ($thisUser as $user) : ?>
            <img class="profile-picture" src="profile-images/<?php echo $user['profile_img'] ?>">
        <?php endforeach; ?>
    </div>

    <div class="col-6">
        <?php foreach ($thisUser as $user) : ?>
            <h3><?php echo $user['username'] ?> </h3> 
            <p><?php echo $user['fname'] . " " . $user['lname'] ?></p>
            <p> <b><?php echo $userAmount; ?></b> Posts </p>

            <?php if($follows == 'true') : ?>
            
            <form method="POST">
            <button type="submit" name="submit-unfollow" class="btn btn-primary btn-sm">Unfollow</button>
            </form>

            <?php endif; ?>

            <?php if($follows == 'false') : ?>
            
            <form method="POST">
            <button type="submit" name="submit-follow" class="btn btn-primary btn-sm">Follow</button>
            </form>

            <?php endif; ?>
        <?php endforeach; ?> 
    </div>

<?php if(isset($_SESSION['search'])) : ?>

    <a class="results" href="searchresults.php">Back to search</a>

<?php endif; ?>



</div>


<div class="row profile-images-feed">
    <?php foreach ($userImages as $image) : ?>
        <div class="col-4">
            <div class="profile-images">
            <a class="feed-image" href="image.php?img=<?php echo $image['id']; ?>"> 
                <img src='images/<?php echo $image['filename'] ?>'>
            </div></a>
        </div>
    <?php endforeach; ?>
</div>



</body>

</html>