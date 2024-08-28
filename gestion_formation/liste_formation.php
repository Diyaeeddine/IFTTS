<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme formation</title>
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    
    <style>
    body {
        /* font-family: "Poppins", sans-serif; */
        padding: 20px;
    }

    table {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;

    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px 6px;
        text-align: center;
    }

    th {
        background-color: #bbbdbb;
    }

    .middle {
        border: 1px solid #000;
        padding: 8px;
    }

    a {
        text-decoration: none;

        transition: .2s;
        color: #007bff;
        font-family: poppins, sans-serif;
        font-weight: 500;
        display: flex;
    }

    a:hover {

        color: #186fcd;


    }

    .m {
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    button {

        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: .2s;
        letter-spacing: .8px
    }

    button:hover {
        background-color: #1465dd;

    }

    .print {

        display: flex;
        align-items: center;
    }

    @media print {

        .m {
            display: none;
        }
        table {
            width: 95%;
        }
    }
    </style>
</head>

<body>
    <div class='m'>
        <div>
            <a href="./dashboard_formation.php" class='link p-3'><img src="back.svg" alt="">Retour</a>
        </div>
        <div class='print'>
            <button onclick="window.print()" class="print"><img class='imgs' src='./print.svg' alt=''> Imprimer</button>
        </div>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th colspan="8">
                    <h3>PROGRAMME DE FORMATION</h3>
                </th>
            </tr>
            <tr>
                <th>UNITES DE FORMATION (UF)</th>
                <th>Niveau</th>
                <th>VH <br>1<sup>ère</sup> Année</th>
                <th>VH <br>2<sup>ème</sup> Année</th>
                <th>MH <br>Globale</th>
                <th>Coef</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "iftts";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT matieres, niveau, VH_1ere, VH_2eme, (VH_1ere + VH_2eme) AS masse_horaire_globale, coefficient, 
                CAST(SUBSTRING(matieres, 3, LENGTH(matieres) - 2) AS UNSIGNED) AS uf_number 
                FROM programme_formation where niveau!=4
                ORDER BY uf_number ASC, date_creation ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $total_VH_1ere = 0;
                    $total_VH_2eme = 0;

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
        <td style='text-align: left;'>" . $row["matieres"] . "</td>
        <td>";

if ($row["niveau"] == 1) {
    echo "1<sup>ère</sup> année";
} elseif ($row["niveau"] == 2) {
    echo "2<sup>ème</sup> année";
} elseif ($row["niveau"] == 3) {
    echo "1<sup>ère</sup> et 2<sup>ème</sup> année";
}

echo    "</td>
        <td>" . $row["VH_1ere"] . "</td>
        <td>" . $row["VH_2eme"] . "</td>
        <td>" . ($row["VH_1ere"] + $row["VH_2eme"]) . "</td>
        <td>" . $row["coefficient"] . "</td>
    </tr>";


                        // Calculate total VH_1ere and VH_2eme
                        $total_VH_1ere += $row["VH_1ere"];
                        $total_VH_2eme += $row["VH_2eme"];
                    }

                    // Display the Total général pa an row with calculated totals
                //     echo "<tr>
                //             <td>Total général pa an</td>
                //             <td>$total_VH_1ere</td>
                //             <td>$total_VH_2eme</td>
                //             <td colspan='4'>" . ($total_VH_1ere + $total_VH_2eme) . "</td>
                //         </tr>";

                //     $total_general = $total_VH_1ere + $total_VH_2eme;
                //     echo "<tr>
                //             <td>Total général pour les 2 années</td>
                //             <td colspan='6'>$total_general heures</td>
                //         </tr>";
                // } else {
                //     echo "<tr><td colspan='7'>Aucun résultat trouvé.</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
        </tbody>
    </table>
</body>

</html>