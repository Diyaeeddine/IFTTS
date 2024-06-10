<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Stagiaire</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
                body,html{
            font-family:poppins,sans-serif;

        }
    </style>
</head>

<body>
    <?php 
    include 'connection.php';

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $sql = "SELECT * FROM stagiaires WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
    } else {
      echo "<p class='text-center alert alert-danger'>Aucun stagiaire trouvé avec cet ID.</p>";
      exit();
    }
  ?>
    <div class="container w-75 mt-3">
        <h2>Modifier un Stagiaire</h2>
        <form action="traitementupdateS.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $row['nom']; ?>" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="filiere">Filière:</label>
                <input type="text" class="form-control" id="filiere" name="filiere"
                    value="<?php echo $row['filiere']; ?>" required>
            </div>
            <div class="form-group">
    <label for="groupe">Groupe:</label>
    <select class="form-control" id="groupe" name="groupe" required>
        <option value="">Sélectionner un groupe</option>
        <?php
        $selectGroupe = $row['N_Groupe'];
        $sql2 = "SELECT DISTINCT N_Groupe FROM groupes";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {

            while ($row2 = $result->fetch_assoc()) {
                $selected = ($row2['N_Groupe'] == $selectGroupe) ? "selected" : "";
                echo "<option value='" . $row2['N_Groupe'] . "' " . $selected . ">" . $row2['N_Groupe'] . "</option>";
            }
        }
        ?>
    </select>
</div>

            <button type="submit" class="btn btn-primary mr-3">Modifier</button><a href="liste_stagiaires.php" class='btn btn-secondary'>Retour vers la liste</a>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>