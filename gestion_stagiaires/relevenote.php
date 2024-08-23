        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Bulletin de 1ère Année</title>
            <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->


            <style>
            body {
                font-family: poppins, Arial, sans-serif;
                font-size: 12px;
                margin: 0px;
                padding: 0;

            }

            .header,
            .footer {
                text-align: center;
                margin-bottom: 7px;
            }

            .header {
                line-height: 3.5px;
                font-weight: 500;
            }

            .title {
                font-size: 2em;
                text-align: center;
                background-color: #e4d6cb;
            }

            .title p {
                margin: 10px 0 6px 0;
            }

            .info-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 7px;
            }


            .info-table th,
            .info-table td {
                border: 3px solid black;
                padding: 4px;
                text-align: left;
            }

            .coef-column th {
                margin:0 auto;
            }

            .grades-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 7px;
            }

            .grades-table th,
            .grades-table td {
                border: 3px solid black;
                padding: 8px;
                text-align: center;
            }



            .grades-table td {
                text-align: left;
                padding: 4px;

            }

            .grades-table .coef-column {
                border-right: none;
                text-align: center;
                padding: 4px 10px;
                font-weight: bold;

            }
            .note-column{
                max-width: 20px;
                min-width: 20px;
                
                /* padding:8px 10px; */
            }

            .grades-table .note-column {
                border: 3px solid black;
                padding: 4px 30px;
                font-weight: bold;
                text-align: center;

            }


            .summary th,
            .summary td {
                /* border: 3px solid black; */
                padding: 4px;
                text-align: left;
            }


            .summary td {
                text-align: center;


            }

            .logoiftts {
                margin-top: 20px;
                width: 100px;
                height: 100px;
            }

            .container {
                width: 80%;
                margin: 0 auto 20px auto;

            }

            .bor1 {
                border-bottom: 2px solid;
                border-right: 2px solid;
            }

            .bor2 {
                border-bottom: 2px solid;
                border-left: 2px solid;
            }

            .bor3 {
                border-top: 2px solid;
                border-right: 2px solid;
            }

            .bor4 {
                border-top: 2px solid;
                border-left: 2px solid;
            }

            .hola {
                display: flex;
                justify-content: space-evenly;
                flex-direction: row;
                width: 100%;
            }

            .summary {
                width: 100%;
                border-collapse: collapse;
                border: 3px solid;
            }

            .moye {
                width: 45%;
                margin-top: 0;
                padding-top: 0;
            }

            .appre {
                border: 3px solid black;
                width: 45%;
                padding: 0px 0px 0 5px;
                text-decoration: underline;
                font-weight: 600;
            }

            .tab {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 2px;
            }
            .lala{
                padding: 0;
            }

            .tab th,
            .tab td {
                border: 2px solid black;
                padding: 4px;
                text-align: left;
            }
            .dflex{
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 3.5em;


            }
            .back-link{
                display: flex;
                font-size:1.3em;
                align-items:center;
                color:#007bff;
                text-decoration: none;
            }
            .btnp{
                background-color: #007bff;
                font-weight:500;
                border-radius: 5px;
                color: white;
                border:0;
                padding: 10px 20px;
                display: flex;
                align-items:center; 
                font-size:1.2em;
                font-family:poppins,sans-serif;
                cursor: pointer;
                transition:.3s;
            }
            
            .btnp:hover {
                    background-color: #0069d9;
                }
            
            @media print {
                .dflex {
                    display: none;
                }

            }
            </style>
        </head>

        <body>
            <?php
            include 'connection.php';
            $Num_S = isset($_GET['Num_S']) ? (int) $_GET['Num_S'] : 0;
            $N_Groupe = isset($_GET['N_Groupe']) ? (int) $_GET['N_Groupe'] : 0;
            $Niveau = isset($_GET['Niveau']) ? (int) $_GET['Niveau'] : 0;
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $matiere = isset($_GET['matiere']) ? mysqli_real_escape_string($conn, $_GET['matiere']) : '';
            $sqlcin="SELECT * FROM stagiaires WHERE id = $id or Num_S=$Num_S";
            $resultcin = mysqli_query($conn, $sqlcin);
            $rowcin = mysqli_fetch_assoc($resultcin);
            $CIN = $rowcin['CIN'];
            $nom = $rowcin['nom'];
            $prenom = $rowcin['prenom'];
            $sqlP="SELECT distinct promotion FROM groupes WHERE N_Groupe=$N_Groupe";
            $resultP = mysqli_query($conn, $sqlP);
            $rowP = mysqli_fetch_assoc($resultP);
            $promotion = $rowP['promotion'];
            $promotion_years = explode('-', $promotion);
            $start_year = (int)$promotion_years[0];
            if ($Niveau == 1) {
                $training_year = $start_year . '/' . ($start_year + 1);
            } elseif ($Niveau == 2) {
                $training_year = ($start_year + 1) . '/' . ($start_year + 2);
            }


            ?>

            <div >
                <div class="dflex">
                    <a href="./resultats.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>&id=<?php echo $id ?>&Num_S=<?php echo $Num_S ?>"
                        class='back-link'>
                        <img src="back.svg" alt="">Retour
                    </a>
                    <div>
                <button onclick='window.print()' class='btnp'><img src="../gestion_vacations/print.svg" alt="">&nbspImprimer</button>
            </div>
                </div>
                
            </div>
            <div class="header">
                <img src="./logo.svg" alt="" class='logoiftts'>
                <p>Royaume du Maroc</p>
                <p>Ministère de l'Intérieur</p>
                <p>Direction Générale des Collectivités Territoriale</p>
                <p>Direction du Développement des compétences et de la Transformation Digitale</p>
                <p>INSTITUT DE FORMATION DES TECHNICIENS ET TECHNICIENNES SPÉCIALISÉS D'AL HOCEIMA</p>
            </div>
            <div class='container'>
            <div class="title">
                    <p>BULLETIN DE <?php 
        if (htmlspecialchars($Niveau) == 1) {
            echo htmlspecialchars($Niveau) . "<sup>ère</sup> année";
        } elseif (htmlspecialchars($Niveau) == 2) {
            echo htmlspecialchars($Niveau) . "<sup>ème</sup> année";
        }?></p>
                </div>
                <table class='tab'>
                    <tr>
                        <td style='text-align:center;'>CYCLE DE FORMATION :</td>
                        <th colspan="3" style='text-align:center;'>TECHNICIENS SPÉCIALISÉS EN FINANCE LOCALES (<?php echo $promotion  ?>)
                        </th>
                    </tr>
                </table>
                <table class="info-table">
                    <tr>
                        <td colspan="1">GROUPE</td>
                        <th colspan="1" style='text-align:center;'>FL 0<?php echo $N_Groupe ?></th>
                    </tr>
                    <tr>
                        <td colspan="2">NOM ET PRÉNOM</td>
                        <th style='text-align:center;'><?php echo $prenom.' '.$nom ?></th>
                        <td>N° CIN</td>
                        <th style='text-align:center;'><?php echo $CIN ?></th>
                    </tr>
                    <tr>
                        <td colspan="2">ANNÉE DE FORMATION</td>
                        <th style='text-align:center;'><?php echo $training_year; ?></th>
                        <td>N° Ins</td>
                        <th colspan="2" style='text-align:center;'><?php echo $Num_S ?></th>
                    </tr>
                </table>


                <table class="grades-table">
                    <tr>
                        <th>UNITÉS DE FORMATION (UF)</th>
                        <th class="coef-column lala" >Coef</th>
                        <th class="note-column lala">Note</th>
                    </tr>
                    <?php
                        
                        $query = "SELECT pf.matieres, r.note1, r.note2, r.note3, r.avg, pf.coefficient as coef
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
                    END,
                    CAST(SUBSTRING(pf.matieres, 3, LENGTH(pf.matieres) - 2) AS UNSIGNED);";
                                $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $matiere = $row['matieres'];
                            $avg = isset($row['avg']) ? $row['avg'] : '';

                            echo "<tr>
                                    <td style='text-align:left;'>" . htmlspecialchars($matiere) . "</td>
                                    <td class='coef-column'>".$row["coef"]."</td>
                                    <td class='note-column'>" . htmlspecialchars($avg) . "</td>
                                </tr>";
                        }
                        mysqli_close($conn);
                    ?>
                </table>
                <div class='hola'>
                    <div class='appre'>

                        <p>Appréciations Générales</p>

                    </div>
                    <div class='moye'>
                        <table class="summary">
                            <tr>
                            <?php 
