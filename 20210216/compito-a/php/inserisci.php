<?php
require_once "helper.php";
if (
    isset($_GET["chiave"]) &&
    isset($_GET["valore"]) &&
    isset($_GET["metodo"]) &&
    ($_GET["metodo"] === 'db' || $_GET["metodo"] === 'cookie')
) {
    $metodo = $_GET["metodo"];
    $chiave = $_GET["chiave"];
    $valore = $_GET["valore"];
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