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

$picAndInfo = getPictureandInfo($pdo, $image_id);


function getPictureandInfo($pdo, $image_id){

    $statement = $pdo->prepare('SELECT * FROM images WHERE id = :id');
    $statement->execute([
        'id' => $image_id
    ]);

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}


?>


<div class="row">

<div class="col-3">
        <?php foreach ($picAndInfo as $pic) : ?>
            <img class="image-picture" src="images/<?php echo $pic['filename'] ?>">
        <?php endforeach; ?>
</div>

<div class="col-3">
        <?php foreach ($picture as $pic) : ?>
            <p><?php echo $pic['text']?></p>
        <?php endforeach; ?>
</div>

