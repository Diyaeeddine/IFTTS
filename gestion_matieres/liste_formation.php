<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme formation</title>
    <style>
    body {
        /* font-family: "Poppins", sans-serif; */
        padding: 50px 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #bbbdbb;
    }

    .middle {
        border: 1px solid #000;
        padding: 8px;
    }

    /* Apply specific styling for UF cell */
    </style>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="8">
                    <h1>PROGRAMME DE FORMATION</h1>
                </th>
            </tr>
            <tr>
                <th>UNITES DE FORMATION (UF)</th>
                <th>Niveau</th>
                <th>Volume Horaire <br>1ère Année</th>
                <th>Volume Horaire <br>2ème Année</th>
                <th>Masse <br>Horaire <br>Globale</th>
                <th>Coefficient</th>
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

                $sql = "SELECT matieres, niveau, VH_1ere, VH_2eme, masse_horaire_globale, coefficient FROM programme_formation ORDER BY date_creation ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $total_VH_1ere = 0;
                    $total_VH_2eme = 0;

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
        <td style='text-align: left;'>" . $row["matieres"] . "</td>
        <td>";

if ($row["niveau"] == 1) {
    echo "1ère année";
} elseif ($row["niveau"] == 2) {
    echo "2ème année";
} elseif ($row["niveau"] == 3) {
    echo "1ère et 2ème année";
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