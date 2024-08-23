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
    body{
        margin: 0;
        padding: 0;
    }

    td{
        font-weight: 500;
        font-size: 17px;
    }
.png{
    width:22px;
    height:22px;
    filter:brightness(0) invert(1);
}

    </style>
</head>

<body>
    <?php         
    include 'connection.php';
    if(isset($_GET['N_Groupe']) && isset($_GET['Niveau']) ){
        $N_Groupe= $_GET['N_Groupe'];
        $Niveau= $_GET['Niveau'];
?>
    <div class="d-flex align-items-center m-5 justify-content-between">
        <div><a href="./select_niveau.php?N_Groupe=<?php echo $N_Groupe ?>" class='link'><img src="back.svg" alt="">Retour</a></div>
       <div><a href="ajouter_stagiaire.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='btn btn-success '><img src="./person_add.svg" alt="">Ajouter Un stagiaire</a></div>
    </div>
    <div class="container">
    <h2 class="text-center mb-4 mt-3">Liste des stagiaires Groupe <?php echo $N_Groupe; ?> - <?php echo ($Niveau === '1') ? '1ère année' : '2ème année'; ?></h2>

<div class='d-flex justify-content-between'>

    <a href="list_details.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class="btn btn-primary mb-4 print">
  <div class="text-center">
    <img class="vertical-align-middle" src="list.svg" alt="">
    Liste détaillé
  </div>
</a>
<div>
<a href="classement.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='btn btn-success'><img src="./sort.svg" alt="" class='png'> Classement</a>
</div>
</div>
<?php
      $sql="SELECT s.Num_S, s.id, s.CIN, s.nom, s.prenom, s.date_N, s.address, s.tel, s.email
        FROM stagiaires s
        JOIN stagiaires_groupes sg ON s.id = sg.id_stagiaire
        WHERE sg.N_Groupe = $N_Groupe AND sg.Niveau=$Niveau ORDER BY s.nom asc";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th scope="col">Num Stagiaire</th>';
                echo '<th scope="col">Nom</th>';

                echo '<th scope="col">Prénom</th>';
                echo '<th scope="col">CIN</th>';
                echo '<th scope="col" class="text-center">Opérations</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class=""> '. $row["Num_S"]. '</td>';
                    echo '<td class=""> '. $row["nom"]. '</td>';
                    echo '<td class="">'. $row["prenom"]. '</td>';
                    echo '<td class=""> '. $row["CIN"]. '</td>';
                    echo "<td class='d-flex justify-content-around '><abbr title='Modifier'><a href='edit_stagiaire.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=". $row['id'] ."' class='btn btn-warning'><img class='text-center' src='../gestion_suivi_formation/imgs/edit.svg' alt='Modifier'></a></abbr>";
                    echo "<abbr title='Supprimer'><a href='delete_stagiaire.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=". $row['id'] ."&CIN=".$row['CIN']."' onclick=\"return confirm('Êtes-vous sûr de supprimer le stagiaire " . $row['nom'] ." ". $row['prenom'] . " ?')\" class='btn btn-danger'><img class='text-center' src='../gestion_suivi_formation/imgs/delete.svg' alt='Supprimer'> </a></abbr>";
                    echo "<abbr title='Résultats'><a href='resultats.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=". $row['id'] ."&Num_S=".$row['Num_S']."' class='btn btn-primary'><img class='text-center' src='./note1.svg' alt='resultats'></a></abbr>";
                    echo "<abbr title='Détails'><a href='details_stagiaire.php?N_Groupe=".$N_Groupe."&Niveau=".$Niveau."&id=". $row['id'] ."' class='btn btn-secondary'><img class='text-center' src='../gestion_formateurs/info.svg' alt='Details'></a></abbr>";
                    echo "</td>";
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p class='text-center'>Aucun stagiaire trouvé pour ce groupe.</p>";
            }
            mysqli_close($conn);
}
        ?>

    </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>