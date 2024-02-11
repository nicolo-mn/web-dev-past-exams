<?php
require_once "helper.php";
if (
    isset($_POST["chiave"]) &&
    isset($_POST["valore"]) &&
    isset($_POST["metodo"]) &&
    ($_POST["metodo"] === 'db' || $_POST["metodo"] === 'cookie')
) {
    $metodo = $_POST["metodo"];
    $chiave = $_POST["chiave"];
    $valore = $_POST["valore"];
    switch ($metodo) {
        case "db":
            $query = "SELECT COUNT(*) as count FROM dati WHERE chiave = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('s', $chiave);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            if ($res[0]["count"] === 0) {
                $query = "INSERT INTO dati(chiave, valore) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param('ss', $chiave, $valore);
                $stmt->execute();
                echo "Inserimento db avvenuto";
            } else {
                $query = "UPDATE dati SET valore = ? WHERE chiave = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('ss', $valore, $chiave);
                $stmt->execute();
                echo "Aggiornamento db avvenuto";
            }
            break;
        case "cookie":
            if (!isset($_COOKIE[$chiave])) {
                setcookie($chiave, $valore, time() + (86400 * 30), "/");
                echo "Inserimento cookie avvenuto";
            } else {
                setcookie($chiave, $valore, time() + (86400 * 30), "/");
                echo "Aggiornamento cookie avvenuto";
            }
            break;
    }
}