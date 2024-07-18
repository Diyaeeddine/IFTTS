<?php
include('connection.php');

if (isset($_GET['N_Seance'])) {

  $N_Seance = htmlspecialchars($_GET['N_Seance'], ENT_QUOTES);
  $CIN = htmlspecialchars($_GET['CIN'], ENT_QUOTES);
  $mois = htmlspecialchars($_GET['mois'], ENT_QUOTES);
  $matieres = htmlspecialchars($_GET['matieres'], ENT_QUOTES);
  $Niveau = htmlspecialchars($_GET['Niveau'], ENT_QUOTES);
  $N_Groupe = htmlspecialchars($_GET['N_Groupe'], ENT_QUOTES);
  $ID_suivi = htmlspecialchars($_GET['ID_suivi'], ENT_QUOTES);
  $N_heures = htmlspecialchars($_GET['N_heures'], ENT_QUOTES);
  $titres_module = htmlspecialchars($_GET['titres_module'], ENT_QUOTES);
  $matieres_encoded = urlencode($matieres);
  $stmt = $conn->prepare("DELETE FROM suivi_formations WHERE N_Seance = ? AND ID_suivi = ? AND N_heures = ?");
  $stmt->bind_param("sss", $N_Seance, $ID_suivi, $N_heures);
  $stmt->execute();

  if ($stmt->affected_rows > 0 ) {
    header("Location: table_suivi.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&CIN=".$CIN."&matieres=".htmlspecialchars($matieres_encoded)."&mois=".$mois);
    exit();
  } else {

    echo "Erreur lors de la suppression.";
  }

  $stmt->close(); 
 
} else {

  echo "Paramètre N_Seance manquant.";
}

?>
