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