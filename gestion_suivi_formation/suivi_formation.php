<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    * {
        font-family: poppins, sans-serif;
        font-weight: 500;
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
            // Message de succès
            echo '<div id="alert-msg" class="alert alert-success alert-dismissible fade show" role="alert">';
        } else {
            // Message d'erreur
            echo '<div id="alert-msg" class="alert alert-danger alert-dismissible fade show" role="alert">';
        }
        echo htmlspecialchars($_SESSION['msg']);
        echo '</div>';
        echo '</div>';
        unset($_SESSION['msg']);  
    }

    if (isset($_GET['N_Groupe']) && isset($_GET['Niveau'])){
        $N_Groupe = $_GET['N_Groupe'];
        $Niveau = $_GET['Niveau'];
        $sql = "SELECT 
                f.CIN AS CIN, 
                f.nom AS nom_formateur, 
                f.prenom AS prenom_formateur, 
                pg.matieres AS matiere_enseignee
            FROM 
                programme_groupes pg
                JOIN formateurs f ON pg.CIN_formateur = f.CIN
            WHERE 
                pg.N_Groupe = $N_Groupe AND pg.Niveau = $Niveau 
            ORDER BY pg.matieres ASC";
    ?>
    <div class='m-5'>
        <a href="groupe_niveau.php?N_Groupe=<?php echo $N_Groupe ?>" class='link'><img src="back.svg"
                alt="Retour">Retour</a>
    </div>
    <div class="container ">

    <form action='ajouter_formation.php' method='POST' class="form-inline flex-wrap">
    <input type="hidden" name='N_Groupe' value='<?php echo $N_Groupe ?>'>
    <input type="hidden" name='Niveau' value='<?php echo $Niveau ?>'>
    <div class="form-group mx-2" style="max-width: 600px;">
        <label for="matiere" class="mr-2">Matière:</label>
        <select name="matiere" id="matiere" class="form-control w-100">
            <?php 
                $sql_matiere = "SELECT matieres, CAST(SUBSTRING(matieres, 3, LENGTH(matieres) - 2) AS UNSIGNED) AS uf_number 
                                FROM programme_formation 
                                WHERE niveau=$Niveau or niveau=3
                                ORDER BY uf_number ASC, date_creation ASC";
                $result_matiere = mysqli_query($conn, $sql_matiere);
                if ($result_matiere && $result_matiere->num_rows > 0) {
                    while ($row = $result_matiere->fetch_assoc()) {
                        echo "<option value='". htmlspecialchars($row['matieres'], ENT_QUOTES) ."'>". htmlspecialchars($row['matieres'], ENT_QUOTES) ."</option>";
                    }
                } else {
                    echo "<option value=''>No results</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group mx-2" style="max-width: 300px;">
        <label for="CIN" class="mr-2">Formateur:</label>
        <select name="CIN" id="CIN" class="form-control w-100">
            <?php 
                $sql_formateur = "SELECT * FROM formateurs";
                $result_formateur = mysqli_query($conn, $sql_formateur);
                if ($result_formateur && $result_formateur->num_rows > 0) {
                    while ($row = $result_formateur->fetch_assoc()) {
                        echo "<option value='". $row['CIN']. "'>". $row['nom']. " ". $row['prenom']. "</option>";
                    }
                } else {
                    echo "<option value=''>No results</option>";
                }
            ?>
        </select>
    </div>
    <div class='form-group mx-2'>
    <button type="submit" class="btn btn-success d-inline-block">Ajouter</button>
</div>

</form>


    </div>
    <?php
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="container">';
            echo '<table class="table table-bordered mt-5">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">Matières Enseignées</th>';
            echo '<th scope="col">Formateur</th>';
            echo '<th scope="col p-0 m-0">Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['matiere_enseignee'] . '</td>';
                echo '<td>' . $row['nom_formateur'] . ' ' . $row['prenom_formateur'] . '</td>';
                echo '<td class="text-center">';
echo '<div class="d-flex justify-content-around">';
echo '<a href="supprimerelation.php?N_Groupe=' . $N_Groupe . '&Niveau=' . $Niveau . '&CIN=' . $row["CIN"] . '&matiere=' . urlencode($row['matiere_enseignee']) . '" onclick="return confirm(\'Êtes-vous sûr de supprimer l\\\'élément ?\')" class="btn btn-danger mx-1"><img src="../gestion_suivi_formation/imgs/delete.svg" alt="Supprimer"></a>';
echo '<a href="selectmonth.php?N_Groupe=' . $N_Groupe . '&Niveau=' . $Niveau . '&CIN=' . $row["CIN"] . '&matieres=' . htmlspecialchars(urlencode($row['matiere_enseignee'])) . '" class="btn btn-primary mx-1">Suivi</a>';
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
    // Faire disparaître l'alerte après 3 secondes
    $(document).ready(function() {
        setTimeout(function() {
            $('#alert-msg').alert('close');
        }, 6000);
    });
    </script>
</body>

</html>