include 'connection.php';

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

// Check if the query was successful
if ($result_sum && mysqli_num_rows($result_sum) > 0) {
    $row_sum = mysqli_fetch_assoc($result_sum);
    $overall_avg = $row_sum['overall_avg'] ? round($row_sum['overall_avg'], 2) : 'NULL';
    
    $searchsql = "SELECT * FROM pv_notes WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";

    $result = mysqli_query($conn, $searchsql);
    $row_R = mysqli_fetch_assoc($result);
    $ranking = $row_R['ranking'] ? $row_R['ranking'] : '';

    


    
    if (mysqli_num_rows($result) > 0) {
        // Update existing record
        $sql = "UPDATE pv_notes SET moyenne=$overall_avg WHERE id_S=$id AND Num_S=$Num_S AND N_Groupe='$N_Groupe' AND Niveau='$Niveau'";
    } else {
        // Insert new record
        $sql = "INSERT INTO pv_notes (id_S, Num_S, moyenne, Niveau, N_Groupe) VALUES ($id, $Num_S, $overall_avg, '$Niveau', '$N_Groupe')";
    }
    
    
} else {
    echo "No data available or query failed.";
}

// Close the connection

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

                                <td class='bor1'>Moyenne générale</td>
                                <th style='text-align:center; padding:4px 12px;' class='bor2'>    <?php 
    if ($overall_avg !== 'NULL') {
     
        if (is_numeric($overall_avg) && intval($overall_avg) == $overall_avg) {
            echo number_format($overall_avg, 2); 
        } else {
            echo round($overall_avg, 2); 
        }
    } else {
        echo ''; 
    }
    ?></th>
                            </tr>
                            <tr>
                                <td class='bor3'>Classement</td>
                                <th style='text-align:center; padding:4px 12px;' class='bor4'>
    <?php 
        if ($ranking == 1) {
            echo "Première";
        } elseif ($ranking == 2) {
            echo "Deuxième";
        } elseif ($ranking == 3) {
            echo "Troisième";
        } else {
            echo $ranking;
        }
    ?>
</th>

                            </tr>
                        </table>
                        <div class="footer">
                            <p>Directrice de l'institut</p>
                        </div>
                    </div>
                </div>

            </div>
        </body>

        </html>
        