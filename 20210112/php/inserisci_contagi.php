<?php
require_once "database.php";
if (isset($_POST["data"]) && isset($_POST["contagi"])) {
    $data = $_POST["data"];
    $contagi = $_POST["contagi"];
    $d = date_create_from_format('m-d-Y', $data);
    if ($d && date_format($d, 'm-d-Y') === $data) {
        $_SESSION["data"] = $data;
        $_SESSION["contagi"] = $contagi;
        echo "Inserimento in sessione avvenuto<br>";
        $query = "SELECT COUNT(*) as count FROM contagi WHERE data = ?";
        $stmt = $db->prepare($query);
        $datamysql = date_format($d, 'Y-m-d');
        $stmt->bind_param('s', $datamysql);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"];
        if ($res) {
            $query = "UPDATE contagi SET numerocontagi = ? WHERE data = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('is', $contagi, $datamysql);
            if($stmt->execute()) {
                echo "Aggiornamento avvenuto";
            } else {
                "Aggiornamento fallito";
            }
        } else {
            $query = "INSERT INTO contagi(numerocontagi, data) VALUES (?,?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('is', $contagi, $datamysql);
            if($stmt->execute()) {
                echo "Inserimento avvenuto";
            } else {
                "Inserimento fallito";
            }
        }

    }
}