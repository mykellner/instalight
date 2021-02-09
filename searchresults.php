<?php

include 'templates/header.php';
require 'config.php';

if (isset($_POST['submit-search'])) {
    unset($_SESSION['query']);
    unset($_SESSION['search']);
}


function getSearch($pdo)
{

    $sql = 'SELECT * FROM users WHERE username LIKE ? OR fname LIKE ? OR lname LIKE ?';
    $statement = $pdo->prepare($sql);

    if (isset($_SESSION['query'])) {
        $query = $_SESSION['query'];
    } else {
        $query = $_POST['query'];
    }

    $statement->execute([
        "%" . $query . "%",
        "%" . $query . "%",
        "%" . $query . "%"
    ]);

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $index => $user) {
        if (empty($user['profile_img'])) {
            $users[$index]['profile_img'] = '/default.png';
        }
    }

    return $users;
}

$search = getSearch($pdo);


if (!empty($_POST['query'])) {

    $_SESSION['query'] = $_POST['query'];
}

$_SESSION['search'] = true;

?>

<?php if (empty($search)) : ?>

    <h2 class="noresult">No results..</h2>

<?php endif; ?>

 <div class="row">

    <?php foreach ($search as $result) : ?>

        <div class="search-images">

            <div class="searchinfo d-flex">
            <a class="searchusername" href="profiles.php?user=<?php echo $result['id']; ?>"><?php echo $result['username'] ?></a>
            <p class="searchname"> ( <?php echo $result['fname'] . " " . $result['lname'] ?> )</p>
            </div>
            <img class="profileimages" src="images/<?php echo $result['profile_img'] ?>">

        </div>

    <?php endforeach; ?>

</div> 