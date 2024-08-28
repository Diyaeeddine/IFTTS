<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un groupe</title>
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        font-family: poppins, sans-serif;

    }
    .retour{
        text-decoration: none;
    }
    .retour:hover{
        text-decoration: underline;

    }
    </style>
</head>

<body>
    <div class='m-5'>
        <a href="liste_groupe.php" class='link m-5 retour'><img src="back.svg" alt="">Retour vers la liste</a>
    </div>
    <div class='container w-50 text-center'>
        <h2 class='m-5'>Ajouter un groupe</h2>
        <form action="traitement.php" method="post">
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="mb-3 form-floating">
                        <input type="number" id="N_Groupe" name="N_Groupe" class="form-control" placeholder='' required>
                        <label for="N_Groupe" class="form-label" autocomplete="off">Sélectionner le numéro de
                            groupe</label>
                    </div>

                    <div class="mb-3 form-floating">
                        <select id="promotion" name="promotion" class='form-select' required>
                            <?php
                    $startYear = 2022;
                    $endYear = 2038;
                    
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        $nextYear = $year + 2;
                        echo "<option value='{$year}-{$nextYear}'>{$year}-{$nextYear}</option>";
                    }
                    ?>
                        </select>
                        <label for="promotion" class="form-label">Sélectionner la promotion</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="filiere" name="filiere" class="form-control" placeholder='' required>
                        <label for="filiere" class="form-label">Taper la filière</label>
                    </div>
                </div>
            </div>
            <button type='submit' class='btn btn-success float-start me-3' style='color:white'><img src="group_add.svg" alt=""> Ajouter</button>
        </form>
    </div>
</body>

</html>