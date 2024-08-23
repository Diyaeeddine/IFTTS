<!DOCTYPE html>
<html lang="fr">
<?php
include 'get_formateur_data.php';

if (isset($_GET['CIN']) ) {
    $CIN = $_GET['CIN'];
    // Requête pour obtenir les données actuelles du formateur
    $sql = "SELECT * FROM formateurs WHERE CIN='$CIN'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $sexe = $row['sexe'];
        $Situation_familiale = $row['Situation_familiale'];
        $ville = $row['ville'];
        $telephone = $row['telephone'];
        $email = $row['email'];
        $grade = $row['grade'];
        $diplome_re = $row['diplome_re'];
        $diplome_accees = $row['diplome_accees'];
        $date_naissance = $row['date_naissance'];
        $rib = $row['rib'];
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le formateur <?php echo $prenom;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .link{
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
            transition: color 0.3s ease;
        }
        .link:hover{
            color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class='m-5'><a href="liste_formateurs.php" class='link p-3'><img src="back.svg" alt="">Retour vers la liste</a></div>
    <div class="container-sm w-75">
        <div>
            <h2 class="mt-5 text-bold">Modifier le formateur <?php echo $prenom ?> </h2>
        </div>
        
        <form action="Update_formateur.php" method="POST">
            <div class="row">
                <div class="col-sm-6">
                    <input type="hidden" name="oldCIN" value="<?php echo $CIN; ?>">
                    <div class="mb-3 form-floating">
                        <input type="text" id="CIN" name="CIN" class="form-control" value="<?php echo $CIN ?>" placeholder="" required>
                        <label for="CIN" class="form-label">CIN</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="nom" name="nom" class="form-control" placeholder=" " value="<?php echo $nom ?>" >
                        <label for="nom" class="form-label">Nom</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder=" " value="<?php echo $prenom ?>" >
                        <label for="prenom" class="form-label">Prénom</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="sexe" id="sexe" class="form-select">
                            <?php
                            $optionsSexe = array("H", "F");
                            foreach ($optionsSexe as $option) {
                                $selected = ($option == $sexe) ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                        <label for="sexe" class="form-label">Sexe</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="Situation_familiale" id="Situation_familiale" class="form-select">
                            <?php
                            $optionsSituationFamiliale = array("célibataire", "marié", "divorcé", "veuf");
                            foreach ($optionsSituationFamiliale as $option) {
                                $selected = ($option == $Situation_familiale) ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                        <label for="Situation_familiale" class="form-label">Situation familiale</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="ville" name="ville" class="form-control" placeholder=" " value="<?php echo $ville ?>" >
                        <label for="ville" class="form-label">Ville</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="tel" id="telephone" name="telephone" class="form-control" placeholder=" " value="<?php echo $telephone ?>" >
                        <label for="telephone" class="form-label">Téléphone</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3 form-floating">
                        <input type="email" id="email" name="email" class="form-control" placeholder=" " value="<?php echo $email ?>" >
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="grade" name="grade" class="form-control" placeholder=" " value="<?php echo $grade ?>" >
                        <label for="grade" class="form-label">Grade</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="diplome_re" name="diplome_re" class="form-control" placeholder=" " value="<?php echo $diplome_re ?>" >
                        <label for="diplome_re" class="form-label">Diplôme Re</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="diplome_acces" name="diplome_accees" class="form-control" placeholder=" " value="<?php echo $diplome_accees ?>" >
                        <label for="diplome_acces" class="form-label">Diplôme d'accès</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="<?php echo $date_naissance ?>" >
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="rib" name="rib" class="form-control" placeholder=" " value="<?php echo $rib ?>" >
                        <label for="rib" class="form-label">RIB</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100 p-2 mb-5 fs-5">Appliquer les modifications</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php 
} elseif (!isset($_GET['CIN']) || $_GET['CIN'] == '') {
    echo "Aucun identifiant de formateur n'a été fourni.";
} 
?>
