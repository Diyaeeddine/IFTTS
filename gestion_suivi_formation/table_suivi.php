<?php 
include 'connection.php';

if (isset($_POST['submit'])) {
    $CIN = mysqli_real_escape_string($conn, $_POST['CIN']);
    $matiere = mysqli_real_escape_string($conn, $_POST['matieres']);
    $Niveau = mysqli_real_escape_string($conn, $_POST['Niveau']);
    $N_Groupe = mysqli_real_escape_string($conn, $_POST['N_Groupe']);
    $jours = mysqli_real_escape_string($conn, $_POST['jours']);
    $horaire = mysqli_real_escape_string($conn, $_POST['horaire']);
    $N_Seance = mysqli_real_escape_string($conn, $_POST['N_Seance']);
    $mois = mysqli_real_escape_string($conn, $_POST['mois']);
    $titres_module = mysqli_real_escape_string($conn, $_POST['titres_module']);
    $observations = mysqli_real_escape_string($conn, $_POST['observations']);
    
    $heures = calculateHours($horaire);

    $insert_query = "INSERT INTO suivi_formations (N_Seance, mois, CIN, matiere, jours, horaire, titres_module, N_heures, observations, N_Groupe, Niveau)
                     VALUES ('$N_Seance', '$mois', '$CIN', '$matiere', '$jours', '$horaire', '$titres_module', '$heures', '$observations', '$N_Groupe', '$Niveau')";
    if (mysqli_query($conn, $insert_query)) {
        $success_message = "Nouvelle séance ajoutée avec succès.";
        insertOrUpdateVacation($conn, $CIN, $matiere, $Niveau, $N_Groupe, $mois);
    } else {
        $error_message = "Erreur lors de l'ajout de la nouvelle séance : " . mysqli_error($conn);
    }
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

function insertOrUpdateVacation($conn, $CIN, $matiere, $Niveau, $N_Groupe, $mois) {
    // Fetch the total hours for the month
    $total_hours_query = "
    SELECT SUM(N_heures) as total_hours
    FROM suivi_formations
    WHERE CIN = '$CIN' AND matiere = '$matiere' AND mois = '$mois' AND N_Groupe = '$N_Groupe' AND Niveau = '$Niveau'";
    $total_hours_result = mysqli_query($conn, $total_hours_query);
    $total_hours_row = mysqli_fetch_assoc($total_hours_result);
    $Tn_heures = $total_hours_row['total_hours'];

    // Fetch the dynamic Taux and IR from the settings table
    $config_query = "SELECT taux, ir FROM config ORDER BY last_updated DESC LIMIT 1";
    $settings_result = mysqli_query($conn, $config_query);
    $config_row = mysqli_fetch_assoc($settings_result);
    $Taux = $config_row['taux'];
    $IRN = $config_row['ir'];

    // Calculate the other fields
    $BRUT = $Tn_heures * $Taux;
    $IR = ($IRN / 100) * $BRUT;
    $NET = $BRUT - $IR;

    // Check if an entry already exists
    $check_query = "
    SELECT * FROM vacations
    WHERE CIN = '$CIN' AND matiere = '$matiere' AND N_Groupe = '$N_Groupe' AND mois = '$mois' AND Niveau = '$Niveau'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing entry
        $update_query = "
        UPDATE vacations
        SET Tn_heures = '$Tn_heures', Taux = '$Taux', BRUT = '$BRUT', IR = '$IR', pourcIR = '$IRN', NET = '$NET'
        WHERE CIN = '$CIN' AND matiere = '$matiere' AND N_Groupe = '$N_Groupe' AND mois = '$mois' AND Niveau = '$Niveau'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert a new entry
        $insert_query = "
        INSERT INTO vacations (CIN, matiere, N_Groupe, mois, Niveau, Tn_heures, Taux, BRUT, pourcIR, IR, NET)
        VALUES ('$CIN', '$matiere', '$N_Groupe', '$mois', '$Niveau', '$Tn_heures', '$Taux', '$BRUT', '$IRN', '$IR', '$NET')";
        mysqli_query($conn, $insert_query);
    }
}
  

