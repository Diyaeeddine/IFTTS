<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un groupe</title>
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
    body,
    html {
        font-family: poppins, sans-serif;

    }
    .retour{
        text-decoration: none;
        font-weight: 500;
    }
    .retour:hover{
        text-decoration: underline;

    }
    </style>
</head>

<body>
<div class='m-5'>
        <a href="./liste_groupe.php" class='link retour'><img src="back.svg" alt="">Retour</a>
    </div>
    <?php
include 'connection.php';

session_start();

$N_Groupe = isset($_GET['N_Groupe']) ? $_GET['N_Groupe'] : 0;
$filiere = isset($_GET['filiere']) ? $_GET['filiere'] : 0;
$promotion = isset($_GET['promotion']) ? $_GET['promotion'] : 0;
$sql = "SELECT * FROM groupes WHERE N_Groupe=$N_Groupe and promotion = '$promotion' and filiere='$filiere'" ;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result);

    $_SESSION['N_Groupe'] = $N_Groupe;
    $_SESSION['filiere'] = $filiere;
    $_SESSION['promotion'] = $promotion;
} else {
    echo "<p class='text-center alert alert-danger'>Aucun stagiaire trouvé avec cet ID.</p>";
    exit();
}
?>

    <div class='container w-50 text-center'>
        <h2 class='m-5'>Modifier un groupe</h2>
        <form action="editTraitementG.php" method="post">
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="mb-3 form-floating">
                        <input type="number" id="N_Groupe" name="New_N_Groupe" class="form-control" placeholder=''
                            value="<?php echo $row['N_Groupe']; ?>">
                        <label for="New_N_Groupe" class="form-label" autocomplete="off">Sélectionner le numéro de
                            groupe</label>
                    </div>

                    <div class="mb-3 form-floating">
                <select id="promotion" name="New_promotion" class='form-select' placeholder=''>
                    <?php
                    $startYear = 2022;
                    $endYear = 2040;
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        $nextYear = $year + 2;
                        $promotionValue = "{$year}-{$nextYear}";
                        $selected = ($row['promotion'] == $promotionValue) ? 'selected' : '';
                        echo "<option value='{$promotionValue}' {$selected}>{$promotionValue}</option>";
                    }
                    ?>
                </select>
                <label for="New_promotion" class="form-label">Sélectionner la promotion</label>
            </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="filiere" name="New_filiere" class="form-control" placeholder=''
                            value="<?php echo $row['filiere'] ?>">
                        <label for="New_filiere" class="form-label">Sélectionner la filière</label>
                    </div>
                </div>
            </div>
            <button type="submit" class='btn btn-success float-start me-3'>Enregistrer les modifications</button><a
                href="liste_groupe.php" class='btn btn-secondary float-start'>Annuler vers la liste</a>
        </form>
    </div>
</body>

</html>