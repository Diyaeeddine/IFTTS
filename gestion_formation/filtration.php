<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Résultats de Filtration</title>
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 10px 20px;
        background-color: #f4f4f4;
        background-color: #166d3b;
        background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
        background-attachment: fixed;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin: 50px 0;
    }

    form {
        width: 70%;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-wrap: wrap;
    }

    label {
        font-weight: bold;
        padding: 10px 20px;

    }

    select,
    button {
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 10px 40px;
        font-size: 16px;
    }

    button {
        background-color: #007bff;
        color: #fff;
        padding: 12px 50px;
        font-size: 15px;
        border: none;
        cursor: pointer;
    }


    button:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        background: #fff;
        text-align: center;
    }

    th {
        background-color: #bbbdbb;
    }

    .tbl {
        padding: 30px 0px;
        /* background:#fff; */
    }

    .return {
        padding: 10px 20px;
        background-color: #fff;
        text-decoration: none;
        color: #000;
        /* border-radius: 5px; */
        transition: ease-in-out 0.3s;
        /* position: relative; */
        /* overflow: hidden; */
        float: right;
        /* margin-left: 950px; */

    }

    @media screen and (max-width: 479px) {
        div.container {
            margin: 0;
            width: 100%;
            padding: 20px;
            margin-bottom: 20px;
            margin-top: 0px !important;
            max-width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
    }

    /* .return::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #0A5C36;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
        z-index: 0;
    }

    .return:hover::before {
        transform: scaleX(1);
    } */
    .centform {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <a href="dashboard_formation.php" class="return"><i class="fa-solid fa-arrow-left"></i> Retour</a>

        <h1>Résultats de Filtration</h1>
        <br>
        <div class='centform'>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <select id="niveau" name="niveau">
                    <option value="">Niveau</option>
                    <?php
                include "connection.php";

                // Récupérer les niveaux existants dans la base de données
                $sql_niveau = "SELECT DISTINCT niveau FROM programme_formation where niveau!=4 order by niveau asc";
                $result_niveau = $conn->query($sql_niveau);
                if ($result_niveau->num_rows > 0) {
                    while ($row = $result_niveau->fetch_assoc()) {
                        echo "<option value='" . $row['niveau'] . "'>"; 
                        if ($row['niveau'] == 1) {
                            echo '1ère année';
                        } elseif ($row['niveau'] == 2) {
                            echo '2ème année';
                        } elseif ($row['niveau'] == 3) {
                            echo '1ère et 2ème année';
                        }                        
                        echo "</option>";
                    }
                }
                ?>
                </select>

                <select id="coefficient" name="coefficient">
                    <option value="">Coefficient</option>
                    <?php
                // Récupérer les coefficients existants dans la base de données
                $sql_coefficient = "SELECT DISTINCT coefficient FROM programme_formation";
                $result_coefficient = $conn->query($sql_coefficient);
                if ($result_coefficient->num_rows > 0) {
                    while ($row = $result_coefficient->fetch_assoc()) {
                        echo "<option value='" . $row['coefficient'] . "'>" . $row['coefficient'] . "</option>";
                    }
                }
                ?>
                </select>


                <button type="submit">Filtrer</button>
            </form>
        </div>

        <!-- Afficher les résultats filtrés ici -->

    </div>
    <div class="tbl">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $niveau = $_POST['niveau'];
            $coefficient = $_POST['coefficient'];

            // Construire la requête SQL basée sur les filtres sélectionnés
            $sql_filter = "SELECT * FROM programme_formation WHERE 1=1";
            if (!empty($niveau)) {
                $sql_filter .= " AND niveau='$niveau'";
            }
            if (!empty($coefficient)) {
                $sql_filter .= " AND coefficient='$coefficient'";
            }
            // Ajouter la sélection des volumes horaires
            $sql_filter .= " AND VH_1ere IS NOT NULL AND VH_2eme IS NOT NULL";

            // Exécuter la requête filtrée
            $result_filter = $conn->query($sql_filter);
            if ($result_filter->num_rows > 0) {
                // Afficher les résultats filtrés dans un tableau
                echo "<table border='1'>";
                echo "<tr><th>Unité de Formation</th><th>Niveau</th><th>VH 1ère Année</th><th>VH 2ème Année</th><th>Coefficient</th></tr>";
                while ($row = $result_filter->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["matieres"] . "</td>";
                    echo "<td>" . $row["niveau"] . "</td>";
                    echo "<td>" . $row["VH_1ere"] . "</td>";
                    echo "<td>" . $row["VH_2eme"] . "</td>";
                    echo "<td>" . $row["coefficient"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
            } else {
                echo "Aucun résultat trouvé.";
            }
        }

        // Fermer la connexion à la base de données
        $conn->close();
        ?>
    </div>
</body>

</html>