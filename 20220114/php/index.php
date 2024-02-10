<?php
$db = new mysqli("localhost", "root", "", "db_esami", 3306);
if (
        isset($_GET['nome']) && 
        isset($_GET['cognome']) &&
        isset($_GET['codicefiscale']) &&
        isset($_GET['datadinascita']) &&
        isset($_GET['sesso']) &&
        is_string($_GET['nome']) &&
        is_string($_GET['cognome']) &&
        is_string($_GET['codicefiscale']) &&
        strlen($_GET['codicefiscale']) === 16 &&
        ($_GET['sesso'] === 'A' || $_GET['sesso'] === 'F' || $_GET['sesso'] === 'M')
    ) {
    $query = "INSERT INTO cittadino(nome, cognome, codicefiscale, datanascita, sesso) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sssss', $_GET['nome'], $_GET['cognome'],$_GET['codicefiscale'],$_GET['datadinascita'],$_GET['sesso']);
    $stmt->execute();
    if(!$stmt->get_result()) {
        echo "Inserimento avvenuto" . "<br>";
    }
}

$res;
$query;
$stmt;
if (isset($_GET["id"])) {
    $query = "SELECT * FROM cittadino WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $_GET["id"]);
    $stmt->execute();
} else {
    $query = "SELECT * FROM cittadino";
    $stmt = $db->prepare($query);
    $stmt->execute();
}

$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <?php foreach($res as $cittadino) : ?>
            <tr>
                <td><?= $cittadino["nome"] ?></td>
                <td><?= $cittadino["cognome"] ?></td>
                <td><?= $cittadino["datanascita"] ?></td>
                <td><?= $cittadino["codicefiscale"] ?></td>
                <td><?= $cittadino["sesso"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>