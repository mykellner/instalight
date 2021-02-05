<?php 

include 'templates/header.php';
require 'config.php';

function getSearch($pdo) {

    $sql = 'SELECT * FROM users WHERE username LIKE ? OR fname LIKE ? OR lname LIKE ?';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "%" .$_POST['query']. "%",
        "%" .$_POST['query']. "%",
        "%" .$_POST['query']. "%"
    ]);
    
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
    
    }

$search = getSearch($pdo);


?>

<div>

<?php foreach($search as $result) : ?>

<a href="profiles.php?user=<?php echo $result['id']; ?>"><?php echo $result['username']?></a>

<?php endforeach; ?>


</div>

