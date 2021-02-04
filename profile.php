<?php 
session_start();
include 'header.php';

$user_id = $_SESSION['id'];

function getOneUser($pdo, $user_id){

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');

    $statement->execute([
        'user_id' => $user_id,
    ]);

    $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    // reset only return the first result in the array.
    return reset($user);
}

$user = getOneUser($pdo, $user_id)

?>

<div class="row text-center">
    <div class="col-12 ">
        <h2 class="home-msg">Welcome <?php echo $user['first_name']; ?> </h2>
    </div>
</div>


