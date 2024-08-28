<?php 
include 'connection.php';

if (isset($_POST['update'])) {
    $ID_suivi = mysqli_real_escape_string($conn, $_POST['ID_suivi']);
    $CIN = mysqli_real_escape_string($conn, $_POST['CIN']);
    $matieres = mysqli_real_escape_string($conn, $_POST['matieres']);
    $Niveau = mysqli_real_escape_string($conn, $_POST['Niveau']);
    $N_Groupe = mysqli_real_escape_string($conn, $_POST['N_Groupe']);
    $jours = mysqli_real_escape_string($conn, $_POST['jours']);
    $horaire = mysqli_real_escape_string($conn, $_POST['horaire']);
    $N_Seance = mysqli_real_escape_string($conn, $_POST['N_Seance']);
    $mois = mysqli_real_escape_string($conn, $_POST['mois']);
    $titres_module = mysqli_real_escape_string($conn, $_POST['titres_module']);
    $observations = mysqli_real_escape_string($conn, $_POST['observations']);
    $heures = calculateHours($horaire);

    $update_query = "UPDATE suivi_formations 
                     SET jours='$jours',N_Seance='$N_Seance', horaire='$horaire', titres_module='$titres_module', N_heures='$heures', observations='$observations' 
                     WHERE ID_suivi='$ID_suivi'";

    if (mysqli_query($conn, $update_query)) {
        $success_message = "Séance mise à jour avec succès.";
    header("Location: table_suivi.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&CIN=".$CIN."&matieres=".htmlspecialchars(urlencode($_POST['matieres']))."&mois=".$mois."&msg=".$success_message."");

    } else {
        $error_message = "Erreur lors de la mise à jour de la séance : " . mysqli_error($conn);
    header("Location: table_suivi.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&CIN=".$CIN."&matieres=".htmlspecialchars(urlencode($_POST['matieres']))."&mois=".$mois."&msg=".$error_message."");

    }
}

if (isset($_GET['ID_suivi'])) {
    $ID_suivi = mysqli_real_escape_string($conn, $_GET['ID_suivi']);
    $query = "SELECT * FROM suivi_formations WHERE ID_suivi='$ID_suivi'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Séance non trouvée.";
        exit;
    }
} else {
    echo "ID de suivi non fourni.";
    exit;
}

function calculateHours($horaire) {
    $timeParts = explode(' - ', $horaire);
    $startTime = $timeParts[0];
    $endTime = $timeParts[1];

    $startHours = (int)explode('h', $startTime)[0];
    $startMinutes = (int)explode('h', $startTime)[1] ?? 0;
    $endHours = (int)explode('h', $endTime)[0];
    $endMinutes = (int)explode('h', $endTime)[1] ?? 0;

    $startDate = new DateTime();
    $startDate->setTime($startHours, $startMinutes);
    $endDate = new DateTime();
    $endDate->setTime($endHours, $endMinutes);

    $interval = $endDate->diff($startDate);
    $hours = $interval->h + $interval->i / 60;

    return $hours;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Séance</title>
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="m-4 text-center">Modifier Séance</h2>

    <?php if (isset($success_message)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
    <?php } ?>

    <?php if (isset($error_message)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
    <?php } ?>

    <form method="post" action="">
        <input type="hidden" name="ID_suivi" value="<?php echo $row['ID_suivi']; ?>">
        <input type="hidden" name="CIN" value="<?php echo $row['CIN']; ?>">
        <input type="hidden" name="matieres" value="<?php echo $row['matiere']; ?>">
        <input type="hidden" name="Niveau" value="<?php echo $_GET['Niveau']; ?>">
        <input type="hidden" name="N_Groupe" value="<?php echo $_GET['N_Groupe']; ?>">
        <input type="hidden" name="mois" value="<?php echo $row['mois']; ?>">

        <div class="form-group">
            <label for="N_Seance">N° de Séance</label>
            <input type="text" class="form-control" id="N_Seance" name="N_Seance" value="<?php echo $row['N_Seance']; ?>" required>
        </div>
        <div class="form-group">
            <label for="jours">Jour</label>
            <input type="date" class="form-control" id="jours" name="jours" value="<?php echo date('Y-m-d', strtotime($row['jours'])); ?>" required>
        </div>
        <div class="form-group">
            <label for="horaire">Horaire (ex: 09h - 11h)</label>
            <input type="text" class="form-control" id="horaire" name="horaire" value="<?php echo $row['horaire']; ?>" required>
        </div>
        <div class="form-group">
            <label for="titres_module">Titres des leçons ou Modules</label>
            <input type="text" class="form-control" id="titres_module" name="titres_module" value="<?php echo $row['titres_module']; ?>" required>
        </div>
        <div class="form-group">
            <label for="observations">Observations</label>
            <input type="text" class="form-control" id="observations" name="observations" value="<?php echo $row['observations']; ?>">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
