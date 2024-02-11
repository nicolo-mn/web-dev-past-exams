<?php 
class DbOp {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "febbraio", 3306);
    }

    public function verify_input() {
        $verification = false;
        if (isset($_POST["mode"]) && ($_POST["mode"] === 'html' || $_POST["mode"] === 'json')) {
            $verification = true;
            if (isset($_POST["id"])) {
                $query = "SELECT COUNT(*) as count FROM dati WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('i', $_POST["id"]);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["count"];
                $verification = $res === 1;
            }
        }
        return $verification;
    }
    
    public function select_row($id) {
        if (isset($id)) {
            $query = "SELECT * FROM dati WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $_POST["id"]);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $query = "SELECT * FROM dati";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }
    public function print_html($arr) {
        $res = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            <table>';
        $res .= '<tr><th>id</th><th>chiave</th><th>valore</th></tr>';
        foreach($arr as $elem) {
            $res .= "<tr><td>" . $elem["id"] . "</td><td>". $elem["chiave"] . "</td><td>" . $elem["valore"] . "</td></tr>";
        }
        $res .= '</table>
            </body>
        </html>';
        return $res;
    }
    public function print_json($arr) {
        return json_encode($arr);
    }

}

$obj = new DbOp();

if ($obj->verify_input()) {
    $arr = $obj->select_row(isset($_POST["id"]) ? $_POST["id"] : null);
    $mode = $_POST["mode"];
    if ($mode === 'html') {
        echo $obj->print_html($arr);
    } else {
        echo $obj->print_json($arr);
    }
} else {
    echo "Errore parametri errati";
}