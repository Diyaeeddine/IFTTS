<?php
include 'connection.php';
$CIN = $_POST['CIN'];
$mois = $_POST['mois'];
$Niveau = $_POST['Niveau'];
$nombre = $_POST['nombre'];
$Taux = $_POST['Taux'];
$pourceir = $_POST['pourceir'];
$Brut = $nombre * $Taux;
$IR = $Brut * ($pourceir/100);
$NET = $Brut - $IR;
$sql = "INSERT INTO vacations (CIN, mois,Niveau,Tn_heures, Taux, BRUT, IR, NET)
                 VALUES ('$CIN','$mois',$Niveau,$nombre,'$Taux','$Brut', '$IR', '$NET')";

if ($conn->query($sql) === TRUE) {
    header("Location: ajouter_vacations.php?success=Frais%20ajoutés%20avec%20succès");

    exit();

} else {
    header("Location: ajouter_vacations.php?error=Erreur%20lors%20de%20l'ajout%20des%20frais%20:%20" . $conn->error);
    exit();}

$conn->close();
?>