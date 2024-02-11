<?php
require_once "helper.php";
$query = "SELECT chiave, valore FROM dati";
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <title>Visualizza dati</title>
</head>
<body>
    <h2>Database</h2>
    <ul>
    <?php foreach($res as $entry) : ?>
        <li>Chiave: <?= $entry["chiave"] ?>, Valore: <?= $entry["valore"] ?></li>
    <?php endforeach; ?>
    </ul>
    <h2>Cookies</h2>
    <ul>
    <?php foreach($_COOKIE as $key => $value) : ?>
        <li>Chiave: <?= $key ?>, Valore: <?= $value ?></li>
    <?php endforeach; ?> 
    </ul>
</body>
</html>
