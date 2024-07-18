<?php
include 'connection.php';

$N_Groupe = isset($_GET['groupe']) ? (int)$_GET['groupe'] : 0;
$Niveau = isset($_GET['Niveau']) ? (int)$_GET['Niveau'] : 0;
$mois = isset($_GET['mois']) ? $conn->real_escape_string($_GET['mois']) : '';
$sqlpromotion='SELECT DISTINCT promotion FROM groupes WHERE N_Groupe= '.$N_Groupe;

$result = mysqli_query($conn, $sqlpromotion);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Frais</title>
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
    * {
        font-family: arial;
    }

    .txt {
        display: flex;
        margin-left: 50px;
        margin-top: 25px;
        font-size: 12px;
        font-weight: bold;
    }

    .p {
        text-align: center;
        line-height: 18px;
    }

    h3 {
        text-align: center;
        line-height: 27px;
    }

    .cont {
        display: flex;
        flex-direction: column;
    }

    p {
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 14px;

    }

    .info {
        font-weight: bold;
        text-align: center;
    }

    table th,
    table td {
        border: 2px solid #000;
        padding: 1px 4px;
    }

    a {
        color: #0d6efd;
        text-decoration: none;
        font-size:17px;
        font-weight:bold;
    }

    #href {
        padding: 0 30px 0 0;
        font-family: poppins, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    button{
        background-color:#0d6efd;
        color:white;
        border:none;
        padding:10px 15px;
        border-radius:4px;
        cursor:pointer;
        transition:.2s;
        letter-spacing:.8px
    }
    button:hover{
        background-color:#1465dd;

    }
    .imgs{
        margin-right:3px;
    }
    .print {

        display: flex;
        justify-content: center;
        align-items: center;
    }

    table th {
        background-color: #f2f2f2;
    }

    table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }


    @media print {

        #href,
        .print{
            display: none;
        }

    }
    </style>
</head>

<body>
    <div class='cont'>
        <div style='display:flex; justify-content:space-between; align-items:center'>
            <div class="txt">
                <p class='p'>ROYAUME DU MAROC <br>
                    MINISTERE DE L'INTERIEUR <br>
                    DIRECTION GENERALE DES COLLECTIVITES TERRITORIALES <br>
                    DIRECTION DU DEVELOPPEMENT DES COMPETENCES <br>
                    ET DE LA TRANSFORMATION DIGITALE <br>
                    INSTITUT DE FORMATION DES TECHNICIENS <br>
                    ET TECHNICIENS SPECIALISES AL HOCEIMA
                </p>
            </div>
            <div id='href'>
                
                <a href="recherche.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>&mois=<?php echo $mois ?>"
                    class="link print"><img src="back.svg" alt="Retour">Retour</a>
            </div>
        </div>
        <div>
            <div class='print'>
                <button onclick="window.print()" class="print"><img class='imgs'
                        src='./print.svg' alt=''> Imprimer</button>
            </div>
            <h3>FRAIS DE COURS ET VACATIONS <br>
                IMPUTATION : 1.2.1.2.0.08.000.114.00.21.16</h3>
        </div>
    </div>
    <div>
        <p class='info'>
            <?php
        if (mysqli_num_rows($result) == 1) {
          $row = mysqli_fetch_assoc($result);
          $promotion = $row['promotion'];
        
        echo "Groupe " . sprintf("%02d", $N_Groupe) . " - " . ($Niveau == 1 ? "1ère" : $Niveau . "ème") . " Année - Promotion ".$promotion ;
      }
        ?>
        </p>
    </div>
    </div>
    <table id="fraisTable">
        <thead>
            <tr>
                <th>CIN</th>
                <th style='margin:0px 20px;'>Nom</th>
                <th>Prénom</th>
                <th>Grade</th>
                <th>Objet</th>
                <th>Mois</th>
                <th>Nombre</th>
                <th>Taux</th>
                <th>BRUT</th>
                <th>IR</th>
                <th>NET</th>
            </tr>
        </thead>
        <tbody>
            <?php
      if ($N_Groupe && $Niveau && $mois) {
        $sql = $conn->prepare('
          SELECT  v.CIN, 
                 f.nom AS Nom, 
                 f.prenom AS Prénom, 
                 f.grade AS Grade, 
                 matiere AS Objet,
                 mois, 
                 Tn_heures, 
                 Taux, 
                 BRUT, 
                 IR, 
                 NET
          FROM vacations v
          JOIN formateurs f ON v.CIN = f.CIN
          WHERE v.N_Groupe = ? 
            AND v.Niveau = ? 
            AND v.mois = ?
        ');

        $sql->bind_param('iis', $N_Groupe, $Niveau, $mois);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $CIN = $row['CIN'];
            $Nom = $row['Nom'];
            $Prénom = $row['Prénom'];
            $Grade = $row['Grade'];
            $Objet = $row['Objet'];
            $Mois = $row['mois'];
            $Nombre =$row['Tn_heures'];
            $Taux = number_format($row['Taux'], 1, '.', '');
            $BRUT = number_format($row['BRUT'], 2, '.', '');
            $IR = number_format($row['IR'], 2, '.', '');
            $NET = number_format($row['NET'], 2, '.', '');
            if(!$Nombre==0){
            echo "<tr>
              <td>$CIN</td>
              <td>$Nom</td>
              <td>$Prénom</td>
              <td>$Grade</td>
              <td>$Objet</td>
              <td>$Mois</td>
              <td style='text-align:center' >$Nombre</td>
              <td style='text-align:right' >$Taux</td>
              <td style='text-align:right'>$BRUT</td>

              <td style='text-align:right'>$IR</td>
              <td style='text-align:right'>$NET</td>
            </tr>";
        }
          }
        } else {
          echo "<tr><td colspan='11' class='text-center'>Aucune donnée trouvée</td></tr>";
        }

        $sql->close();
      } else {
        echo "<tr><td colspan='11' class='text-center'>Veuillez sélectionner tous les filtres</td></tr>";
      }

      $conn->close();
      ?>
        </tbody>
    </table>
    <div style='display: flex; justify-content: space-between; padding:0px 20px;'>
        <div>
            <p>Sous Ordonnateur</p>
        </div>
        <div style='display: flex; flex-direction:column'>
            <p>AL HOCEIMA, Le ...............................................</p>
            <p>Rabat, Le ...............................................</p>
        </div>
    </div>

</body>

</html>