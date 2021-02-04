<?php

require_once 'check_login.php';
require_once 'config.php';
include 'templates/header.php';

$mess = isset($_GET['mess']) ? "<p class='text-error'>" . $_GET['mess'] . "</p>" : "";

$sql = "SELECT * FROM users ORDER BY id;";
$stm = initDatabase($database)->prepare($sql);
$stm->execute();

$res = $stm->fetchAll(pdo::FETCH_ASSOC);

$table = "<table class ='table table-striped table-hover'>";


$table .= "<thead><tr><th>Förnamn</th><th>Efternamn</th><th>Epost</th></tr></thead><tbody>";


foreach ($res as $row) {
    $table .= "\n\t\t<tr>";
    $table .= "\n\t\t\t<td>" . $row['fname'] . "</td>";
    $table .= "\n\t\t\t<td>" . $row['lname'] . "</td>";
    $table .= "\n\t\t\t<td>" . $row['email'] . "</td>";
}

$table .= "\n\t<tbody>\n</table>";

?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Instalight</title>

</head>

<body>

    <div>
        <h2>inloggad som</h2>
        <?php echo $table; ?>
    </div>

</body>

</html>