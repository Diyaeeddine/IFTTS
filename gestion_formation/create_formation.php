<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <title>Création de Formation</title>
    <style>
    body {
        font-family: "Poppins", sans-serif;
        font-weight: 500;
        background-color: #166d3b;
        background-image: linear-gradient(147deg, #166d3b 0%, #000000);
        padding-bottom: 300px;
        margin: 0;
        padding: 0;
        background-attachment: fixed;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .container {
        width: 50%;
        margin: 50px auto;
        background-color: #fff;
        padding: 50px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    select,
    button[type="submit"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 16px;
    }

    button[type="submit"] {
        background: #ffc107;
        color: #000;
        border: none;
        cursor: pointer;
        transition: ease-in-out 0.3s;
    }

    button[type="submit"]:hover {
        box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
    }

    .hrefs {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
    }


    a {
        text-decoration: none;
        color: #01418f;
        transition: ease-in-out 0.1s;
        /* margin: 20px; */

    }

    a:hover {
        color: #008000;
    }

    .success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
    }

    .error {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
    }
    @media screen and (max-width:430px) {
        .container{
            width: 100%;
            padding: 20px;
            margin: 0;
            margin-bottom: 20px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Création de Formation</h1>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "iftts";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $matieres = mysqli_real_escape_string($conn, $_POST['matieres']);
            $VH_1ere = isset($_POST['VH_1ere']) ? intval($_POST['VH_1ere']) : 0;
            $VH_2eme = isset($_POST['VH_2eme']) ? intval($_POST['VH_2eme']) : 0;
            $coefficient = intval($_POST['coefficient']);
            $niveau = mysqli_real_escape_string($conn, $_POST['niveau']);

            $sql = "INSERT INTO programme_formation (matieres, niveau, VH_1ere, VH_2eme, coefficient) 
                    VALUES ('$matieres', '$niveau', '$VH_1ere', '$VH_2eme', '$coefficient')";
            $result = $conn->query($sql);
            if ($result) {
                echo '<div class="success">Formation ajoutée avec succès!</div>';
            } else {
                echo '<div class="error">Erreur lors de l\'ajout de la formation: ' . $conn->error . '</div>';
            }
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="matieres">Unité de Formation:</label>
            <input type="text" id="matieres" name="matieres" required>

            <label for="niveau">Niveau:</label>
            <select id="niveau" name="niveau" onchange="toggleVHInputs()">
                <option value="" disabled selected>Choisissez le niveau</option>
                <option value="1">1ère Année</option>
                <option value="2">2ème Année</option>
                <option value="3">1ère et 2ème Année</option>
            </select>

            <label for="VH_1ere">Volume Horaire 1ère Année:</label>
            <input type="number" id="VH_1ere" name="VH_1ere">

            <label for="VH_2eme">Volume Horaire 2ème Année:</label>
            <input type="number" id="VH_2eme" name="VH_2eme">

            <label for="coefficient">Coefficient:</label>
            <input type="number" id="coefficient" name="coefficient" required>

            <button type="submit">
                <div style='display:flex; align-items:center; justify-content:center;'><img src="./img/add.svg"
                        alt=""><span>Ajouter Formation</span></div>
            </button>
        </form>

        <div class="hrefs">
                <a href="liste_formation.php" style='padding-right:30px;'>Retour à la liste des
                    formations</a><span>ou</span>
                <a href="dashboard_formation.php" style='padding-left:30px;'>Retour au tableau de bord</a>
            </div>
    </div>

    <script>
    function toggleVHInputs() {
        var niveau = document.getElementById('niveau').value;
        var vh1ere = document.getElementById('VH_1ere');
        var vh2eme = document.getElementById('VH_2eme');

        if (niveau == "1") {
            vh1ere.disabled = false;
            vh2eme.disabled = true;
            vh2eme.value = "";
        } else if (niveau == "2") {
            vh1ere.disabled = true;
            vh2eme.disabled = false;
            vh1ere.value = "";
        } else if (niveau == "3") {
            vh1ere.disabled = false;
            vh2eme.disabled = false;
        } else {
            vh1ere.disabled = true;
            vh2eme.disabled = true;
            vh1ere.value = "";
            vh2eme.value = "";
        }
    }
    </script>
</body>

</html>