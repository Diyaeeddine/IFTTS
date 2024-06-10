<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $filiere = $_POST['filiere'];
        $groupe = $_POST['groupe'];

        $sql = "UPDATE stagiaires SET nom='$nom', prenom='$prenom', filiere='$filiere', N_Groupe='$groupe' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header("Location: liste_stagiaires.php?msg=success");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du stagiaire : " . mysqli_error($conn);
        }
    } else {
        echo "ID du stagiaire non spécifié.";
    }
} else {
    echo "Méthode de requête incorrecte.";
}

mysqli_close($conn);
?>
