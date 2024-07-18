<!DOCTYPE html>
<html lang="fr">
<?php 
include 'connection.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mois de l'Année</title>
    <!-- Bootstrap CSS -->
    <style>
    a {
        font-weight: 500;
    }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
    // Fonction pour ajouter les mois à la liste déroulante
    function populateMonths() {
        const months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        const select = document.getElementById('monthSelect');

        for (let i = 0; i < months.length; i++) {
            const option = document.createElement('option');
            option.value = months[i]; // La valeur de l'option est le nom du mois
            option.text = months[i];
            select.appendChild(option);
        }
    }

    // Fonction pour soumettre le formulaire automatiquement
    function autoSubmit() {
        const select = document.getElementById('monthSelect');
        if (select.value !== "0") {
            const form = document.getElementById('monthForm');
            form.submit();
        }
    }

    // Appeler la fonction pour remplir la liste déroulante au chargement de la page
    window.onload = populateMonths;
    </script>
</head>

<body>

    <?php
    if (isset($_GET['N_Groupe']) && isset($_GET['Niveau']) && isset($_GET['CIN']) && isset($_GET['matieres'])) {
        $N_Groupe = htmlspecialchars($_GET['N_Groupe'], ENT_QUOTES);
        $Niveau = htmlspecialchars($_GET['Niveau'], ENT_QUOTES);
        $CIN = htmlspecialchars($_GET['CIN'], ENT_QUOTES);
        $matieres = htmlspecialchars($_GET['matieres'], ENT_QUOTES);
    ?>
    <div class='m-5'>
        <a href="suivi_formation.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class='link d-flex'>
            <img src="back.svg" alt="">Retour
        </a>
    </div>
    <div class="container mt-5">
        <form id="monthForm" action="table_suivi.php" method="GET">
            <input type="hidden" name="N_Groupe" value="<?php echo $N_Groupe; ?>">
            <input type="hidden" name="Niveau" value="<?php echo $Niveau; ?>">
            <input type="hidden" name="CIN" value="<?php echo $CIN; ?>">
            <input type="hidden" name="matieres" value="<?php echo $matieres; ?>">

            <div class="form-group">
                <label for="monthSelect" class=''>Choisissez un mois :</label>
                <select id="monthSelect" name="mois" class="form-control" onchange="autoSubmit()">
                    <option value="0">Sélectionner le mois</option>
                </select>
            </div>
        </form>
    </div>
    <div class='container '>

    </div>
    <?php
    } else {
        echo 'Veuillez revenir en arrière et sélectionner le mois. Merci !';
    }
    ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
