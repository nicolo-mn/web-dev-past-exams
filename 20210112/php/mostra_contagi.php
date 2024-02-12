<?php
require_once "database.php";
$query = "SELECT * FROM contagi";
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <title>Mostra contagi</title>
</head>
<body>
    <ul>
        <?php foreach($res as $entry) : ?>
        <li>Data: <?= $entry["data"] ?> - Numero Contagi: <?= $entry["numerocontagi"] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>