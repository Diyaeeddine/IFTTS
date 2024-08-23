<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            font-family: Poppins, sans-serif;
        }
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }
        
    .link{
        text-decoration: none;
    }
    .link:hover{
        text-decoration: underline;

    }
    </style>
</head>
<body>
    <?php
    include 'connection.php';
    if (isset($_GET['N_Groupe'])) {
        $N_Groupe = $_GET['N_Groupe'];
        $Niveau = $_GET['Niveau'];
        $msg = $_GET['msg'] ?? '';
        if ($msg === 'success') {
            echo '<div id="successMessage" class="alert alert-success" role="alert">
                    Stagiaire ajouté avec succès.
                  </div>';
        } elseif ($msg) {
            echo '<div id="errorMessage" class="alert alert-danger" role="alert">
                    ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '
                  </div>';
        }
    ?>
        <div class='m-5 d-flex'>
            <a href="liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class="link">
                <img src="back.svg" alt="">Retour à la liste
            </a>
        </div>

        <div class="container w-75 mt-5">
            <h2 class="text-center mb-4">Ajouter un stagiaire</h2>
            <form action="traitement_ajout_stagiaire.php?N_Groupe=<?php echo $N_Groupe ?>" method="post">
                <div class="row">
                    <input type="hidden" name="Niveau" value="1">
                    <div class="col-sm-6">
                    <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="Num_S" name="Num_S" required placeholder=''>
                            <label for="Num_S">Numéro du stagiaire</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nom" name="nom"  placeholder=''>
                            <label for="nom">Nom</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="prenom" name="prenom"  placeholder=''>
                            <label for="prenom">Prénom</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="CIN" name="CIN" required placeholder=''>
                            <label for="CIN">CIN</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_N" name="date_N"  placeholder=''>
                            <label for="date_N">Date de naissance</label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="address" name="address"  placeholder=''>
                            <label for="address">Adresse</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="tel" name="tel"  placeholder=''>
                            <label for="tel">Téléphone</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="mail" name="email"  placeholder=''>
                            <label for="mail">Email</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="groupe" name="groupe" required placeholder=''>
                                <option value="">Sélectionner un groupe</option>
                                <?php

                                $selectGroupe = isset($N_Groupe) ? $N_Groupe : '';


                                $sql2 = "SELECT DISTINCT N_Groupe FROM groupes";
                                $result = $conn->query($sql2);

                                if ($result->num_rows > 0) {
                                    while ($row2 = $result->fetch_assoc()) {

                                        $selected = ($row2['N_Groupe'] == $selectGroupe) ? "selected" : "";
                                        echo "<option value='" . $row2['N_Groupe'] . "' " . $selected . ">Groupe " . $row2['N_Groupe'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label for="groupe">Groupe</label>
                        </div>

                        <div class='w-100 d-flex justify-content-evenly'>
                            <button type="submit" class="btn btn-primary w-50">
                                <img src="add.svg" alt=""> Ajouter
                            </button>
                            <a href="liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class="btn btn-secondary w-25 p-2 no-wrap">
                                <img src="cancel.svg" alt=""> Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.classList.add('fade-out');
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 300);
            }
        }, 10000);

        setTimeout(function() {
            var errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.classList.add('fade-out');
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 300);
            }
        }, 10000);
    </script>
</body>
</html>
