<?php
include 'connection.php';

if (isset($_POST['id']) && isset($_GET['N_Groupe']) && isset($_GET['Niveau'])) {
    // Disable foreign key checks
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

    $id = (int)$_POST['id'];
    $CIN = $_POST['CIN'];
    $Niveau = (int)$_GET['Niveau'];
    $N_Groupe = (int)$_GET['N_Groupe'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_N = $_POST['date_N'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $Num_S = $_POST['Num_S'];
    $email = $_POST['email'];
    $groupe = (int)$_POST['groupe'];

    // Check if Num_S already exists in another record
    $check_sql = "SELECT COUNT(*) AS count FROM stagiaires WHERE Num_S = '$Num_S' AND id != $id";
    $result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        echo "<script>alert('Le Numero de stagiaire existe déjà pour un autre stagiaire. Veuillez choisir un autre .'); window.history.back();</script>";
    } else {
        // Update stagiaires table
        $sql_stagiaires = "UPDATE stagiaires SET CIN='$CIN', nom='$nom', prenom='$prenom', date_N='$date_N', address='$address', tel='$tel', email='$email', Num_S='$Num_S' WHERE id=$id";
        
        // Update other tables
        $sql1 = "UPDATE pv_notes SET Num_S='$Num_S' WHERE id_S=$id AND N_Groupe='$groupe' AND Niveau='$Niveau'";
        $sql2 = "UPDATE resultats SET Num_S='$Num_S' WHERE id_S=$id AND N_Groupe='$groupe' AND Niveau='$Niveau'";
        $sql3 = "UPDATE stagiaires_groupes SET N_Groupe='$groupe' WHERE id_stagiaire = $id AND Niveau = '$Niveau'";

        if (mysqli_query($conn, $sql_stagiaires) && mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
            // Re-enable foreign key checks
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");

            header("Location: liste_stagiaires.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&msg=success");
            exit();
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
            
            // Re-enable foreign key checks even if there's an error
            mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
        }
    }
} else {
    echo "ID du stagiaire non spécifié.";
}

mysqli_close($conn);
?>
