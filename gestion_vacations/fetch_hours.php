<?php
include 'connection.php';

if (isset($_POST['CIN'], $_POST['mois'], $_POST['N_Groupe'], $_POST['Niveau'])) {
    $CIN = $_POST['CIN'];
    $mois = $_POST['mois'];
    $N_Groupe = $_POST['N_Groupe'];
    $Niveau = $_POST['Niveau'];

    $sql = "SELECT sf.CIN AS CIN,
                   SUM(sf.N_heures) AS Nombre
            FROM suivi_formations sf
            JOIN programme_formation pf ON sf.matiere = pf.matieres
            JOIN groupes g ON sf.Niveau = g.Niveau
            WHERE g.N_Groupe = ?
                  AND sf.Niveau = ?
                  AND sf.mois = ?
                  AND CIN = ?
            GROUP BY sf.CIN
            ORDER BY sf.CIN";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $N_Groupe, $Niveau, $mois, $CIN);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['nombre' => $row['Nombre']]);
    } else {
        echo json_encode(['nombre' => 0]);
    }

    $stmt->close();
}
?>
