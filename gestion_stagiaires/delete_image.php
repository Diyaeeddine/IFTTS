<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $N_Groupe = $_POST['N_Groupe'];
    $Niveau = $_POST['Niveau'];
    $image_src = $_POST['image_src'];

    
    $sql = "UPDATE stagiaires SET image_src = NULL WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "L'image a été supprimée de la base de données.";
        header("Location: details_stagiaire.php?id=" . $id."&N_Groupe=".$N_Groupe."&Niveau=".$Niveau.""); // Redirige vers la page de détails du formateur
 
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la base de données.";
    }
}
?>
