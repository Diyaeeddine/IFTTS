<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        html, body {
            font-weight:500;

            
            font-family:poppins,sans-serif;
        }
        .btn-custom {
            width: 200px; 
            height: 200px; 
            font-size: 18px; 
            line-height: 1.5; 
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<?php
include 'connection.php';
if(isset($_GET['N_Groupe'])){
    $N_Groupe=$_GET['N_Groupe'];

}
?>
    <div class='m-5'>
        <a href="../gestion_suivi_formation/liste_groupe.php" class='link'><img src="back.svg" alt="Retour">Retour</a>
    </div>
    <div class="container mt-3">

<section class="container text-center d-flex justify-content-center align-items-center h-100 mt-5">
    <div class="row">
        <div class="col-md-6">
            <a href='suivi_formation.php?N_Groupe=<?php echo $N_Groupe?>&Niveau=1' class="btn btn-success btn-custom">1<sup>ère &nbsp</sup> année</a>
            
        </div>
        <div class="col-md-6">
            <a href='suivi_formation.php?N_Groupe=<?php echo $N_Groupe?>&Niveau=2' class="btn btn-success btn-custom">2<sup>ème &nbsp</sup> année</a>
        </div>
    </div>
</section>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
