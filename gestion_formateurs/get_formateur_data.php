<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iftts";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
if (isset($_GET["CIN"])) {
    $CIN = $_GET["CIN"];

    $sql = "SELECT * FROM formateurs WHERE CIN = '$CIN'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row["nom"];
        $prenom = $row["prenom"];
        $ville = $row["ville"];
        $sexe=$row["sexe"];
        $Situation_familiale=$row["Situation_familiale"]; 
        $telephone = $row["telephone"];
        $email = $row["email"];
        $image_src=$row["image_src"];
        $grade = $row["grade"];
        $diplome_re = $row["diplome_re"];
        $diplome_acces = $row["diplome_accees"];
        $date_naissance = $row["date_naissance"];
        $rib = $row["rib"];
    } else {
        echo "Formateur non trouvé.";
    }
} else {
    echo "Paramètre 'CIN' non spécifié.";
}

?>