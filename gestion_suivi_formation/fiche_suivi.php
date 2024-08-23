<?php 
include 'connection.php';

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

if (isset($_GET['CIN']) && isset($_GET['matieres']) && isset($_GET['Niveau']) && isset($_GET['N_Groupe']) && isset($_GET['mois'])) {
    $CIN = mysqli_real_escape_string($conn, $_GET['CIN']);
    $matieres = mysqli_real_escape_string($conn, $_GET['matieres']);
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
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche de Suivi</title>
    <style>
    body {
        font-size: 13px;
    }

    .footer {
        text-align: center;
        display: flex;
        justify-content: space-evenly;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .date {
        padding: 0 30px;
    }

    .ncea {
        padding: 0;
    }

    table {
        width: 95%;
        border-collapse: collapse;
    }

    .Tetablissement {
        margin-bottom: 20px;
    }

    .Tetablissement td {
        text-align: left;
        color: #333;
        padding: 3px;
        border: 1px solid #ccc;
    }

    th,
    td {
        border: 1px solid black;
        padding: 16px 5px;
        text-align: center;
    }

    .txt {
        text-align: center;
        display: flex;
        margin-left: 10px;
        margin-top: 15px;
        font-size: 12px;
        font-weight: bold;
    }
.txt{
    display: none;
}
    @media print {
        .print {
            display: none;
        }
        .txt{
            display: block;
        }
    }
    </style>
</head>

<body>

    <?php
    $sqlpromotion = "SELECT promotion FROM groupes WHERE N_Groupe=$N_Groupe";
    $resultpromotion = mysqli_query($conn, $sqlpromotion);
    $rowpromotion = mysqli_fetch_assoc($resultpromotion);
    $promotion = $rowpromotion['promotion'];

    $sqlgroupe = "SELECT * FROM groupes WHERE N_Groupe=$N_Groupe";
    $resultgroupe = mysqli_query($conn, $sqlgroupe);
    $rowgroupe = mysqli_fetch_assoc($resultgroupe);
    $filieregroupe = $rowgroupe['filiere'];

    $sqlformateur = "SELECT * FROM formateurs WHERE CIN='$CIN'";
    $resultformateur = mysqli_query($conn, $sqlformateur);
    $rowformateur = mysqli_fetch_assoc($resultformateur);
    $nomformateur = $rowformateur['nom'];
    $prenomformateur = $rowformateur['prenom'];
    $gradeformateur = $rowformateur['grade'];
    ?>
    <div class="d-flex justify-content-between m-5">
        <div class="txt">
            <p class='p'>ROYAUME DU MAROC <br>
                MINISTERE DE L'INTERIEUR <br>
                DIRECTION GENERALE DES COLLECTIVITES TERRITORIALES <br>
                DIRECTION DU DEVELOPPEMENT DES COMPETENCES <br>
                ET DE LA TRANSFORMATION DIGITALE <br>
                INSTITUT DE FORMATION DES <br>
                TECHNICIENS ET TECHNICIENS SPECIALISES AL HOCEIMA</p>
        </div>
        <div>
            <a href="table_suivi.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>&CIN=<?php echo $CIN ?>&matieres=<?php echo htmlspecialchars(urlencode($_GET['matieres'])) ?>&mois=<?php echo $mois ?>"
                class="link print " style='font-size:17px'><img src="back.svg" alt="Retour">Retour</a>
        </div>
    </div>
    <div class="content">
        <h2 class='m-4 text-center'>Fiche de Suivi</h2>
        <button onclick="window.print()" class="btn btn-primary mb-4 print"><img class='text-center'
                src='imgs/print.svg' alt=''> Imprimer</button>
        <table class='Tetablissement'>
            <tr>
                <td style='text-align:right'>Établissement :</td>
                <td colspan="3"><b>IFTTS-AL-HOCEIMA</b></td>
            </tr>
            <tr>
                <td style='text-align:right'>Cycle de formation :</td>
                <td colspan="3"><b>Techniciens spécialisés en <?php echo htmlspecialchars($filieregroupe, ENT_QUOTES); ?>
                        (<?php echo htmlspecialchars($promotion, ENT_QUOTES); ?>)</b></td>
            </tr>
            <tr>
                <td style='text-align:right'>Mois :</td>
                <td colspan="3"><b><?php echo htmlspecialchars($mois, ENT_QUOTES); ?> <?php echo date("Y"); ?></b></td>
            </tr>
        </table>

        <table class='Tetablissement'>
            <tr>
                <td style='text-align:right'>Nom & Prénom :</td>
                <td colspan="3"><b><?php echo htmlspecialchars($nomformateur . " " . $prenomformateur, ENT_QUOTES); ?></b></td>
            </tr>
            <tr>
                <td style='text-align:right'>CIN N° :</td>
                <td colspan="3"><b><?php echo htmlspecialchars($CIN, ENT_QUOTES); ?></b></td>
            </tr>
            <tr>
                <td style='text-align:right'>Grade :</td>
                <td colspan="3"><b><?php echo htmlspecialchars($gradeformateur, ENT_QUOTES); ?></b></td>
            </tr>
            <tr>
                <td style='text-align:right'>Qualité :</td>
                <td><b>
                        <div class="form-check ml-1">
                            <input class="form-check-input " type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Vacataire
                            </label>
                        </div>
                    </b></td>
                <td colspan="2"><b>
                        <div class="form-check ml-1">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked">
                                Permanent
                            </label>
                        </div>
                    </b></td>
            </tr>
            <tr>
                <td style='text-align:right'>Matières ou Modules :</td>
                <td colspan="3"><b><?php echo $_GET['matieres'] ?></b></td>
            </tr>
        </table>

        <table id="scheduleTable">
            <thead>
                <tr>
                    <th class='ncea'>N° DE SÉANCE</th>
                    <th class='date'>Jours</th>
                    <th class='date'>Horaire</th>
                    <th>Titres des leçons ou Modules</th>
                    <th>Nombre d’heures</th>
                    <th>Observations</th>
                </tr>
            </thead>
            <tbody>
                <?php
        if (isset($result) && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>";
                if ($row['N° DE SEANCE'] < 10) {
                    echo '0' . $row['N° DE SEANCE'];
                } else {
                    echo $row['N° DE SEANCE'];
                }
                echo "</td>";
                echo "<td>" . htmlspecialchars($row['Jours'], ENT_QUOTES) . "</td>";
                echo "<td>" . htmlspecialchars($row['Horaire'], ENT_QUOTES) . "</td>";
                echo "<td style='text-align:start'><b>" . $row['Titres des leçons ou Modules'] . "</b></td>";
                echo "<td><b>" . htmlspecialchars($row['Nombre d\'heures'], ENT_QUOTES) . "h</b></td>";
                echo "<td><b>" . htmlspecialchars($row['Observations'], ENT_QUOTES) . "</b></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucune séance trouvée.</td></tr>";
        }
        ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="font-weight:bold">TOTALE MENSUEL DES HEURES</td>
                    <td id="totalHours" style="font-weight:bold">0h</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <footer class='footer'>
        <div>Vérifiée par</div>
        <div>Signée et approuvée par le <br><b>Directeur de l'établissement</b></div>
        <div>L'intéressée</div>
    </footer>

    <script>
    function calculateHours(horaire) {
        var timeParts = horaire.split(' - ');
        var startTime = timeParts[0];
        var endTime = timeParts[1];

        var startHours = parseInt(startTime.split('h')[0]);
        var startMinutes = parseInt(startTime.split('h')[1]) || 0;
        var endHours = parseInt(endTime.split('h')[0]);
        var endMinutes = parseInt(endTime.split('h')[1]) || 0;

        var startDate = new Date(0, 0, 0, startHours, startMinutes, 0);
        var endDate = new Date(0, 0, 0, endHours, endMinutes, 0);
        var diff = endDate - startDate;
        var hours = diff / 1000 / 60 / 60;
        return hours;
    }

    function updateTotalHours() {
        var table = document.getElementById("scheduleTable");
        var totalHours = 0;
        for (var i = 1; i < table.rows.length - 1; i++) {
            var hoursText = table.rows[i].cells[4].innerText;
            var hours = parseFloat(hoursText) || 0;
            totalHours += hours;
        }
        document.getElementById("totalHours").innerText = totalHours + 'h';
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateTotalHours();
    });
    document.addEventListener("DOMContentLoaded", function() {
        var table = document.getElementById("scheduleTable");
        var numRows = table.rows.length - 2;
        var seanceInput = document.querySelector('input[name="N_Seance"]');
        seanceInput.value = (numRows + 1);
    });

    function convertDateFormat(date) {
        const [dd, mm, yyyy] = date.split('/');
        return `${yyyy}-${mm}-${dd}`;
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const formattedDate = document.getElementById('formattedDate').value;
        const dateInput = document.getElementById('jours');
        dateInput.value = convertDateFormat(formattedDate);
    });
    </script>

</body>

</html>
