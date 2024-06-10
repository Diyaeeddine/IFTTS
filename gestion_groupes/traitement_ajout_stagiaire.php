<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connection.php';

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $N_Groupe = $_POST['N_Groupe'];

    $sql = $conn->prepare("INSERT INTO stagiaires (nom, prenom, N_Groupe) VALUES (?, ?, ?)");
    $sql->bind_param("ssi", $nom, $prenom, $N_Groupe);

    if ($sql->execute()) {
        header("Location: ajouter_stagiaire.php?msg=success");
    } else {
        $error_msg = "Erreur : " . $conn->error;
        header("Location: ajouter_stagiaire.php?msg=" . urlencode($error_msg));
    }

    $sql->close();
    $conn->close();
}
?>
