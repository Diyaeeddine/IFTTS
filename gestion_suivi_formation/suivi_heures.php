<!DOCTYPE html>
<?php include 'connection.php' ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .text-center {
            text-align: center;
        }
        .table-bordered {
            border: 2px solid #dee2e6;
        }
        .w-100 {
            width: 100%;
        }
        .aretour {
          
            font-family: Poppins;
        }
        th, td {
            text-align: center;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['N_Groupe']) && isset($_GET['Niveau'])) {
        $N_Groupe = htmlspecialchars($_GET['N_Groupe'], ENT_QUOTES);
        $Niveau = htmlspecialchars($_GET['Niveau'], ENT_QUOTES);
    ?>
    <div class='d-flex'>
        <a href="suivi_formation.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='link d-flex m-5 aretour'>
            <img src="back.svg" alt="">Retour
        </a>
    </div>
    <div class="container">
        <table class="text-center mb-5">
            <thead>
                <tr>
                    <th scope="col">Nom de la matière</th>
                    <th scope="col">Volume horaire de la matière en <?php echo ($Niveau == 1) ? "1ère année" : "2ème année"; ?></th>
                    <th scope="col">Nombre d'heures réalisées</th>
                    <th scope="col">Nombre d'heures restantes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $matieresQuery = "SELECT * FROM programme_formation WHERE (niveau = ? OR niveau = 3) ORDER BY CAST(SUBSTRING_INDEX(matieres, 'UF', -1) AS UNSIGNED), matieres";
                if ($stmtMatieres = $conn->prepare($matieresQuery)) {
                    $stmtMatieres->bind_param("i", $Niveau);
                    $stmtMatieres->execute();
                    $resultmatieres = $stmtMatieres->get_result();
                    while ($rowmatieres = $resultmatieres->fetch_assoc()) {
                        $v_nRealise = 0;
                        $n_realise = "SELECT SUM(N_heures) AS total_heures FROM suivi_formations WHERE (Niveau = ? OR Niveau = 3) AND N_Groupe = ? AND matiere = ?";
                        if ($stmtRealise = $conn->prepare($n_realise)) {
                            $stmtRealise->bind_param("iis", $Niveau, $N_Groupe, $rowmatieres['matieres']);
                            $stmtRealise->execute();
                            $resultn_realise = $stmtRealise->get_result();
                            if ($rown_realise = $resultn_realise->fetch_assoc()) {
                                $v_nRealise = $rown_realise['total_heures'] ?? 0;
                            } else {
                                echo "Échec de la requête : " . mysqli_error($conn);
                            }
                            $stmtRealise->close();
                        }
                        $totalHeures = ($Niveau == 1) ? $rowmatieres['VH_1ere'] : $rowmatieres['VH_2eme'];
                        $heuresRestantes = $totalHeures - $v_nRealise;
                ?>
                        <tr class='border-solid'>
                            <td class='text-left'><?php echo $rowmatieres['matieres']; ?></td>
                            <td><?php echo $totalHeures . 'h'; ?></td>
                            <td><?php echo $v_nRealise . 'h'; ?></td>
                            <td><?php echo $heuresRestantes . 'h'; ?></td>
                        </tr>
                <?php
                    }
                    $stmtMatieres->close();
                } else {
                    echo "Échec de la requête : " . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    } else {
        echo 'Veuillez revenir en arrière et sélectionner le mois. Merci !';
    }
    ?>
    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
