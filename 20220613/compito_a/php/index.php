<?php
if (isset($_POST['message'])) {
    $conn = new mysqli('localhost', 'root', '', 'esami', 3306);
    if ($_POST['message'] === 'newGame') {
        $query = "SELECT id FROM sudoku ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $n = $res[0]["id"] + 1;
        setcookie("id", $n, time() + 60*60*24*30, "/");
        $valoreIniziale = '000005000000020000000006000000070000001000000000003000000000000008000000000000004';
        $query = "INSERT INTO sudoku VALUES (?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('is', $n, $valoreIniziale);
        if ($stmt->execute()) echo json_encode($valoreIniziale);
    } else if ($_POST['message'] === 'evaluate') {
        $res = $_POST['result'];
        $correct = true;
        $tmp = [];
        if (isset($_COOKIE["id"])) {
            //lines
            for ($i = 0; $i < 9; $i++) {
                for ($j = 0; $j < 9; $j++) {
                    if (in_array($res[$i*9+$j], $tmp)) {
                        $correct = false;
                    } else {
                        $tmp[] = $res[$i*9+$j];
                    }
                }
                $tmp = [];
            }
            //cols
            for ($i = 0; $i < 9; $i++) {
                for ($j = 0; $j < 9; $j++) {
                    if (in_array($res[$i+$j*9], $tmp)) {
                        $correct = false;
                    } else {
                        $tmp[] = $res[$i+$j*9];
                    }
                }
                $tmp = [];
            }
            //squares
            for ($i = 0; $i < 9; $i += 3) {
                for ($j = 0; $j < 9; $j += 3) {
                    for ($m = $i; $m < $i + 3; $m++) {
                        for ($n = $j; $n < $j + 3; $n++) {
                            if (in_array($res[$m+$n*9], $tmp)) {
                                $correct = false;
                            } else {
                                $tmp[] = $res[$m+$n*9];
                            }
                        }
                    }
                    $tmp = [];
                }
            }
            //base solution
            $valoreIniziale = '000005000000020000000006000000070000001000000000003000000000000008000000000000004';
            for ($i = 0; $i < 9*9; $i++) {
                if ($valoreIniziale[$i] != 0 && $valoreIniziale[$i] != $res[$i]) {
                    $correct = false;
                }
            }
        } else {
            $correct = false;
        }
        echo json_encode($correct);
    }
}