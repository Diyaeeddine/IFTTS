<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des groupes</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

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
            font-weight:500;

            font-family: poppins, sans-serif;
        }
        table{
            margin-left:auto;
            margin-right: auto;
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
    <a href="../home/home.php" class='link d-flex'><img src="back.svg" alt="Retour">Retour à la page d'accueil</a></div>
    <h2 class="text-center mt-4 mb-4">Suivi de formation</h2>
    <div class="container">
        <div id="alert-message" class="alert" role="alert" style="display: none;"></div>
        <table class='table mt-5 w-75'>
            <thead>
                <th>Numéro de groupe</th>
                <th>Promotion</th>
                <th>Filière</th>
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
                    echo "<tr class='p-3'>
                            <td>
                                <a href='./groupe_niveau.php?N_Groupe=" . $row['N_Groupe'] . "' class='link-primary'>
                                    Groupe " . $row['N_Groupe'] . "
                                </a>
                            </td>
                            <td>" . $row['promotion'] . "</td>
                            <td>" . $row['filiere'] . "</td>
                          </tr>";
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
            const alertMessage = document.getElementById('alert-message');

            if (msg) {
                if (msg === 'Success') {
                    alertMessage.classList.add('alert-success');
                    alertMessage.textContent = 'Opération réussie.';
                } else if (msg === 'Error') {
                    alertMessage.classList.add('alert-danger');
                    alertMessage.textContent = 'Erreur lors de l\'opération.';
                }
                alertMessage.style.display = 'block';
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>

</html>
