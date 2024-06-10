<!-- <?php
// Include the database connection file
include 'connection.php';

// Start the session
session_start();

// Fetch trainers data from the database 
$sql_trainers = "SELECT * FROM formateurs order by nom asc";
$result_trainers = mysqli_query($conn, $sql_trainers);

// Fetch trainers' groups data from the database
$sql_trainer_groups = "SELECT DISTINCT formateurs.CIN, formateurs.nom, formateurs.prenom, groupes.N_Groupe, groupes.filiere, groupes.promotion
                        FROM formateurs
                        INNER JOIN formateurs_groupes ON formateurs.CIN = formateurs_groupes.CIN
                        INNER JOIN groupes ON formateurs_groupes.N_Groupe = groupes.N_Groupe";


$result_trainer_groups = mysqli_query($conn, $sql_trainer_groups);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Formateurs et Groupes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body,
        html {
            font-family: poppins, sans-serif;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-5 text-center">Gestion des Formateurs et Groupes</h2>
        <div  class="d-flex justify-content-around">
        <a href='lierform_groupe.php' class="mb-3 btn btn-success" >Lier des Formateurs à des Groupes</a>
        <a href='ôterform_groupe.php' class="mb-3 btn btn-danger" >Ôter des Formateurs à des Groupes</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Formateur</th>
                        <th>Groupes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($trainer = mysqli_fetch_assoc($result_trainers)) : ?>
                        <tr>
                            <td><?php echo $trainer['nom'] . ' ' . $trainer['prenom']; ?></td>
                            <td>
                                <?php
                                $groups = array();
                                mysqli_data_seek($result_trainer_groups, 0); // Reset result pointer
                                while ($trainer_group = mysqli_fetch_assoc($result_trainer_groups)) {
                                    if ($trainer_group['CIN'] === $trainer['CIN']) {
                                        $groups[] = "Groupe " . $trainer_group['N_Groupe'] . " - " . $trainer_group['filiere'] . " (" . $trainer_group['promotion'] . ")";
                                    }
                                }
                                echo implode(", ", $groups);
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
 -->
