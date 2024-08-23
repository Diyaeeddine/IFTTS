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
            margin-bottom: 20px;
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

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        #grp4o {
            width: 22px;
            height: 22px;
        }

        button {
            margin-bottom: 10px;
        }
        .link {
        text-decoration: none;
    }
    .ppp{
      margin: 0;
    }

    .link:hover {
        text-decoration: underline;
    }
        @media print {
            .container {
                max-width: 600px;
            }

            .print,
            h2,
            .link {
                display: none;
            }

            body {
                font-size: 14px;
            }
            .container {
            box-shadow: 0 0 0 0;

        }
        }
    </style>
</head>

<body>
<div class="d-flex m-5 rep justify-content-between align-items-center">
    <a href="liste_formateurs.php" class="link"><img src="back.svg" alt="">Retour vers la liste</a>
    <button onclick="window.print()" class="btn btn-primary print ppp">
        <img class='text-center' src='../gestion_suivi_formation/imgs/print.svg' alt=''> Imprimer
    </button>
</div>


    <div class="container mt-3">
        <h2 class="text-center mb-4">Détails du formateur</h2>
        <?php
        include 'get_formateur_data.php';
        if (isset($CIN)) {
            $buttonText = empty($image_src) ? "<img src='upload.svg'>Telecharger une image" : "<img src='refresh.png' id='grp4o'> Changer l'image";
            echo '<div class="image-container">';
            if (!empty($image_src)) {
                echo '<img src="' . $image_src . '" alt="" class="image">';
            }
            echo '</div>';

            echo '<form id="uploadForm" action="upload_image.php" method="post" enctype="multipart/form-data" class="d-inline">';
            echo '<input type="file" name="image_src" id="image_src" class="d-none" accept="image/*" onchange="document.getElementById(\'uploadForm\').submit();">';
            echo '<input type="hidden" name="CIN" value="' . $CIN . '">';
            echo '<center><button type="button" class="btn btn-primary print" onclick="document.getElementById(\'image_src\').click();">' . $buttonText . '</button></center>';
            echo '</form>';

            // Ajouter le bouton de suppression d'image si l'image existe
            if (!empty($image_src)) {
                echo '<form id="deleteImageForm" action="delete_image.php" method="post" class="d-inline">';
                echo '<input type="hidden" name="CIN" value="' . $CIN . '">';
                echo '<input type="hidden" name="image_src" value="' . $image_src . '">';
                echo '<center><button type="submit" class="btn btn-danger print"><img src="delete.svg">Supprimer l\'image</button></center>';
                echo '</form>';
            }

            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>CIN:</strong> ' . $CIN . '</li>';
            echo '<li class="list-group-item"><strong>Nom:</strong> ' . $nom . '</li>';
            echo '<li class="list-group-item"><strong>Prénom:</strong> ' . $prenom . '</li>';
            echo '<li class="list-group-item"><strong>Sexe:</strong> ' . $sexe . '</li>';
            echo '<li class="list-group-item"><strong>Situation familiale:</strong> ' . $Situation_familiale . '</li>';
            echo '<li class="list-group-item"><strong>Téléphone:</strong> ' . $telephone . '</li>';
            echo '</ul>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>Email:</strong> ' . $email . '</li>';
            echo '<li class="list-group-item"><strong>Diplôme requis:</strong> ' . $diplome_re . '</li>';
            echo '<li class="list-group-item"><strong>Diplôme d\'accès:</strong> ' . $diplome_acces . '</li>';
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
