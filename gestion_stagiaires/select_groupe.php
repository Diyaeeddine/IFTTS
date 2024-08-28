<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">


    <style>
        html, body {
            font-weight: 500;
            font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
        }
        .btn-custom {
            width: 175px; 
            height: 175px; 
            font-size: 18px; 
            line-height: 1.5; 
            font-weight: 600;
           
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px;
            margin-top:40px;
        }
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>

<?php
include 'connection.php';
?>

<div class='m-5'>
    <a href="../home/home.php" class='link'><img src="back.svg" alt="Retour">Retour à la page d'accueil</a>
</div>

<div class="mt-3">
    <div class="container">
        <div class="row flex-container">
            <?php 
            $sql = "SELECT DISTINCT N_Groupe FROM groupes";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $N_Groupe = $row['N_Groupe'];
                echo '
                <div>
                    <a href="./select_niveau.php?N_Groupe=' . $N_Groupe . '" class="btn btn-primary btn-custom">Groupe ' . $N_Groupe . '</a>
                </div>
                ';
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
