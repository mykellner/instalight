<?php

require 'config.php';

$pdo = initDatabase();

$thisUser = getUserById($pdo, $_GET['id']);
$userImages = getUserImages($pdo, $_GET['id']);


function getUserImages ($pdo, $userid) {
    
    $sql = 'SELECT filename FROM users
    JOIN images
    ON users.id = images.user_id
    WHERE users.id = :id';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $userid,
    ]);

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    return $results;

}

function getUserById($pdo, $id) {

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        'id' => $id
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userprofile</title>
</head>
<body>

<?php if (isset($_GET['id'])) : ?>

<div class="">

    <h2 class="profile-name"> <?php foreach ($thisUser as $user) : ?>
            <?php echo $user['username'] ?>
        <?php endforeach; ?> </h2>

    <p class="userinfo"> <?php foreach ($thisUser as $user) : ?>
            <?php echo $user['fname'] . " " . $user['lname'] ?>
        <?php endforeach; ?> </p>

    <div class="images">
        <?php foreach ($userImages as $image) : ?>
            <img class="profileimages" src="images/<?= $image; ?>" alt="">
        <?php endforeach; ?>
    </div>
</div>

<?php endif; ?>
    
</body>
</html>