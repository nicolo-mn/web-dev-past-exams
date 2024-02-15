<?php
if (isset($_GET["soglia"]) && is_numeric($_GET["soglia"]) && $_GET["soglia"] > 0) {
    $soglia = $_GET["soglia"];
    $db = new mysqli("localhost", "root", "", "esami", 3306);
    if ($db->connect_error) {
        die("Connection error");
    }
    $query = "SELECT numero FROM numeri WHERE numero > ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $soglia);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $res = [];
    foreach ($result as $num) {
        $res[] = $num["numero"];
    }
    for ($i = 1; $i < count($res); $i++) {
        for ($j = $i; $j > 0 && $res[$j] > $res[$j - 1]; $j--) {
            $tmp = $res[$j];
            $res[$j] = $res[$j - 1];
            $res[$j - 1] = $tmp;
        }
    }
    echo json_encode($res);
} else {
    echo "Soglia non presente";
}