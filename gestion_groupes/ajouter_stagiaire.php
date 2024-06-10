<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un stagiaire</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,html {
            font-family: poppins, sans-serif;
        }
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }
    </style>
</head>
<body>
    <?php
    include 'connection.php';
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
            <div class='m-5 d-flex'><a href="liste_stagiaires.php" class="link "><img src="back.svg" alt="">Retour à la liste des stagiaires</a></div>

    <div class="container w-75 mt-5">
        <h2 class="text-center mb-4">Ajouter un stagiaire</h2>
        <form action="traitement_ajout_stagiaire.php" method="POST">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
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
                echo "<option value='" . $row2['N_Groupe'] . "'>Groupe " . $row2['N_Groupe'] . "</option>";
            }
        }
        ?>
    </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
