<?php
include "connection.php";

if (isset($_GET['id']) && isset($_GET['N_Groupe']) && isset($_GET['Niveau']) && isset($_GET['CIN'])) {
    $N_Groupe = $_GET['N_Groupe'];
    $Niveau = $_GET['Niveau'];
    $CIN = $_GET['CIN'];
    $id = $_GET['id'];

    // Search for the number of records in stagiaires_groupes for the given id_stagiaire
    $searchsql = "SELECT * FROM stagiaires_groupes WHERE id_stagiaire='$id'";
    $searchresult = $conn->query($searchsql);
    $num_rows = mysqli_num_rows($searchresult);

    if ($num_rows == 1) {
        // If there is only one row, delete from all related tables including the stagiaire
        $sql1 = "DELETE FROM pv_notes WHERE id_S='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $conn->query($sql1);
        
        $sql2 = "DELETE FROM resultats WHERE id_S='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $conn->query($sql2);
        
        $sql3 = "DELETE FROM stagiaires_groupes WHERE id_stagiaire='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $conn->query($sql3);
        
        $sql4 = "DELETE FROM stagiaires WHERE CIN='$CIN'";
        $result4 = $conn->query($sql4);

    } elseif ($num_rows > 1) {
        // If there are more than one row, delete from related tables but not the stagiaire
        $sql2 = "DELETE FROM resultats WHERE id_S='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $result2 = $conn->query($sql2);
        
        $sql3 = "DELETE FROM pv_notes WHERE id_S='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $result3 = $conn->query($sql3);
        
        $sql = "DELETE FROM stagiaires_groupes WHERE id_stagiaire='$id' AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $result = $conn->query($sql);
    }

    if ($conn->affected_rows > 0) {
        header("Location: liste_stagiaires.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&msg=Success");
    } else {
        header("Location: liste_stagiaires.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&msg=Error");
    }
    
    $conn->close();
} else {
    echo "Error: Missing parameters in the URL.";
    exit();
}
?>
