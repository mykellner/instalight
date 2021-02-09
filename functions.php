<?php

function addImageToDatabase ($pdo, $userid, $filename, $text) {

    $sql = 'INSERT INTO images (user_id, filename, text) VALUES (:user_id, :filename, :text)';
    $statement = $pdo->prepare($sql);
        
        $statement->execute([
            'user_id' => $userid,
            'filename' => $filename,
            'text' => $text,
        ]);
    }

function deleteImage ($pdo, $imageid) {

    $sql = 'DELETE FROM images WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $imageid,
    ]);
}

function updateImageText($pdo, $imageid, $text) {

    $sql = 'UPDATE images SET text = :text, WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'text' => $text,
        'id' => $imageid,
    ]);

}

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
    
include 'config.php';

$myid = 4;

$myFriends = checkFriends($pdo, $myid);
$stringFriends = array_values($myFriends);

function checkFriends ($pdo, $userid) {

    $sql = 'SELECT DISTINCT friendID FROM follows WHERE user_ID = :user_id';

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

$infopictures = getPicturesFromFriends($pdo, $stringFriends);
print_r($infopictures);

function getPicturesFromFriends($pdo, $stringFriends)
{ $in  = str_repeat('?,', count($stringFriends) - 1) . '?';
    
  $statement = $pdo->prepare("SELECT users.id, users.username, users.fname, users.lname, users.profile_img, images.filename, images.text, images.created_at FROM users JOIN images ON users.id = images.user_id WHERE users.id IN ($in)");

    $statement->execute(
    $stringFriends
  );

  $users = $statement->fetchAll(PDO::FETCH_ASSOC); 
  return $users;
}

