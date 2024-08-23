<?php
include 'connection.php';

// Récupération des données
$Num_S = isset($_POST['Num_S']) ? (int) $_POST['Num_S'] : 0;
$N_Groupe = isset($_POST['N_Groupe']) ? (int) $_POST['N_Groupe'] : 0;
$Niveau = isset($_POST['Niveau']) ? (int) $_POST['Niveau'] : 0;
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$matiere = isset($_POST['matiere']) ? mysqli_real_escape_string($conn, $_POST['matiere']) : '';
$note1 = isset($_POST['note1']) && $_POST['note1'] !== '' ? (float) $_POST['note1'] : NULL;
$note2 = isset($_POST['note2']) && $_POST['note2'] !== '' ? (float) $_POST['note2'] : NULL;
$note3 = isset($_POST['note3']) && $_POST['note3'] !== '' ? (float) $_POST['note3'] : NULL;

// Calcul de la moyenne
$total = 0;
$count = 0;

if ($note1 !== NULL) {
    $total += $note1;
    $count++;
}

if ($note2 !== NULL) {
    $total += $note2;
    $count++;
}

if ($note3 !== NULL) {
    $total += $note3;
    $count++;
}

$avg = $count > 0 ? round($total / $count, 2) : 'NULL';

// Recherche pour savoir si l'enregistrement existe déjà pour l'étudiant, la matière, le groupe, et le niveau
$searchsql = "SELECT * FROM resultats WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau=$Niveau AND matiere='$matiere'";
$result = mysqli_query($conn, $searchsql);

if (mysqli_num_rows($result) > 0) {
    // Mise à jour de l'enregistrement existant
    $sql = "UPDATE resultats SET note1=" . ($note1 === NULL ? 'NULL' : $note1) . ", note2=" . ($note2 === NULL ? 'NULL' : $note2) . ", note3=" . ($note3 === NULL ? 'NULL' : $note3) . ", avg=$avg WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau=$Niveau AND matiere='$matiere'";
} else {
    // Insertion d'un nouvel enregistrement
    $sql = "INSERT INTO resultats (id_S, Num_S, N_Groupe, Niveau, matiere, note1, note2, note3, avg) VALUES ($id, $Num_S, '$N_Groupe', '$Niveau', '$matiere', " . ($note1 === NULL ? 'NULL' : $note1) . ", " . ($note2 === NULL ? 'NULL' : $note2) . ", " . ($note3 === NULL ? 'NULL' : $note3) . ", $avg)";
}

// Exécution de la requête et gestion de la redirection
if (mysqli_query($conn, $sql)) {
    $msg = "success";
} else {
    $msg = "error";
}

header("Location: resultats.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=".$id."&Num_S=".$Num_S."&msg=".$msg);
exit();

// Fermeture de la connexion
mysqli_close($conn);

?>
