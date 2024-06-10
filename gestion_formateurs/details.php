<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du formateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Vos styles CSS personnalisés ici */
        body,
        html {
            font-family: poppins, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 30px;
        }

        .details-list {
            padding: 0;
        }

        .details-list li {
            margin-bottom: 10px;
        }

        .details-list label {
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="d-flex m-5">
            <a href="liste_formateurs.php" class="link"><img src="back.svg" alt="">Retour vers la liste</a>
        </div>
    <div class="container mt-3">
        <h1 class='text-center mb-4'>Détails du formateur</h1>
        <?php
        include 'get_formateur_data.php';
        if (isset($CIN)) {
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>CIN:</strong> ' . $CIN . '</li>';
            echo '<li class="list-group-item"><strong>Nom:</strong> ' . $nom . '</li>';
            echo '<li class="list-group-item"><strong>Sexe:</strong> ' . $sexe . '</li>';
            echo '<li class="list-group-item"><strong>Situation familiale:</strong> ' . $Situation_familiale . '</li>';
            echo '<li class="list-group-item"><strong>Téléphone:</strong> ' . $telephone . '</li>';
            echo '</ul>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>Email:</strong> ' . $email . '</li>';
            echo '<li class="list-group-item"><strong>Diplôme requis:</strong> ' . $diplome_re . '</li>';
            echo '<li class="list-group-item"><strong>Diplôme daccès:</strong> ' . $diplome_acces . '</li>';
            echo '<li class="list-group-item"><strong>Date de naissance:</strong> ' . $date_naissance . '</li>';
            echo '<li class="list-group-item"><strong>RIB:</strong> ' . $rib . '</li>';
            echo '<li class="list-group-item"><strong>Ville:</strong> ' . $ville . '</li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</body>

</html>
