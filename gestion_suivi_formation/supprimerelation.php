<?php
include 'connection.php'; // Connexion à la base de données

// Vérifiez si les paramètres requis sont présents dans l'URL
if (isset($_GET['N_Groupe']) && isset($_GET['Niveau']) && isset($_GET['CIN']) && isset($_GET['matiere'])) { 
    $N_Groupe = mysqli_real_escape_string($conn, $_GET['N_Groupe']);
    $Niveau = mysqli_real_escape_string($conn, $_GET['Niveau']);
    $CIN = mysqli_real_escape_string($conn, $_GET['CIN']);
    $matiere = mysqli_real_escape_string($conn, $_GET['matiere']);

    // Supprimez l'association de la table programme_groupes
    $sql = "DELETE FROM programme_groupes WHERE N_Groupe = '$N_Groupe' AND Niveau = '$Niveau' AND CIN_formateur = '$CIN' AND matieres = '$matiere'";
    
    $sql1=" DELETE FROM vacations WHERE CIN = '$CIN' AND N_Groupe = $N_Groupe AND Niveau = $Niveau AND matiere = '$matiere'";

    $sql2=" DELETE FROM suivi_formations WHERE CIN = '$CIN' AND N_Groupe = $N_Groupe AND Niveau = $Niveau AND matiere = '$matiere'";
    

    if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        $msg = "Association supprimée avec succès.";
    } else {
        $msg = "Erreur lors de la suppression de l'association: " . mysqli_error($conn);
    }

    header("Location: suivi_formation.php?N_Groupe=$N_Groupe&Niveau=$Niveau&msg=" . urlencode($msg));
    exit();

    $stmt1->close(); 
} else {
    echo "Paramètres manquants dans l'URL.";
}
?>
