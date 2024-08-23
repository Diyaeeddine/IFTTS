<?php
include 'connection.php'; // Inclure votre fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CIN = $_POST['CIN'];
    $image_src = $_POST['image_src'];

    // Mettez à jour la base de données pour supprimer le chemin de l'image
    $sql = "UPDATE formateurs SET image_src = NULL WHERE CIN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $CIN);

    if ($stmt->execute()) {
        echo "L'image a été supprimée de la base de données.";
        header("Location: details.php?CIN=" . $CIN); // Redirige vers la page de détails du formateur
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la base de données.";
    }
}
?>
