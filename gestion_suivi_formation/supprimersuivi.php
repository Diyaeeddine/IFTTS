<?php
// Inclusion of the connection file (assuming it's named 'connection.php')
include('connection.php');

if (isset($_GET['N_Seance'])) {

  $N_Seance = ($_GET['N_Seance']);
  $CIN =($_GET['CIN']);
  $mois =($_GET['mois']);
  $matieres =$_GET['matieres'];
  $Niveau =($_GET['Niveau']);
  $N_Groupe =($_GET['N_Groupe']);
  $ID_suivi =($_GET['ID_suivi']);
  $N_heures =($_GET['N_heures']);
  $titres_module =($_GET['titres_module']);
  
  // Encode the matieres value
  $matieres_encoded = urlencode($matieres);

  $stmt = $conn->prepare("DELETE FROM suivi_formations WHERE N_Seance = ? AND ID_suivi = ? AND N_heures = ?");
  $stmt->bind_param("sss", $N_Seance, $ID_suivi, $N_heures);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    header("Location: table_suivi.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&CIN=".$CIN."&matieres=".htmlspecialchars($matieres_encoded)."&mois=".$mois."");
    exit();
  } else {
    // Deletion failed
    echo "Erreur lors de la suppression.";
  }

  $stmt->close(); // Close the prepared statement
} else {
  // N_Seance parameter missing
  echo "Paramètre N_Seance manquant.";
}

// Connection closure (assuming it's done in connection.php)
// mysqli_close($conn);
?>
