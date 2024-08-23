<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iftts";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
?>
