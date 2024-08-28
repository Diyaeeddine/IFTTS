<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des groupes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
th{
  text-align: center;
}
    </style>
</head>
<body>
<div class='m-5'>
        <a href="../gestion_groupes/liste_groupe.php" class='link '><img src="back.svg" alt="">Retour</a>
    </div>
    <div class="container">
<?php
include 'connection.php';
if(isset($_GET['N_Groupe'])){
$N_Groupe= $_GET['N_Groupe'];
  $sql="SELECT * FROM stagiaires WHERE N_Groupe=$N_Groupe";
  $result = $conn->query($sql);
  if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-bordered ">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col" class="">Nom</th>';
    echo '<th scope="col">Prénom</th>';
    echo '<th scope="col">filiere</th>';
    echo '<th scope="col">Operations</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'. $row["nom"]. '</td>';
        echo '<td>'. $row["prenom"]. '</td>';
        echo '<td>'. $row["filiere"]. '</td>';

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


}
?>
</div>
</body>

</html>
