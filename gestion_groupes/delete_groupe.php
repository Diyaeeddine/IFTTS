<?php
include "connection.php";

if (isset($_GET['N_Groupe'])) {
    $N_Groupe = $_GET['N_Groupe'];
    $sql = "DELETE FROM groupes WHERE N_Groupe='$N_Groupe'";
    $sql1 = "DELETE FROM suivi_formations WHERE N_Groupe='$N_Groupe'";
    $sql2 = "DELETE FROM programme_groupes WHERE N_Groupe='$N_Groupe'";
    $sql3 = "DELETE FROM stagiaires WHERE N_Groupe='$N_Groupe'";
    $sql4 = "DELETE FROM vacations WHERE N_Groupe='$N_Groupe'";

    $conn->begin_transaction();
    
    try {
        $conn->query($sql1);
        $conn->query($sql2);
        $conn->query($sql3);
        $conn->query($sql4);
        
        if ($conn->query($sql) === TRUE) {
            $conn->commit();
            header("Location: liste_groupe.php?msg=Success");
            exit();
        } else {
            throw new Exception("Erreur lors de la suppression du groupe");
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: liste_groupe.php?msg=Error&detail=" . urlencode($e->getMessage()));
        exit();
    }

    $conn->close();
} else {
    header("Location: liste_groupe.php");
    exit();
}
?>
