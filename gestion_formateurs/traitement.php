<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CIN = $_POST["CIN"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $ville = $_POST["ville"];
    $sexe = $_POST["sexe"];
    $Situation_familiale = $_POST["Situation_familiale"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $grade = $_POST["grade"];
    $diplome_re = $_POST["diplome_re"];
    $diplome_acces = $_POST["diplome_acces"];
    $date_naissance = $_POST["date_naissance"];
    $rib = $_POST["rib"];

    include 'connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $checkCINQuery = "SELECT CIN FROM formateurs WHERE CIN = '$CIN'";
    $result = $conn->query($checkCINQuery);

    if ($result->num_rows > 0) {
  
        header("Location: liste_formateurs.php?msgAjoute=ErrorCINExists");
        exit(); 
    } else {

        $sql = "INSERT INTO formateurs (CIN, nom, prenom, sexe, Situation_familiale, ville, telephone, email, grade, diplome_re, diplome_accees, date_naissance, rib) 
        VALUES ('$CIN', '$nom', '$prenom', '$sexe', '$Situation_familiale', '$ville', '$telephone', '$email', '$grade', '$diplome_re', '$diplome_acces', '$date_naissance', '$rib')";

        if ($conn->query($sql) === TRUE) {
            header("Location: liste_formateurs.php?msgAjoute=Success");
            exit(); 
        } else {
            header("Location: liste_formateurs.php?msgAjoute=ErrorAjoute");
        }
    }

    $conn->close();
}
?>
