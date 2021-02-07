<?php

function addImgProfileToDatabase ($pdo, $id, $img_profile) {

$sql = 'INSERT INTO users (id, img_profile) VALUES (:id, :img_profile)';
$statement = $pdo->prepare($sql);
    
    $statement->execute([
        'id' => $id,
        'img_profile' => $img_profile,
    ]);
}

function selectImage($pdo, $img_profile) {

    $sql = 'SELECT users FROM img_profile = :img_profile, WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $img_profile,
    ]);
    
}



?>