if (isset($_GET['CIN']) && isset($_GET['matieres']) && isset($_GET['Niveau']) && isset($_GET['N_Groupe']) && isset($_GET['mois'])) {
    $CIN = mysqli_real_escape_string($conn, $_GET['CIN']);
    
    $matieres = mysqli_real_escape_string($conn,$_GET['matieres']);
    // $matieres = urldecode($_GET['matieres']);
    $mois = mysqli_real_escape_string($conn, $_GET['mois']);
    $Niveau = mysqli_real_escape_string($conn, $_GET['Niveau']);
    $N_Groupe = mysqli_real_escape_string($conn, $_GET['N_Groupe']);
    $query = "
    SELECT DISTINCT
        sf.N_Seance AS 'N° DE SEANCE',
        sf.jours AS 'Jours',
        sf.CIN AS 'CIN',
        sf.mois AS 'mois',
        sf.ID_suivi AS 'ID_suivi',
        sf.horaire AS 'Horaire',
        sf.titres_module AS 'Titres des leçons ou Modules',
        sf.N_heures AS 'Nombre d\'heures',
        sf.observations AS 'Observations'
    FROM 
        suivi_formations sf
    JOIN 
        formateurs f ON sf.CIN = f.CIN
    JOIN 
        programme_formation pf ON sf.matiere = pf.matieres
    JOIN 
        programme_groupes pg ON pf.matieres = pg.matieres
    WHERE 
        sf.CIN = '$CIN' AND
        sf.matiere = '$matieres' AND
        sf.Niveau = '$Niveau' AND
        (pf.niveau = $Niveau or pf.niveau = 3) AND
        pg.Niveau = '$Niveau' AND
        mois='$mois' AND
        sf.N_Groupe = '$N_Groupe'
        AND pg.N_Groupe = '$N_Groupe'
    ORDER BY 
        sf.N_Seance ASC;
    ";
    $result = mysqli_query($conn, $query);

    // Calculate total hours for the month
    $total_hours_query = "
    SELECT SUM(N_heures) as total_hours
    FROM 
        suivi_formations sf
    WHERE 
        sf.CIN = '$CIN' AND
        sf.matiere = '$matieres' AND
        sf.Niveau = '$Niveau' AND
        sf.mois='$mois' AND
        sf.N_Groupe = '$N_Groupe'";
    $total_hours_result = mysqli_query($conn, $total_hours_query);
    $total_hours_row = mysqli_fetch_assoc($total_hours_result);
    $total_hours = $total_hours_row['total_hours'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des séances</title>
    <style>
        body{
            font-weight:500;

        }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .form-container {
        margin: 20px 0;
    }

    .form-container input,
    .form-container button {
        margin: 5px;
    }

    .date {
        padding: 0 30px;
    }

    .opee {
        padding: 0 30px;
    }

    .left-align {
        text-align: left !important;
    }
    .link{
        font-weight: 500;
    }
    </style>
</head>
<body>
    <div class="d-flex justify-content-between m-5">
        <div>
            <a href="selectmonth.php?N_Groupe=<?php echo htmlspecialchars($N_Groupe, ENT_QUOTES) ?>&Niveau=<?php echo htmlspecialchars($Niveau, ENT_QUOTES) ?>&CIN=<?php echo htmlspecialchars($CIN, ENT_QUOTES) ?>&matieres=<?php echo htmlspecialchars(urlencode($_GET['matieres'])) ?>" class="link"><img src="back.svg" alt="Retour">Retour</a>
        </div>
        <a href="fiche_suivi.php?N_Groupe=<?php echo htmlspecialchars($N_Groupe, ENT_QUOTES) ?>&Niveau=<?php echo htmlspecialchars($Niveau, ENT_QUOTES) ?>&CIN=<?php echo htmlspecialchars($CIN, ENT_QUOTES) ?>&matieres=<?php echo htmlspecialchars(urlencode($_GET['matieres'])) ?>&mois=<?php echo htmlspecialchars($mois, ENT_QUOTES) ?>" class="float-right link">Fiche de Suivi</a>
    </div>
    <h2 class="m-4 text-center">Suivi des séances</h2>
    <form method="post" action="" class="form-inline d-flex flex-wrap justify-content-center mb-3 mt-5">
        <?php $currentDate = date('d/m/Y'); ?>
        <input type="hidden" name="CIN" value="<?php echo htmlspecialchars($_GET['CIN'], ENT_QUOTES); ?>">
        <input type="hidden" name="matieres" value="<?php echo htmlspecialchars($_GET['matieres'], ENT_QUOTES); ?>">
        <input type="hidden" name="Niveau" value="<?php echo htmlspecialchars($_GET['Niveau'], ENT_QUOTES); ?>">
        <input type="hidden" name="mois" value="<?php echo htmlspecialchars($_GET['mois'], ENT_QUOTES); ?>">
        <input type="hidden" name="N_Groupe" value="<?php echo htmlspecialchars($_GET['N_Groupe'], ENT_QUOTES); ?>">
        <div class="d-flex w-50 justify-content-center">
            <div class="form-group mx-sm-2 mb-2 col-12 col-md-3 p-0">
                <input type="text" class="form-control w-100" name="N_Seance" placeholder="N° DE SÉANCE">
            </div>
            <div class="form-group mx-sm-2 mb-2 col-12 col-md-3 p-0">
                <input type="date" class="form-control w-100" name="jours" id="jours" required>
                <input type="hidden" id="formattedDate" value="<?php echo $currentDate; ?>">
            </div>
            <div class="form-group mx-sm-2 mb-2 col-12 col-md-3 p-0">
                <input type="text" class="form-control w-100" name="horaire" placeholder="Horaire (ex: 09h - 11h)" value="09h - 11h" required>
            </div>
        </div>
        <div class="form-group col-10 mb-2">
            <input type="text" class="form-control w-100" name="titres_module" placeholder="Titres des leçons ou Modules" required>
        </div>
        <div class="form-group mx-sm-2 mb-2 col-12 col-md-2 mr-4">
            <input type="text" class="form-control" name="observations" placeholder="Observations">
        </div>
        <button type="submit" name="submit" class="btn btn-primary mb-2 col-12 col-md-2 ml-4">Ajouter une ligne</button>
    </form>

    <table id="scheduleTable" class="mb-5">
        <thead>
            <tr>
                <th>N° DE SÉANCE</th>
                <th class="date">Jours</th>
                <th class="date">Horaire</th>
                <th>Titres des leçons ou Modules</th>
                <th>Nombre d’heures</th>
                <th>Observations</th>
                <th class="opee">Opérations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($result) && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>";
                    echo str_pad($row['N° DE SEANCE'], 2, '0', STR_PAD_LEFT);
                    echo "</td>";
                    echo "<td>".$row['Jours']."</td>";
                    echo "<td>".$row['Horaire']."</td>";
                    echo "<td class='left-align'>".htmlspecialchars($row['Titres des leçons ou Modules'], ENT_QUOTES)."</td>";
                    echo "<td>".$row['Nombre d\'heures']."h</td>";
                    echo "<td>".htmlspecialchars($row['Observations'], ENT_QUOTES)."</td>";
                    echo "<td class=''>
                    <a href='modifiersuivi.php?ID_suivi=".htmlspecialchars($row['ID_suivi'], ENT_QUOTES)."&jours=".htmlspecialchars($row['Jours'], ENT_QUOTES)."&horaire=".htmlspecialchars($row['Horaire'], ENT_QUOTES)."&observations=".htmlspecialchars($row['Observations'], ENT_QUOTES)."&N_Groupe=".htmlspecialchars($N_Groupe, ENT_QUOTES)."&Niveau=".htmlspecialchars($Niveau, ENT_QUOTES)."&N_Seance=".htmlspecialchars($row['N° DE SEANCE'], ENT_QUOTES)."&matieres=".htmlspecialchars(urlencode($_GET['matieres']))."&CIN=".htmlspecialchars($row['CIN'], ENT_QUOTES)."&mois=".htmlspecialchars($row['mois'], ENT_QUOTES)."&N_heures=".htmlspecialchars($row['Nombre d\'heures'], ENT_QUOTES)."&titres_module=".htmlspecialchars($row['Titres des leçons ou Modules'], ENT_QUOTES)."' class='btn btn-success'>
                    <img class='text-center' src='imgs/edit.svg' alt='Modifier'></a>
                    <a href='supprimersuivi.php?ID_suivi=".htmlspecialchars($row['ID_suivi'], ENT_QUOTES)."&N_Groupe=".htmlspecialchars($N_Groupe, ENT_QUOTES)."&Niveau=".htmlspecialchars($Niveau, ENT_QUOTES)."&N_Seance=".htmlspecialchars($row['N° DE SEANCE'], ENT_QUOTES)."&matieres=".htmlspecialchars(urlencode($_GET['matieres']))."&CIN=".htmlspecialchars($row['CIN'], ENT_QUOTES)."&mois=".htmlspecialchars($row['mois'], ENT_QUOTES)."&N_heures=".htmlspecialchars($row['Nombre d\'heures'], ENT_QUOTES)."&titres_module=".htmlspecialchars($row['Titres des leçons ou Modules'], ENT_QUOTES)."' class='btn btn-danger mr-2' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet élément ?\")'>
                    <img class='text-center' src='imgs/delete.svg' alt='Supprimer'></a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Aucune séance trouvée.</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">TOTALE MENSUEL DES HEURES</td>
                <td><?php echo htmlspecialchars($total_hours ?? 0, ENT_QUOTES); ?>h</td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <script>
    function convertDateFormat(date) {
        const [dd, mm, yyyy] = date.split('/');
        return `${yyyy}-${mm}-${dd}`;
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const formattedDate = document.getElementById('formattedDate').value;
        const dateInput = document.getElementById('jours');
        dateInput.value = convertDateFormat(formattedDate);
    });

    document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("scheduleTable");
    var numRows = table.rows.length;

    // Check for the specific message row
    var messageRow = table.querySelector('tbody tr td[colspan="7"]');
    if (messageRow && messageRow.textContent.trim() === "Aucune séance trouvée.") {
        numRows -= 3; // Adjust for the message row, header, and footer
    } else {
        numRows -= 2; // Adjust for the header and footer rows
    }
    
    var seanceInput = document.querySelector('input[name="N_Seance"]');
    seanceInput.value = (numRows > 0) ? (numRows + 1) : 1;
});
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
