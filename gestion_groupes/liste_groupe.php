<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des groupes</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajout de style personnalisé */
        #container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 100%;
        }

        body,
        html {
            font-weight: 500;
            font-family: Poppins, sans-serif;
        }

        section {
            margin: 10px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        section a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class='m-5'>
        <a href="../home/home.php" class='link '><img src="back.svg" alt="">Retour à la page d'accueil</a>
    </div>
    <h2 class="text-center mt-4 mb-4">Liste des groupes</h2>
    <div class="container">
        <div id="alert-message" class="alert" role="alert" style="display: none;"></div>
        <a href="ajoutergroupe.php" class="btn btn-success mb-5">Ajouter un groupe</a>
        <a href="liste_stagiaires.php" class="btn btn-success mb-5">La liste des stagiaires</a>
        <table class='table'>
            
            <thead>
                <th>Numéro de groupe</th>
                <th>Promotion</th>
                <th>Filière</th>
                <th>Liste des stagiaires</th>
                <th>Actions</th>
            </thead>
            <?php 
            include "connection.php";
            $sql = "SELECT N_Groupe, Niveau, filiere, promotion
                    FROM groupes
                    GROUP BY N_Groupe
                    ORDER BY N_Groupe ASC;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='p-3'><td><p>Groupe ". $row['N_Groupe'] ." </p></td><td>". $row['promotion'] ."</td><td>". $row['filiere'] ."</td><td><a href='liste_stagiaire.php?N_Groupe=". $row['N_Groupe'] ."'>Afficher les stagiaires</a></td><td class='d-flex justify-content-around'>";             
                    echo "<a href='edit_groupe.php?N_Groupe=". $row['N_Groupe'] ."&filiere=".$row['filiere']."&promotion=".$row['promotion']."' class='btn btn-success'><img class='text-center' src='../gestion_suivi_formation/imgs/edit.svg' alt='Modifier'></a>";
                    echo "<a href='delete_groupe.php?N_Groupe=". $row['N_Groupe'] ."' onclick=\"return confirm('Êtes-vous sûr de supprimer le groupe [" . $row['N_Groupe'] . "] ?')\" class='btn btn-danger'><img class='text-center' src='../gestion_suivi_formation/imgs/delete.svg' alt='Supprimer'></a>";            
                    echo "</td></tr>";
                }
            }
            ?>
        </table>
    </div>
    <!-- Bootstrap JavaScript (optionnel si vous n'utilisez pas les fonctionnalités JavaScript de Bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript pour afficher et masquer les alertes
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            const msgajoute = urlParams.get('msgajoute');
            const detail = urlParams.get('detail');
            const alertMessage = document.getElementById('alert-message');

            if (msg === 'Success' || msgajoute === 'Success') {
                alertMessage.classList.add('alert-success');
                alertMessage.textContent = 'Opération réussie.';
            } else if (msg === 'Error' || msgajoute === 'Error') {
                alertMessage.classList.add('alert-danger');
                alertMessage.textContent = 'Erreur lors de l\'opération';
                if (detail) {
                    alertMessage.textContent += ' : ' + decodeURIComponent(detail);
                }
            }

            if (msg || msgajoute) {
                alertMessage.style.display = 'block';
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>

</html>
