<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des stagiaires</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        font-family: poppins, sans-serif;

    }
    </style>
</head>

<body>
    <?php         
    include 'connection.php';
?>
    <div class="m-5 d-flex">
        <a href="liste_groupe.php" class='link'><img src="back.svg" alt="">Retour vers la liste des groupes</a>
    </div>
    <div class="container">
        <h2 class="text-center mb-4 mt-3">Liste des stagiaires</h2>
        <a href="ajouter_stagiaire.php" class='btn btn-success mb-5'>Ajouter Un stagiaire</a>

        <?php

            $sql = "SELECT * FROM stagiaires ORDER BY nom, prenom ASC";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<table class="table text-center">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Nom</th>';
                echo '<th scope="col">Prénom</th>';
                echo '<th scope="col">filiere</th>';
                echo '<th scope="col">Numero du groupe</th>';
                echo '<th scope="col">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'. $row["nom"]. '</td>';
                    echo '<td>'. $row["prenom"]. '</td>';
                    echo '<td>'. $row["filiere"]. '</td>';
                    echo '<td>'. $row["N_Groupe"]. '</td>';
                    echo "<td class='d-flex justify-content-around'><a href='edit_stagiaire.php?id=". $row['id'] ."' class='btn btn-warning'><img class='text-center' src='../gestion_suivi_formation/imgs/edit.svg' alt='Modifier'></a>";
                    echo "<a href='delete_stagiaire.php?id=". $row['id'] ."' onclick=\"return confirm('Êtes-vous sûr de supprimer le stagiaire " . $row['nom'] ." ". $row['prenom'] . " ?')\" class='btn btn-danger'><img class='text-center' src='../gestion_suivi_formation/imgs/delete.svg' alt='Supprimer'> </a>";
                    echo "<a href='details_stagiaire.php?id=". $row['id'] ."' class='btn btn-secondary'><img class='text-center' src='../gestion_formateurs/info.svg' alt='Details'></a>";
                    echo "</td>";
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p class='text-center'>Aucun stagiaire trouvé pour ce groupe.</p>";
            }
            mysqli_close($conn);
        
        ?>

    </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>