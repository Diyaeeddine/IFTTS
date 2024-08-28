<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
        * {
            font-family: poppins, sans-serif;
            font-weight: 500;
        }
        #mat-ens {
            max-width: 600px;
        }
        .formaj {
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.align-self-end {
    align-self: flex-end;
}

.table th.mar, .table td.mar {

    max-width:85px;
}

    </style>
</head>

<body>

    <?php
    include 'connection.php';

    if (isset($_GET['msg'])) {
        $_SESSION['msg'] = $_GET['msg'];
    }

    if (isset($_SESSION['msg'])) {
        echo '<div class="container mt-3">';
        if (strpos($_SESSION['msg'], "succès") !== false) {
            echo '<div id="alert-msg" class="alert alert-success alert-dismissible fade show" role="alert">';
        } else {
            echo '<div id="alert-msg" class="alert alert-danger alert-dismissible fade show" role="alert">';
        }
        echo htmlspecialchars($_SESSION['msg']);
        echo '</div>';
        echo '</div>';
        unset($_SESSION['msg']);
    }

    if (isset($_GET['N_Groupe']) && isset($_GET['Niveau'])) {
        $N_Groupe = $_GET['N_Groupe'];
        $Niveau = $_GET['Niveau'];

        // Préparer les données des matières
        $stmtMatieres = $conn->prepare("SELECT * FROM programme_formation WHERE (niveau = ? OR niveau = 3) ORDER BY CAST(SUBSTRING_INDEX(matieres, 'UF', -1) AS UNSIGNED), matieres");
        $stmtMatieres->bind_param("i", $Niveau);
        $stmtMatieres->execute();
        $resultMatieres = $stmtMatieres->get_result();
        $matieresData = [];
        while ($rowMatieres = $resultMatieres->fetch_assoc()) {
            $matieresData[] = $rowMatieres;
        }

        // Préparer les données des formateurs
        $stmt = $conn->prepare("SELECT f.CIN AS CIN, f.nom AS nom_formateur, f.prenom AS prenom_formateur, pg.matieres AS matiere_enseignee
                                FROM programme_groupes pg
                                JOIN formateurs f ON pg.CIN_formateur = f.CIN
                                WHERE pg.N_Groupe = ? AND pg.Niveau = ?
                                ORDER BY CAST(SUBSTRING_INDEX(matieres, 'UF', -1) AS UNSIGNED), matieres");
        $stmt->bind_param("ii", $N_Groupe, $Niveau);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>
        <div class='m-5 d-flex justify-content-between'>
            <a href="groupe_niveau.php?N_Groupe=<?php echo $N_Groupe ?>" class='link'><img src="back.svg" alt="Retour">Retour</a>
            <a href="suivi_heures.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class="btn btn-primary">Suivi des heures des matières</a>
        </div>
        <div class="formaj">
    <form action='ajouter_formation.php' method='POST' class="form-inline flex-wrap">
        <input type="hidden" name='N_Groupe' value='<?php echo $N_Groupe ?>'>
        <input type="hidden" name='Niveau' value='<?php echo $Niveau ?>'>
        <div class="form-group mx-2" style="max-width: 600px;">
            <label for="matiere" class="mr-2">Matière:</label>
            <select name="matiere" id="matiere" class="form-control w-100">
                <?php
                foreach ($matieresData as $matiere) {
                    echo "<option value='" . htmlspecialchars($matiere['matieres'], ENT_QUOTES) . "'>" . htmlspecialchars($matiere['matieres'], ENT_QUOTES) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mx-2" style="max-width: 300px;">
            <label for="CIN" class="mr-2">Formateur:</label>
            <select name="CIN" id="CIN" class="form-control w-100">
                <?php
                $stmt_formateur = $conn->prepare("SELECT * FROM formateurs");
                $stmt_formateur->execute();
                $result_formateur = $stmt_formateur->get_result();

                if ($result_formateur->num_rows > 0) {
                    while ($row = $result_formateur->fetch_assoc()) {
                        echo "<option value='" . $row['CIN'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No results</option>";
                }
                ?>
            </select>
        </div>
        <div class='form-group mx-2 align-self-end'>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </div>
    </form>
</div>

        <?php
        if ($result->num_rows > 0) {
            echo '<div class="" style="margin:0 10px;">';
            echo '<table class="table table-bordered mt-5">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">Matières Enseignées</th>';
            echo '<th scope="col" class="mar">V Horaire</th>';
            echo '<th scope="col" class="mar">H réalisées</th>';
            echo '<th scope="col" class="mar">H restantes</th>';
            echo '<th scope="col">Formateur</th>';
            echo '<th scope="col">opérations</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                $v_nRealise = 0;
                $stmtRealise = $conn->prepare("SELECT SUM(N_heures) AS total_heures FROM suivi_formations WHERE (Niveau = ? OR Niveau = 3) AND N_Groupe = ? AND matiere = ? ");
                $stmtRealise->bind_param("iis", $Niveau, $N_Groupe, $row['matiere_enseignee']);
                $stmtRealise->execute();
                $resultn_realise = $stmtRealise->get_result();

                if ($rown_realise = $resultn_realise->fetch_assoc()) {
                    $v_nRealise = $rown_realise['total_heures'] ?? 0;
                } else {
                    echo "Échec de la requête : " . $conn->error;
                }
                $stmtRealise->close();

                $totalHeures = 0;
                foreach ($matieresData as $matiere) {
                    if ($matiere['matieres'] == $row['matiere_enseignee']) {
                        if ($Niveau == 1 && isset($matiere['VH_1ere'])) {
                            $totalHeures = $matiere['VH_1ere'];
                        } elseif ($Niveau == 2 && isset($matiere['VH_2eme'])) {
                            $totalHeures = $matiere['VH_2eme'];
                        }
                        break;
                    }
                }

                $heuresRestantes = $totalHeures - $v_nRealise;

                echo '<tr>';
                echo '<td id="mat-ens">' . htmlspecialchars($row['matiere_enseignee'], ENT_QUOTES) . '</td>';
                echo '<td id="mat-ens" class="text-center mar">' . $totalHeures .  '</td>';
                echo '<td id="mat-ens" class="text-center mar">'. $v_nRealise . '</td>';
                echo '<td id="mat-ens" class="text-center mar">' . $heuresRestantes . '</td>';
                echo '<td>' . htmlspecialchars($row['nom_formateur'], ENT_QUOTES) . ' ' . htmlspecialchars($row['prenom_formateur'], ENT_QUOTES) . '</td>';
                echo '<td class="text-center">';
                echo '<div class="d-flex justify-content-around">';
                echo '<a href="supprimerelation.php?N_Groupe=' . $N_Groupe . '&Niveau=' . $Niveau . '&CIN=' . htmlspecialchars($row["CIN"], ENT_QUOTES) . '&matiere=' . urlencode($row['matiere_enseignee']) . '" onclick="return confirm(\'Êtes-vous sûr de supprimer l\\\'élément ?\')" class="btn btn-danger mx-1"><img src="../gestion_suivi_formation/imgs/delete.svg" alt="Supprimer"></a>';
                echo '<a href="selectmonth.php?N_Groupe=' . $N_Groupe . '&Niveau=' . $Niveau . '&CIN=' . htmlspecialchars($row["CIN"], ENT_QUOTES) . '&matieres=' . urlencode($row['matiere_enseignee']) . '" class="btn btn-primary mx-1">Suivi</a>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "<h5 class='text-center mt-5'>Aucun formateur trouvé pour ce niveau.</h5>";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alert-msg').alert('close');
            }, 6000);
        });
    </script>
</body>

</html>
