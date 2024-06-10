<?php
// Include the database connection file
include 'connection.php';

// Start the session
session_start();

// Initialize a variable to hold the success message
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['CIN']) && isset($_POST['N_Groupe'])) {
        // Sanitize the input
        $CIN = mysqli_real_escape_string($conn, $_POST['CIN']);
        $N_Groupe = mysqli_real_escape_string($conn, $_POST['N_Groupe']);

        // Insert the values into the relation table
        $sql = "INSERT INTO formateurs_groupes (CIN, N_Groupe) VALUES ('$CIN', '$N_Groupe')";
        if (mysqli_query($conn, $sql)) {
            // Set the success message
            $success_message = "Formateur lié au groupe avec succès.";
        } else {
            echo "Erreur lors de la liaison formateur-groupe : " . mysqli_error($conn);
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}

// Fetch trainers and groups data from respective tables
$sql_trainers = "SELECT CIN, nom, prenom FROM formateurs";
$result_trainers = mysqli_query($conn, $sql_trainers);

$sql_groups = "SELECT N_Groupe, filiere, promotion FROM groupes";
$result_groups = mysqli_query($conn, $sql_groups);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liens Formateur-Groupe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            font-family: poppins, sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class='container'>
    <a href="listeformgroupe.php" class='btn btn-secondary mt-5 p-3'>Retour vers la liste</a>
    </div>

    <div class='container w-50  text-center'>
        <h2 class='m-5'>Lier un formateur à un groupe</h2>

        <!-- Display the success message if set -->
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="mb-3 form-floating">
                        <select id="CIN" name="CIN" class='form-select' required>
                            <option value="">Sélectionner un formateur</option>
                            <?php while ($row = mysqli_fetch_assoc($result_trainers)) : ?>
                                <option value="<?php echo $row['CIN']; ?>"><?php echo $row['nom'] . ' ' . $row['prenom']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="CIN" class="form-label">Formateur</label>
                    </div>

                    <div class="mb-3 form-floating">
                        <select id="N_Groupe" name="N_Groupe" class='form-select' required>
                            <option value="">Sélectionner un groupe</option>
                            <?php while ($row = mysqli_fetch_assoc($result_groups)) : ?>
                                <option value="<?php echo $row['N_Groupe']; ?>">Groupe <?php echo $row['N_Groupe'] . ' - ' . $row['promotion']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <label for="N_Groupe" class="form-label">Groupe</label>
                    </div>
                </div>
            </div>
            <button type="submit" class='btn btn-success'>Lier Formateur-Groupe</button>
        </form>
    </div>
</body>
</html>
