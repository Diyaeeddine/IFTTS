<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des stagiaires</title>
    <style>
    body,
    html {
        font-family: poppins, sans-serif;
        margin: 0;
        padding: 0;
    }

    td,
    tr,
    th {
        border: 2px solid;
    }

    table {
        width: 95%;
        border-collapse: collapse;
        


    }

    #goi {
        color: #007bff;
        transition: .3s;
        text-decoration: none;
    }

    #goi:hover {
        color: #0058b6;
        text-decoration: underline;
    }

    .heit {
        margin: 3em;
    }



    .print {
        background-color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        color: white;
        padding: 10px 20px;
        margin: 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: .3s;
        font-size: 16px;
    }
    td{
        padding:2px 5px;
    }

    .print:hover {
        background-color: #0058b6;
    }
    .center {
  margin-left: auto;
  margin-right: auto;
}

    @media print {

        .print,
        .heit {
            display: none;
        }
        h2{


            margin-top:50px;
            margin-bottom:20px;
        }
    }

    </style>
</head>

<body>
    <?php         
    include 'connection.php';
    if (isset($_GET['N_Groupe']) && isset($_GET['Niveau'])) {
        $N_Groupe = (int) $_GET['N_Groupe'];
        $Niveau = (int) $_GET['Niveau'];
    ?>
    <div style="" class='heit'>
        <a style="display:flex; align-items:center" id="goi"
            href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>" class=''>
            <img src="back.svg" alt=""> Retour
        </a>
    </div>
    <div class="container">
        <h2 style="text-align:center;font-weight:500; ">
            Liste des stagiaires Groupe <?php echo $N_Groupe; ?> -
            <?php echo ($Niveau === 1) ? '1ère année' : '2ème année'; ?>
        </h2>
        <div style='display:flex; justify-content:center;'>
            <button onclick="window.print()" class="btn btn-primary mb-4 print afterPrint">
                <img class='text-center' src='../gestion_suivi_formation/imgs/print.svg' alt=''> Imprimer
            </button>
        </div>
<div class='container'></div>
        <?php
        $sql = "SELECT s.id, s.CIN, s.nom, s.prenom, s.date_N, s.address, s.tel, s.email
                FROM stagiaires s
                JOIN stagiaires_groupes sg ON s.id = sg.id_stagiaire
                WHERE sg.N_Groupe = $N_Groupe AND sg.Niveau = $Niveau
                ORDER BY s.nom ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table class="center">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">CIN</th>';
            echo '<th scope="col">Nom</th>';
            echo '<th scope="col">Prénom</th>';
            echo '<th scope="col">Date de naissance</th>'; 
            echo '<th scope="col">Adresse</th>';
            echo '<th scope="col">Téléphone</th>'; 
            echo '<th scope="col">Email</th>'; 
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["CIN"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["prenom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["date_N"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["address"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["tel"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                echo '</tr>';
                
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p class='text-center'>Aucun stagiaire trouvé pour ce groupe.</p>";
        }
        mysqli_close($conn);
    }
    ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>