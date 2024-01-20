<?php
    $db = new mysqli("localhost", "root", "", "climate");
    if ($db->connect_error) {
        die("Errore: ". $db->connect_error);
    }
    $query = "SELECT DISTINCT citta from temperature";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $cities = array();
    foreach($result as $city) {
        $cities[] = $city["citta"];
    }
?>

<html lang="it">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Città Italiane</title>
  </head>
  <body>
    <form action="index.php" method="GET">
      <label for="citta">Città</label>
      <select name="citta">
        <?php
            foreach($cities as $city) {
                echo "<option value=\"".$city."\">".$city."</option>";
            }
        ?>
      </select>
      <input type="submit" value="Invia" />
    </form>
    <?php
        if(isset($_GET['citta'])) {
            $selectedCity = $_GET['citta'];
            $query = "SELECT max FROM temperature WHERE citta = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $selectedCity);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $max = $result[0]["max"];
    
            $query = "SELECT min FROM temperature WHERE citta = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $selectedCity);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $min = $result[0]["min"];
            echo "<p>Città selezionata: ".$selectedCity."</p>";
            echo "<p>Temperatura massima: ".$max."</p>";
            echo "<p>Temperatura minima: ".$min."</p>";
        } 
    ?>
  </body>
</html>
