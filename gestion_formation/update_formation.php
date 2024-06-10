<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iftts";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selected_formation_id = '';
$row_old = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'update') {
        $old_matiere = $_POST['formation_id'];
        $new_matiere = $_POST['matieres'];
        $vh_1ere = $_POST['vh_1ere'];
        $vh_2eme = $_POST['vh_2eme'];
        $coefficient = $_POST['coefficient'];
        $niveau = $_POST['niveau'];

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Update the programme_groupes table first
            $stmt1 = $conn->prepare("UPDATE programme_groupes SET matieres=? WHERE matieres=?");
            $stmt1->bind_param("ss", $new_matiere, $old_matiere);
            $stmt1->execute();

            // Update the other tables
            $stmt2 = $conn->prepare("UPDATE suivi_formations SET matiere=? WHERE matiere=?");
            $stmt2->bind_param("ss", $new_matiere, $old_matiere);
            $stmt2->execute();

            $stmt3 = $conn->prepare("UPDATE vacations SET matiere=? WHERE matiere=?");
            $stmt3->bind_param("ss", $new_matiere, $old_matiere);
            $stmt3->execute();

            $stmt4 = $conn->prepare("UPDATE programme_formation SET matieres=?, VH_1ere=?, VH_2eme=?, coefficient=?, niveau=? WHERE matieres=?");
            $stmt4->bind_param("ssssss", $new_matiere, $vh_1ere, $vh_2eme, $coefficient, $niveau, $old_matiere);
            $stmt4->execute();
            
            $conn->commit();

            echo '<span id="successMessage" class="success-message">Formation modifiée avec succès!</span><br>';
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();
            echo '<span id="errorMessage" class="error-message">Erreur lors de la modification de la formation: ' . $e->getMessage() . '</span><br>';
        }
    } elseif (!isset($_POST['form_type']) || $_POST['form_type'] == 'select') {
        $selected_formation_id = $_POST['formation_id'];
        $sql_select_old_values = "SELECT * FROM programme_formation WHERE matieres = ?";
        $stmt_old_values = $conn->prepare($sql_select_old_values);
        $stmt_old_values->bind_param("s", $selected_formation_id);
        $stmt_old_values->execute();
        $result_old_values = $stmt_old_values->get_result();
        if($result_old_values->num_rows > 0) {
            $row_old = $result_old_values->fetch_assoc();
        }
    }
}

$sql = "SELECT matieres, niveau, VH_1ere, VH_2eme, (VH_1ere + VH_2eme) AS masse_horaire_globale, coefficient, 
CAST(SUBSTRING(matieres, 3, LENGTH(matieres) - 2) AS UNSIGNED) AS uf_number 
FROM programme_formation 
ORDER BY uf_number ASC, date_creation ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<title>Update Formation</title>
<style>
    /* Reset some default styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
        font-weight: 500;
        text-decoration: none;
    }
    body {
        background-color: #166d3b;
        background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
        margin: 0;
        height:100vh;
        padding: 50px 0px;
    }
    .container {
        max-width: 70%;
        margin: 50px auto;
        background-color: #fff;
        padding: 50px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        margin-bottom: 20px;
        color: #333;
    }
    form {
        width: 100%;
    }
    label {
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    }
    .hrefs {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hrefs a {
        margin: 20px;
    }
    .btn {
        display: flex;
        align-items: center;
    }
    .btn a {
        margin-right: 10px;
        text-decoration: none;
        color: #01418f;
        transition: ease-in-out 0.1s;
    }
    .btn a:hover {
        color: #008000;
    }
    select,
    input[type="text"], option,
    button[type="submit"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 16px;
    }
    button[type="submit"] {
        background: #ffc107;
        color: #000;
        border: none;
        cursor: pointer;
        transition: ease-in-out 0.3s;
    }
    button[type="submit"]:hover {
        box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
    }

    .success-message {
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        padding: 10px;
        display: block;
    }
    .hidden {
        opacity: 0;
    }
    .return {
        text-decoration: none;
        position: relative; 
        float:right;
        margin-right: 10px;
        color: #fff;
        transition: all 0.3s ease;
    }

    .return::after {
        text-decoration:none;
        content: "";
        position: absolute;
        bottom: -5px; /* Adjust as needed */
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #fff; /* Underline color */
        transform: scaleX(0); /* Initial scale to hide */
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }
    .return:hover::after {
        transform: scaleX(1);
        transform-origin: bottom right;
    }
    .return:hover{
        color: #fff;
    }
</style>
</head>
<body>
<div class='float-end mb-3'>
    <a href="dashboard_formation.php" class="return"><i class="fa-solid fa-arrow-left"></i>&nbsp;Retour au tableau de bord</a>
</div>
<div class="container">
    <h2>Modifier Unité de Formation</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="form_type" value="select">
        <label for="formation_id">Sélectionner une formation à modifier:</label>
        <select name="formation_id" id="formation_id" onchange="this.form.submit()">
            <option value="">Sélectionnez une formation</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='". $row["matieres"] . "' " . ($row["matieres"] == $selected_formation_id ? "selected" : "") . ">". $row["matieres"] ."</option>";
                }
            }
            ?>
        </select>
    </form>

    <?php if (!empty($row_old)) : ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="hidden" name="form_type" value="update">
        <input type="hidden" name="formation_id" value="<?php echo htmlspecialchars($selected_formation_id); ?>">

        <label for="matieres">Nouvelle matière:</label>
        <input type="text" id="matieres" name="matieres" value="<?php echo htmlspecialchars($row_old['matieres']); ?>" required>

        <label for="vh_1ere">VH 1ère année:</label>
        <input type="text" id="vh_1ere" name="vh_1ere" value="<?php echo htmlspecialchars($row_old['VH_1ere']); ?>" required>

        <label for="vh_2eme">VH 2ème année:</label>
        <input type="text" id="vh_2eme" name="vh_2eme" value="<?php echo htmlspecialchars($row_old['VH_2eme']); ?>" required>

        <label for="coefficient">Coefficient:</label>
        <input type="text" id="coefficient" name="coefficient" value="<?php echo htmlspecialchars($row_old['coefficient']); ?>" required>

        <label for="niveau">Niveau:</label>
        <input type="text" id="niveau" name="niveau" value="<?php echo htmlspecialchars($row_old['niveau']); ?>" required>

        <button type="submit">Mettre à jour</button>
    </form>
    <?php endif; ?>
</div>
<script>
    setTimeout(function() {
        const successMessage = document.getElementById("successMessage");
        if (successMessage) {
            successMessage.classList.add("hidden");
        }
    }, 5000);
</script>
</body>
</html>

<?php
$conn->close();
?>
