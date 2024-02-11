<?php
$db = new mysqli("localhost", "root", "", "febbraio", 3306);

if ($db->connect_error) {
    die("Errore db");
}