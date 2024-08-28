<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la valeur de Taux et IR</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    <style>
    body,
    * {
        font-family: poppins , sans-serif;
    }
    .link{
        font-weight: 500;

    }
    </style>
</head>

<body>
    <div class='d-flex justify-content-between align-items-center container m-5'>
        <div class=''>
            <a href="recherche.php" class='link'><img src="back.svg" alt="Retour"> Retour</a>
        </div>
        <div>
            <button id="reloadButton" class="btn btn-primary"><img src="refresh.svg" alt="">Actualiser la page</button>
        </div>
    </div>
    <div class="container mt-2">
        <h1 class="text-center">Modifier les valeurs de Taux et IR</h1>

        <!-- Affichage des valeurs actuelles -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Valeurs actuelles</h5>
                <p class="card-text">
                    <strong>Taux:</strong> <span id="currentTaux"></span><br>
                    <strong>IR:</strong> <span id="currentIR"></span>%
                </p>
            </div>
        </div>

        <form id="modificationForm">
            <div class="form-group">
                <label for="taux">Nouveau Taux :</label>
                <input type="number" class="form-control" id="taux" name="taux" placeholder="Entrez le nouveau taux"
                    step="0.01" required>
            </div>
            <div class="form-group">
                <label for="ir">Nouveau IR :</label>
                <input type="number" class="form-control" id="ir" name="ir" placeholder="Entrez le nouveau IR"
                    step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>


        <div id="message" class="mt-3"></div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS to handle form submission and load current values -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch current values of Taux and IR from the backend
        fetch('get-config.php')
            .then(response => response.json())
            .then(data => {
                // Display current values
                document.getElementById('currentTaux').textContent = data.Taux;
                document.getElementById('currentIR').textContent = data.IR;
                document.getElementById('taux').value = data.Taux;
                document.getElementById('ir').value = data.IR;
            })
            .catch(error => {
                console.error('Error fetching config data:', error);
            });
    });

    document.getElementById('modificationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Collect the form data
        const taux = document.getElementById('taux').value;
        const ir = document.getElementById('ir').value;

        // Submit the form data via Fetch API
        fetch('update-config.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    taux,
                    ir
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('message').innerHTML = `
                        <div class="alert alert-success">
                            Les valeurs de Taux et IR ont été mises à jour avec succès.
                        </div>
                    `;
                } else {
                    document.getElementById('message').innerHTML = `
                        <div class="alert alert-danger">
                            Échec de la mise à jour des valeurs: ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error updating config data:', error);
                document.getElementById('message').innerHTML = `
                    <div class="alert alert-danger">
                        Une erreur s'est produite lors de la mise à jour des valeurs.
                    </div>
                `;
            });
    });

    // Reload the page when the button is clicked
    document.getElementById('reloadButton').addEventListener('click', function() {
        location.reload();
    });
    </script>
</body>

</html>