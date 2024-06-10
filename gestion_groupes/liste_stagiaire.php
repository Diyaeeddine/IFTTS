<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des groupes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>
<body>
  <table>
    <tr>
      <th>Nom</th>
      <th>Prenom</th>
    </tr>
<?php
include 'connection.php';
if(isset($_GET['N_Groupe'])){
$N_Groupe= $_GET['N_Groupe'];
  $sql="SELECT nom, prenom FROM stagiaires WHERE N_Groupe=$N_Groupe";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {

        echo '<tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td></tr>';

      }

    }

}
?>
</table>
</body>

</html>
