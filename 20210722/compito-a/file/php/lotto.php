<?php 
if (
    isset($_POST["action"]) &&
    ($_POST["action"] === "extract" || $_POST["action"] === "new" || $_POST["action"] === "check")
) {
    $action = $_POST["action"];
    $db = new mysqli("localhost", "root", "", "lotto", 3306);
    $message;
    switch($action) {
        case "extract":
            $n = random_int(1, 90);
            $query = "SELECT COUNT(*) as count FROM estrazione";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $count = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"];
            $query = "SELECT COUNT(*) as count FROM estrazione WHERE numero = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $n);
            $stmt->execute();
            $present = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"] === 1;
            if (!$present && $count <= 5) {
                $query = "INSERT INTO estrazione(numero) VALUES (?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param('i', $n);
                $stmt->execute();
                $message = "Inserimento riuscito";
            } else {
                $message = "Inserimento fallito";
            }
            break;
        case "new":
            $query = "DELETE FROM estrazione";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $message = "Avvenuto inizio partita";
            break;
        case "check":
            $sequence = $_POST["sequence"];
            $guesses = [];
            $guess = "";
            for ($i = 0; $i < strlen($sequence); $i++) {
                if (is_numeric($sequence[$i])) {
                    $guess = $guess . $sequence[$i];
                } else {
                    $guesses[] = $guess;
                    $guess = "";
                }
            }
            $guesses[] = $guess;
            $check = true;
            for ($i = 0; $i < count($guesses) && $check; $i++) {
                $query = "SELECT COUNT(*) as count FROM estrazione WHERE numero = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('i', $guesses[$i]);
                $stmt->execute();
                $check = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"] === 1;
            }
            if ($check) {
                $message = "Tentativo corretto";
            } else {
                $message = "Tentativo errato";
            }
            break;
    }
    $jsonObj = array("message" => $message);
    echo json_encode($jsonObj);
}