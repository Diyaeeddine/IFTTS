<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['CIN']) && isset($_POST['oldCIN'])) {
        $oldCIN = $_POST["oldCIN"];
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
        $diplome_acces = $_POST["diplome_accees"];
        $date_naissance = $_POST["date_naissance"];
        $rib = $_POST["rib"];

        // Désactiver les contraintes de clés étrangères
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");

        // Mise à jour des tables étrangères
        $conn->query("UPDATE vacations SET CIN = '$CIN' WHERE CIN = '$oldCIN'");
        $conn->query("UPDATE suivi_formations SET CIN = '$CIN' WHERE CIN = '$oldCIN'");
        $conn->query("UPDATE programme_groupes SET CIN_formateur = '$CIN' WHERE CIN_formateur = '$oldCIN'");

        // Mise à jour de la table formateurs
        $sql = "UPDATE formateurs 
                SET CIN='$CIN', nom='$nom', prenom='$prenom', sexe='$sexe', Situation_familiale='$Situation_familiale', 
                ville='$ville', telephone='$telephone', email='$email', grade='$grade', diplome_re='$diplome_re', 
                diplome_accees='$diplome_acces', date_naissance='$date_naissance', rib='$rib' 
                WHERE CIN='$oldCIN'";

        if ($conn->query($sql) === TRUE) {
            header("Location:liste_formateurs.php");
        } else {
            echo "Erreur lors de la modification du formateur: " . $conn->error;
        }

        // Réactiver les contraintes de clés étrangères
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    } else {
        echo "Données manquantes pour effectuer la modification.";
    }
}
?>

<a href="liste_formateurs.php">Retour à la liste des formateurs</a>
