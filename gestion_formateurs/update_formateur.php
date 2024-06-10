<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['CIN'])) {
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

        $sql = "UPDATE formateurs 
        SET
            nom='$nom', 
            prenom='$prenom', 
            ville='$ville', 
            sexe='$sexe', 
            Situation_familiale='$Situation_familiale', 
            telephone='$telephone', 
            email='$email', 
            grade='$grade', 
            diplome_re='$diplome_re', 
            diplome_accees='$diplome_acces', 
            date_naissance='$date_naissance', 
            rib='$rib' 
        WHERE CIN='$CIN'";        
        if ($conn->query($sql) === TRUE) {
            header("Location: liste_formateurs.php?msgupdate=success");
            exit();
        } else {
            header("Location: liste_formateurs.php?msgupdate=errorUpdate");
            exit();
        }
    } else {
        echo "Toutes les données nécessaires n'ont pas été fournies.";
    }
} else {
    echo "Cette page ne peut être accédée directement.";
}
?>
