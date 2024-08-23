<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    

    <style>
    html,
    body {
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
        flex-direction: row;

        
        justify-content: center;
        align-items: center;
        margin: 20px;
    
        margin-top: 40px;   
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
        <a href="./select_groupe.php" class='link'><img src="back.svg" alt="Retour">Retour</a>
    </div>

    <div class="mt-3">
        <div class="container">
            <div class="row flex-container">
                <div >
                    <?php if(isset($_GET['N_Groupe'])){
                        $N_Groupe = $_GET['N_Groupe'];
                        
                        }?>
                    <a href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=1" class="btn btn-success btn-custom">1<sup>ère</sup>&nbsp année</a>
                </div>
                <div >
                    <a href="./liste_stagiaires.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=2" class="btn btn-success btn-custom">2<sup>ème</sup>&nbsp année</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>