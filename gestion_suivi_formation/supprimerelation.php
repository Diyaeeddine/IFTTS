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
    if (mysqli_query($conn, $sql)) {
        $msg = "Association supprimée avec succès.";
    } else {
        $msg = "Erreur lors de la suppression de l'association: " . mysqli_error($conn);
    }

    // Redirigez l'utilisateur avec un message de confirmation ou d'erreur
    header("Location: suivi_formation.php?N_Groupe=$N_Groupe&Niveau=$Niveau&msg=" . urlencode($msg));
    exit();
} else {
    echo "Paramètres manquants dans l'URL.";
}
?>
