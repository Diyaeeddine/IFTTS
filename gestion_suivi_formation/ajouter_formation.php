<?php
include 'connection.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['N_Groupe'], $_POST['Niveau'], $_POST['CIN'], $_POST['matiere'])) {
        $N_Groupe = mysqli_real_escape_string($conn, $_POST['N_Groupe']);
        $Niveau = mysqli_real_escape_string($conn, $_POST['Niveau']);
        $CIN = mysqli_real_escape_string($conn, $_POST['CIN']);
        $matiere = mysqli_real_escape_string($conn, $_POST['matiere']);

        // Initialisez les messages pour éviter d'envoyer des échos avant le header
        $msg = "";

        // Vérifiez si l'association existe déjà dans programme_groupes
        $check_sql_pg = "SELECT * FROM programme_groupes WHERE N_Groupe = '$N_Groupe' AND matieres = '$matiere' AND CIN_formateur = '$CIN'";
        $check_result_pg = mysqli_query($conn, $check_sql_pg);

        $pg_exists = ($check_result_pg && mysqli_num_rows($check_result_pg) > 0);

        if (!$pg_exists) {
            // Ajoutez la nouvelle association dans programme_groupes
            $sqlpg = "INSERT INTO programme_groupes (N_Groupe, Niveau, matieres, CIN_formateur) VALUES ('$N_Groupe', '$Niveau', '$matiere', '$CIN')";
            if (mysqli_query($conn, $sqlpg)) {
                $msg = "Formation et formateur ajoutés avec succès.";
            } else {
                $msg = "Erreur lors de l'ajout dans programme_groupes: " . mysqli_error($conn);
            }
        } else {
            if ($Niveau == 1) {
                $msg = "Cette liaison entre la formation et le formateur existe déjà dans ce niveau ou en 2ème année.";
            } elseif ($Niveau == 2) {
                $msg = "Cette liaison entre la formation et le formateur existe déjà dans ce niveau ou en 1ère année.";
            }
        }

        header("Location: suivi_formation.php?N_Groupe=$N_Groupe&Niveau=$Niveau&msg=" . urlencode($msg));
        exit();
    } else {
        echo "Tous les champs sont requis.";
    }
} else {
    echo "Méthode de requête non supportée.";
}
?>
