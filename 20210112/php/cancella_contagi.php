<?php
require_once "database.php";
if (isset($_POST["data"])) {
    $datamysql = date_format(date_create_from_format('m-d-Y', $_POST["data"]), 'Y-m-d');
    $query = "SELECT COUNT(*) as count FROM contagi WHERE data = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $datamysql);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"];
    if ($res) {
        $query = "DELETE FROM contagi WHERE data = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $datamysql);
        $stmt->execute();
    } else {
        echo "Errore data non presente";
    }
} else {
    echo "Errore data non ricevuta";
}