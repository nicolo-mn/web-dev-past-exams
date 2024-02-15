<?php
    $db = new mysqli("localhost", "root", "", "esami", 3306);
    $query = "SELECT citta FROM temperature WHERE min = 0 AND max = 0";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $cities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    if (isset($_GET["citta"]) || isset($_GET["tMin"]) || isset($_GET["tMax"])) {
        $query = "UPDATE temperature SET min = ?, max = ? WHERE citta = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iis', $_GET["tMin"], $_GET["tMax"], $_GET["citta"]);
        $stmt->execute();
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
        <?php foreach($cities as $city) : ?>
            <option value="<?= $city["citta"] ?>"><?= $city["citta"] ?></option>
        <?php endforeach; ?>
      </select>
      <label for="tMin">Minima</label> <input type="text" size="2" name="tMin"/>
      <label for="tMax">Massima</label> <input type="text" size="2" name="tMax"/><br />
      <input type="submit" value="Invia" />
    </form>
  </body>
</html>