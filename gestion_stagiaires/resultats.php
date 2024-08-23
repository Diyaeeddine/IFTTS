<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmes et Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            font-family: Poppins, "Helvetica Neue", Helvetica, Arial;
        }
        .con {
            width: 85%;
            margin: auto;
        }
        .froma, .frota {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        .froma td, .frota th, .frota td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        .froma td {
            background-color: #f2f2f2;
        }
        .frota th {
            background-color: #323539;
            color: white;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .table td {
            vertical-align: middle;
        }
        .table td a {
            color: #007bff;
            text-decoration: none;
        }
        .table td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    include 'connection.php';

    $Num_S = isset($_GET['Num_S']) ? (int) $_GET['Num_S'] : "NULL";
    $N_Groupe = isset($_GET['N_Groupe']) ? (int) $_GET['N_Groupe'] : "NULL";
    $Niveau = isset($_GET['Niveau']) ? (int) $_GET['Niveau'] : "NULL";
    $id = isset($_GET['id']) ? (int) $_GET['id'] : "NULL";

    $query_sum = "
        SELECT 
            SUM(r.avg * pf.coefficient) / SUM(pf.coefficient) AS overall_avg
        FROM 
            programme_formation pf
        LEFT JOIN 
            resultats r ON pf.matieres = r.matiere 
            AND r.Num_S = '$Num_S' 
            AND r.N_Groupe = '$N_Groupe'
            AND r.Niveau = '$Niveau'
        WHERE 
            r.avg IS NOT NULL
            AND (pf.niveau = '$Niveau' 
            OR pf.niveau = 3 
            OR pf.niveau = 4)";
    
    $result_sum = mysqli_query($conn, $query_sum);
    
    if ($result_sum && mysqli_num_rows($result_sum) > 0) {
        $row_sum = mysqli_fetch_assoc($result_sum);
        $overall_avg = $row_sum['overall_avg'] ? round($row_sum['overall_avg'], 2) : 'NULL';
        
        $searchsql = "SELECT * FROM pv_notes WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        $result = mysqli_query($conn, $searchsql);
        
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE pv_notes SET moyenne=$overall_avg WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
        } else {
            $sql = "INSERT INTO pv_notes (id_S, Num_S, moyenne, Niveau, N_Groupe) VALUES ($id, $Num_S, $overall_avg, '$Niveau', '$N_Groupe')";
        }
        mysqli_query($conn, $sql);
    }
    ?>

<?php 

$queryU = "UPDATE pv_notes p
JOIN (
    SELECT id, ROW_NUMBER() OVER (ORDER BY moyenne DESC) AS r
    FROM pv_notes
    WHERE Niveau = '$Niveau' AND N_Groupe = '$N_Groupe'
) as subquery ON p.id = subquery.id
SET p.ranking = subquery.r
WHERE p.Niveau = '$Niveau' AND p.N_Groupe = '$N_Groupe'";

$conn->query($queryU);


?>
    
    <div class="d-flex align-items-center m-5 justify-content-between">
        <div>
            <a href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='back-link'>
                <img src="back.svg" alt=""> Retour
            </a>
        </div>
        <div>
            <a href="relevenote.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>&id=<?php echo $id ?>&Num_S=<?php echo $Num_S ?>" class='btn btn-success'>
                <img src="./table_chart.svg" alt=""> Relevés de notes
            </a>
        </div>
    </div>

    <div class='con'>
        <table class='table table-bordered froma'>
            <tr>
                <td>Nom et prénom du stagiaire</td>
                <th>
                    <?php 
                        $sqlS = "SELECT * FROM stagiaires WHERE id=$id";
                        $resultS = mysqli_query($conn, $sqlS);
                        $rowS = mysqli_fetch_assoc($resultS);
                        echo htmlspecialchars($rowS['nom']) . " " . htmlspecialchars($rowS['prenom']);
                    ?>
                </th>
            </tr>
            <tr>
                <td>Numéro du stagiaire</td>
                <th><?php echo htmlspecialchars($rowS['Num_S']); ?></th>
            </tr>
        </table>

        <table class='table table-bordered mt-4 frota'>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Note 1</th>
                    <th>Note 2</th>
                    <th>Note 3</th>
                    <th>La moyenne</th>
                  
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT pf.matieres, r.note1, r.note2, r.note3, r.avg
                          FROM programme_formation pf
                          LEFT JOIN resultats r ON pf.matieres = r.matiere 
                          AND r.Num_S = '$Num_S' 
                          AND r.N_Groupe = '$N_Groupe'
                          AND r.Niveau = '$Niveau'
                          WHERE pf.niveau = '$Niveau' 
                          OR pf.niveau = 3 
                          OR pf.niveau = 4 
                          ORDER BY
                           
                    CASE 
                        WHEN pf.matieres LIKE 'D%' THEN 1 ELSE 0 
                    END, CAST(SUBSTRING(pf.matieres, 3, LENGTH(pf.matieres) - 2) AS UNSIGNED)";
                $result = mysqli_query($conn, $query);
      
                while ($row = mysqli_fetch_assoc($result)) {
                    $matiere = $row['matieres'];
                    $note1 = isset($row['note1']) ? $row['note1'] : '';
                    $note2 = isset($row['note2']) ? $row['note2'] : '';
                    $note3 = isset($row['note3']) ? $row['note3'] : '';
                    $avg = isset($row['avg']) ? $row['avg'] : '';


                    echo "<tr>
                            <td style='text-align:left;'><a href='grades.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=".$id."&Num_S=".$Num_S."&matiere=" . urlencode($matiere) . "'>" . htmlspecialchars($matiere) . "</a></td>
                            <td>" . htmlspecialchars($note1) . "</td>
                            <td>" . htmlspecialchars($note2) . "</td>
                            <td>" . htmlspecialchars($note3) . "</td>
                            <td>" . htmlspecialchars($avg) . "</td>
                          
                          </tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
