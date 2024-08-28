<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">


    <style>
    body,
    html {
        font-family: poppins, sans-serif;
    }
    .link{
        font-weight: 500;
text-decoration: none;
    }
    .link:hover{
        text-decoration: underline;
    }  
    </style>
</head>
<?php 
    include 'connection.php';

    $id = isset($_GET['id']) ? (int) $_GET['id'] : '';
    $N_Groupe= isset($_GET['N_Groupe']) ? (int) $_GET['N_Groupe'] : ''; 
    $Niveau= isset($_GET['Niveau']) ? (int) $_GET['Niveau'] : ''; 
    
    ?>

<body>
    <div class='m-5'>
        <a href="liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='link '><img src="back.svg"
                alt="">Retour</a>
    </div>
    <?php
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
        <form action="traitementupdateS.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="row">
            <div class="col-sm-6">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="Num_S" name="Num_S" value="<?php echo $row['Num_S']; ?>" required placeholder=''>
                <label for="Num_S" class=''>Numero du stagiaire</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $row['nom']; ?>"  placeholder=''>
                <label for="nom">Nom</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $row['prenom']; ?>"
                     placeholder=''>
                <label for="prenom">Prénom</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="CIN" name="CIN" value="<?php echo $row['CIN']; ?>" required placeholder=''>
                <label for="CIN" class=''>CIN</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="date_N" name="date_N" value="<?php echo $row['date_N']; ?>"
                     placeholder=''>
                <label for="date_N">Date de naissance</label>
            </div>
            </div>
            <div class="col-sm-6">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>"
                     placeholder=''>
                <label for="address">Adresse</label>
            </div>


            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $row['tel']; ?>"  placeholder=''>
                <label for="tel">Telephone</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="mail" name="email" value="<?php echo $row['email']; ?>"
                     placeholder=''>
                <label for="mail" class='form-label'>Email</label>
            </div>
            <div class="form-floating mb-3">
            <select class="form-select" id="groupe" name="groupe" required>
        <option value="">Sélectionner un groupe</option>
        <?php
            // Correction de la requête SQL pour obtenir le groupe sélectionné
            $sql3 = "SELECT N_Groupe FROM stagiaires_groupes WHERE id_stagiaire = $id AND Niveau = $Niveau";
            $result3 = mysqli_query($conn, $sql3);

            if (mysqli_num_rows($result3) == 1) {
                $row3 = mysqli_fetch_assoc($result3);
                $selectGroupe = $row3['N_Groupe'] ?? '';

                // Requête SQL pour obtenir tous les groupes
                $sql2 = "SELECT DISTINCT N_Groupe FROM groupes";
                $result2 = mysqli_query($conn, $sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $selected = ($row2['N_Groupe'] == $selectGroupe) ? "selected" : "";
                        echo "<option value='" . $row2['N_Groupe'] . "' " . $selected . ">" . $row2['N_Groupe'] . "</option>";
                    }
                }
            } else {
                echo "<p class='text-center alert alert-danger'>Aucun groupe trouvé pour ce stagiaire.</p>";
                exit();
            }
        ?>
    </select>
    <label for="groupe">Groupe</label>
</div>
            
            <button type="submit" class="btn btn-primary mr-3"><img src="save.svg" alt=""> Enregistrer les modification</button>
            <a href="liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='btn btn-secondary'><img src="cancel.svg"
            alt=""> Annuler</a>
            </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
