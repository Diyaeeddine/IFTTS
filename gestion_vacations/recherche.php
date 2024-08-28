<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès aux vacations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
    .linkkk, .parr {
        text-decoration: none;
        font-weight: 500;

    }

    .linkkk:hover,.parr:hover {
        text-decoration: underline;
    }
    </style>
    <script>
    function autoSubmit() {
        const select = document.getElementById('mois');
        if (select.value !== "0") {
            const form = document.getElementById('mois');
            form.submit();
        }
    }
    </script>
</head>

<body>
    <div class='m-5 mb-2 d-flex justify-content-between font-weight-bold'>
        <a href="../home/home.php" class='link font-weight-bold linkkk'><img src="back.svg" alt="Retour">Retour à la
            page d'accueil</a>
        <a href="settings.php" class='font-weight-bold parr'><img src="./settings.svg" alt="Paramètre">Paramètres</a>
    </div>

    <div class='container'>
        <header>
            <h1 class="m-5">Accès aux vacations</h1>
        </header>
        <main class="container">
            <?php
                $N_Groupe= isset($_GET['N_Groupe']) ? (int) $_GET['N_Groupe'] : '0'; 
                $Niveau= isset($_GET['Niveau']) ? (int) $_GET['Niveau'] : '0'; 
                $mois= isset($_GET['mois']) ? $_GET['mois'] : '0'; // Pas besoin de convertir en int pour le mois
            ?>
            <form class="row gx-3" action='./vacation.php' method='GET'>
                <div class="col-md-3">
                    <label for="N_Groupe" class="form-label">Groupe:</label>
                    <select name="N_Groupe" id="N_Groupe" class="form-select">
                        <option value="0">Sélectionner le groupe</option>
                        <?php
                        $groupe_request = "SELECT DISTINCT N_Groupe FROM vacations WHERE N_Groupe != '' ORDER BY N_Groupe ASC";
                        $result = $conn->query($groupe_request);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['N_Groupe'] == $N_Groupe) ? 'selected' : '';
                                echo "<option value='" . $row['N_Groupe'] . "' $selected>Groupe " . $row['N_Groupe'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="Niveau" class="form-label">Niveau:</label>
                    <select name="Niveau" id="Niveau" class="form-select">
                        <option value="0">Sélectionner le niveau</option>
                        <?php
                        $annee_request = "SELECT DISTINCT Niveau FROM vacations ORDER BY Niveau ASC";
                        $result = $conn->query($annee_request);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['Niveau'] == $Niveau) ? 'selected' : '';
                                $niveau_text = ($row['Niveau'] == 1) ? "1<sup>ère</sup> année" : $row['Niveau'] . "<sup>ème</sup> année";
                                echo "<option value='" . $row['Niveau'] . "' $selected>" . $niveau_text . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="mois" class="form-label">Mois:</label>
                    <select name="mois" id="mois" class="form-select" onchange="autoSubmit()">
                        <option value="0">Sélectionner le mois</option>
                        <?php
                        $mois_order = "FIELD(mois, 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre')";
                        $mois_request = "SELECT DISTINCT mois FROM vacations WHERE mois != '' ORDER BY $mois_order";
                        $result = $conn->query($mois_request);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['mois'] == $mois) ? 'selected' : '';
                                echo "<option value='" . $row['mois'] . "' $selected>" . ucfirst($row['mois']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary"><img src="./search.svg" alt="">Rechercher</button>
                </div>
            </form>
        </main>

        <?php
        $conn->close();
        ?>
    </div>
</body>

</html>
