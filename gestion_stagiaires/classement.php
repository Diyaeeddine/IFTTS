<?php
include 'connection.php';

$N_Groupe = $_GET['N_Groupe'];
$Niveau = $_GET['Niveau'];

// Query to get the student results
$query = "
    SELECT 
        s.nom, s.prenom, p.moyenne, p.ranking,
        GROUP_CONCAT(CONCAT_WS('=', pf.matieres, r.avg) SEPARATOR ';') AS subject_scores
    FROM stagiaires s
    JOIN pv_notes p ON s.id = p.id_S
    LEFT JOIN programme_formation pf ON pf.niveau IN ('$Niveau', '3', '4')
    LEFT JOIN resultats r ON r.id_S = s.id AND r.matiere = pf.matieres AND r.Niveau = '$Niveau' AND r.N_Groupe = '$N_Groupe'
    WHERE p.Niveau = '$Niveau' AND p.N_Groupe = '$N_Groupe'
    GROUP BY s.nom, s.prenom, p.moyenne, p.ranking
    ORDER BY p.ranking ASC;
";

// Execute the query
$result = $conn->query($query);
$queryU = "UPDATE pv_notes p
JOIN (
    SELECT id, ROW_NUMBER() OVER (ORDER BY moyenne DESC) AS r
    FROM pv_notes
    WHERE Niveau = '$Niveau' AND N_Groupe = '$N_Groupe'
) as subquery ON p.id = subquery.id
SET p.ranking = subquery.r
WHERE p.Niveau = '$Niveau' AND p.N_Groupe = '$N_Groupe'";

$conn->query($queryU);

// Fetching the subjects for the header
$matiereQuery = "SELECT matieres FROM programme_formation WHERE niveau IN ('$Niveau', '3', '4') ORDER BY
    CASE 
        WHEN matieres LIKE 'D%' THEN 1 ELSE 0 
    END, CAST(SUBSTRING(matieres, 3, LENGTH(matieres) - 2) AS UNSIGNED)";
$matiereResult = $conn->query($matiereQuery);
$matieres = [];

while ($matiereRow = $matiereResult->fetch_assoc()) {
    $fullMatiere = $matiereRow['matieres'];

    // Generate the abbreviated version for display
    $parts = explode(':', $fullMatiere, 2);
    $ufPart = trim($parts[0]);
    $secondPart = isset($parts[1]) ? trim($parts[1]) : '';
    $cleanedSecondPart = preg_replace('/\s*\([^)]*\)/', '', $secondPart);
    $cleanedSecondPart = trim(str_replace(',', '', $cleanedSecondPart));
    
    $firstLetters = implode('', array_map(function($word) {
        return !empty($word) ? strtoupper($word[0]) : '';
    }, explode(' ', $cleanedSecondPart)));
    
    // Combine UF part and first letters of the second part
    $displayValue = $ufPart . ' ' . $firstLetters;

    // Store both the full and abbreviated versions
    $matieres[$fullMatiere] = $displayValue;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des stagiaires</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
        body {
            font-family: poppins, Arial, sans-serif;
            font-size: .7em;
            margin: 0;
            padding: 0;
        }
        .cont{
            padding: 0 20px;

        }

        table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        #goi {
            color: #007bff;
            transition: .3s;
            text-decoration: none;
        }

        #goi:hover {
            color: #0058b6;
            text-decoration: underline;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 7px;
        }

        th {
            background-color: #f2f2f2;
        }

        .ranking {
            text-align: left;
        }

        .heit {
            margin: 3em;
            font-size: 16px;
        }

        .print {
            background-color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 0;
            color: white;
            padding: 10px 20px;
            margin: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: .3s;
            font-size: 16px;
        }
        .link{
        font-weight: 500;

        }

        .up {
            text-align: center;
        }

        @media print {
            @page {
                size: landscape;
            }

            th, td {
                border: 1px solid black;
                text-align: center;
                padding: 5px;
            }

            .print, .heit {
                display: none;
            }

            .up {
                margin: 30px 0;
            }
        }
    </style>
</head>
<body>
<div style="" class='heit'>
        <a style="" id="goi"
            href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='link'>
            <img src="back.svg" alt="">Retour
        </a>
    </div>
<div class="cont">
    <div class="up">
        <?php
        $sqlf = "select * from groupes where N_Groupe='$N_Groupe'";
        $resultf = $conn->query($sqlf);
        $rowf = $resultf->fetch_assoc();
        $filiere = $rowf['filiere'];
        ?>
        <h3> <?php echo ucfirst($filiere) ?> - Groupe <?php echo $N_Groupe; ?> -
            <?php echo ($Niveau === '1') ? '1ère année' : '2ème année'; ?></h3>
    </div>
    <div style="display:flex; justify-content:center;">
        <button onclick="window.print()" class="btn btn-primary mb-4 print afterPrint">
            <img class="text-center" src="../gestion_suivi_formation/imgs/print.svg" alt=""> Imprimer
        </button>
    </div>

    <table>
        <tr>
            <th class="ranking">Classement</th>
            <th>Nom</th>
            <th>Prénom</th>
            <?php
            foreach ($matieres as $fullMatiere => $displayValue) {
                echo "<th data-fullname='" . htmlspecialchars($fullMatiere) . "'>" . htmlspecialchars($displayValue) . "</th>";
            }
            ?>
            <th>Moyenne</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='ranking'>" . ($row['ranking'] == 1 ? 'Première' : ($row['ranking'] == 2 ? 'Deuxième' : ($row['ranking'] == 3 ? 'Troisième' : $row['ranking']))) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prenom']) . "</td>"; 
            
            $subjectScores = [];
            if (!empty($row['subject_scores'])) {
                $subjectPairs = explode(';', $row['subject_scores']);
                foreach ($subjectPairs as $pair) {
                    $pairParts = explode('=', $pair);
                    if (count($pairParts) === 2) {
                        list($subject, $score) = $pairParts;
                        $subjectScores[$subject] = $score;
                    }
                }
            }

            foreach ($matieres as $fullMatiere => $displayValue) {
                $avgScore = isset($subjectScores[$fullMatiere]) ? $subjectScores[$fullMatiere] : '';
                echo "<td>" . (is_numeric($avgScore) ? round($avgScore, 2) : '') . "</td>";
            }

            echo "<td>" . (is_numeric($row['moyenne']) ? number_format($row['moyenne'], 2) : '') . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
