<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
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

    .link {
        text-decoration: none;
        font-weight: 500;

    }

    .link:hover {
        text-decoration: underline;
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
    .ppp{
      margin: 0;
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
<?php
        include 'connection.php';
        if (isset($_GET['id']) && isset($_GET['N_Groupe']) && isset($_GET['Niveau'])) {
          $id = $_GET['id'];
          $N_Groupe = $_GET['N_Groupe'];
          $Niveau = $_GET['Niveau'];

?>

<body>
    <div class="d-flex m-5 d-flex justify-content-between align-items-center">
        <a href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class="link "><img
                src="back.svg" alt="">Retour vers la liste</a>
        <button onclick="window.print()" class="btn btn-primary print ppp "><img class='text-center'
                src='../gestion_suivi_formation/imgs/print.svg' alt=''> Imprimer</button>
    </div>

    <div class="container mt-3">
        <h2 class="text-center mb-4">Détails du stagiaire</h2>
        <?php

            // Fetch stagiaire details
            $query = "SELECT * FROM stagiaires WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // Extract data
            $CIN = $row['CIN'];
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
            $date_N = $row['date_N'];
            $address = $row['address'];
            $tel = $row['tel'];
            $image_src = $row['image_src'];

            // Display the data
            $buttonText = empty($image_src) ? "<img src='../gestion_formateurs/upload.svg'>Télécharger une image" : "<img src='../gestion_formateurs/refresh.png' id='grp4o'> Changer l'image";
            
            echo '<div class="image-container">';
            if (!empty($image_src)) {
                echo '<img src="' . $image_src . '" alt="" class="image">';
            }
            echo '</div>';

            echo '<form id="uploadForm" action="upload_image.php" method="post" enctype="multipart/form-data" class="d-inline">';
            echo '<input type="file" name="image_src" id="image_src" class="d-none" accept="image/*" onchange="document.getElementById(\'uploadForm\').submit();">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="N_Groupe" value="' . $N_Groupe . '">';
            echo '<input type="hidden" name="Niveau" value="' . $Niveau . '">';
            echo '<center><button type="button" class="btn btn-primary print" onclick="document.getElementById(\'image_src\').click();">' . $buttonText . '</button></center>';
            echo '</form>';

            if (!empty($image_src)) {
                echo '<form id="deleteImageForm" action="delete_image.php" method="post" class="d-inline">';
                echo '<input type="hidden" name="id" value="' . $id . '">';
                echo '<input type="hidden" name="N_Groupe" value="' . $N_Groupe . '">';
                echo '<input type="hidden" name="Niveau" value="' . $Niveau . '">';
                echo '<input type="hidden" name="image_src" value="' . $image_src . '">';
                echo '<center><button type="submit" class="btn btn-danger print"><img src="../gestion_formateurs/delete.svg">Supprimer l\'image</button></center>';
                echo '</form>';
            }

            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>ID:</strong> ' . $id . '</li>';
            echo '<li class="list-group-item"><strong>CIN:</strong> ' . $CIN . '</li>';
            echo '<li class="list-group-item"><strong>Nom:</strong> ' . $nom . '</li>';
            echo '<li class="list-group-item"><strong>Prénom:</strong> ' . $prenom . '</li>';
            echo '</ul>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<ul class="list-group details-list">';
            echo '<li class="list-group-item"><strong>Date de Naissance:</strong> ' . $date_N . '</li>';
            echo '<li class="list-group-item"><strong>Adresse:</strong> ' . $address . '</li>';
            echo '<li class="list-group-item"><strong>Téléphone:</strong> ' . $tel . '</li>';
            echo '<li class="list-group-item"><strong>Email:</strong> ' . $email . '</li>';
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>