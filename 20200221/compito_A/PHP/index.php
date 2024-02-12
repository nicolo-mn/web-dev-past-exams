<?php
    $db = new mysqli("localhost", "root", "", "febbraio", 3306);
    $query;
    $stmt;
    if (isset($_COOKIE["notizie"])) {
        $query = "SELECT Titolo, Descrizione FROM articoli WHERE categoria = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $_COOKIE["notizie"]);
    } else {
        $query = "SELECT Titolo, Descrizione FROM articoli";
        $stmt = $db->prepare($query);
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<html lang="it">
  <head>
    <title>Esercizio PHP</title>
  </head>
  <body>
    <div class="header">
      <a  class="home">Esercizio PHP</a>
      <div class="products">
        <a href="index.php">Homepage</a>
        <a href="settings.php">Settings</a>
      </div>
    </div>
    <?php foreach($result as $article) : ?>
    <article>
        <div>
            <h1><?= $article["Titolo"] ?></h1>
            <p><?= $article["Descrizione"] ?></p>
        </div>
    </article>
    <?php endforeach; ?>
  </body>
</html>
