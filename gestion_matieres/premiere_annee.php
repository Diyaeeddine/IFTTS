<!-- premiere_annee.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <title>Matières - Première Année</title>
    <style>
        body{
        /* font-family: "Poppins", sans-serif;
        font-weight:400; */
        padding:50px 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #bbbdbb;
        }
    </style>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iftts";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM programme_formation WHERE niveau = '1ére Année' ORDER BY date_creation ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
        <tr>
            <th colspan='5'><h1>Matières - Première Année</h1></th>
        </tr>
        <th>Matières</th>
        <th>Niveau</th>
        <th>Volume Horaire 1ère</th>
        <th>Volume Horaire 2ème</th>
        <th>Coefficient</th>
       
        </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='text-align: left;'>".$row["matieres"]."</td>";
            echo "<td>".$row["niveau"]."</td>";
            echo "<td>".$row["VH_1ere"]."</td>";
            echo "<td>".$row["VH_2eme"]."</td>";
            echo "<td>".$row["coefficient"]."</td>";
            // echo "<td>".$row["designation"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucune donnée trouvée pour Première Année.";
    }
    $conn->close();
    ?>
</body>
</html>
