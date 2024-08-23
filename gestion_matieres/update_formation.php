<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
        /* padding-bottom: 400px; */
        margin: 0;
        padding: 50px 0px;
    }
    .container {    
            max-width: 70%;
        margin: 100px 0px;

        margin: 20px auto;
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
        color: #fff;
        transition: all 0.3s ease;
        /* margin-left: 1250px; */
    }

    .return::after {
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
</style>
</head>
<body>

    <a href="dashboard_formation.php" class="return"><i class="fa-solid fa-arrow-left"></i>&nbsp;Retour au tableau de bord</a>
    <div class="container">
        <h2>Update Unité de Formation</h2>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "iftts";

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8mb4"); // Set encoding to utf8mb4

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] == 'update') {
            $formation_id = $_POST['formation_id'];

            // Fetch old values based on selected formation ID
            $sql_select_old_values = "SELECT matieres, VH_1ere, VH_2eme, coefficient, niveau FROM programme_formation WHERE matieres = ?";
            $stmt_old_values = $conn->prepare($sql_select_old_values);
            $stmt_old_values->bind_param("s", $formation_id);
            $stmt_old_values->execute();
            $result_old_values = $stmt_old_values->get_result();

            // Check if old values exist
            if($result_old_values->num_rows > 0) {
                $row_old = $result_old_values->fetch_assoc();

                // Check each form field and use old value if empty
                $matieres = empty($_POST['matieres']) ? $row_old['matieres'] : $_POST['matieres'];
                $vh_1ere = empty($_POST['vh_1ere']) ? $row_old['VH_1ere'] : $_POST['vh_1ere'];
                $vh_2eme = empty($_POST['vh_2eme']) ? $row_old['VH_2eme'] : $_POST['vh_2eme'];
                $coefficient = empty($_POST['coefficient']) ? $row_old['coefficient'] : $_POST['coefficient'];
                $niveau = empty($_POST['niveau']) ? $row_old['niveau'] : $_POST['niveau'];

                // Prepare and execute the update query
                $sql_update = "UPDATE programme_formation SET matieres=?, VH_1ere=?, VH_2eme=?, coefficient=?, niveau=? WHERE matieres=?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssssss", $matieres, $vh_1ere, $vh_2eme, $coefficient, $niveau, $formation_id);

                if ($stmt_update->execute()) {
                    echo '<span id="successMessage" class="success-message">Formation modifiée avec succès!</span><br>';
                } else {
                    echo '<span id="errorMessage" class="error-message">Erreur lors de la modification de la formation: ' . $stmt_update->error . '</span><br>';
                }

                $stmt_update->close();
            } else {
                echo '<span id="errorMessage" class="error-message">Erreur: ID de formation introuvable.</span><br>';
            }
        }

        $sql = "SELECT matieres, VH_1ere, VH_2eme, coefficient, niveau FROM programme_formation";
        $result = $conn->query($sql);
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="formation_id">Sélectionnez une formation à modifier:</label>
            <select id="formation_id" name="formation_id" onchange="document.getElementById('form_type').value='select'; this.form.submit();">
                <option value="">Sélectionnez une formation</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = (isset($_POST['formation_id']) && $_POST['formation_id'] == $row['matieres']) ? 'selected' : '';
                        echo "<option value='" . $row['matieres'] . "' $selected>" . $row['matieres'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <?php
            // Fetch old values based on selected formation ID
            if(isset($_POST['formation_id']) && (!isset($_POST['form_type']) || $_POST['form_type'] == 'select')) {
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
            ?>

            <label for="matieres">Nouveau nom de la formation:</label>
            <input type="text" id="matieres" name="matieres" value="<?php echo isset($row_old['matieres']) ? htmlspecialchars($row_old['matieres']) : ''; ?>"><br><br>

            <label for="vh_1ere">Volume Horaire 1ère Année:</label>
            <input type="text" id="vh_1ere" name="vh_1ere" value="<?php echo isset($row_old['VH_1ere']) ? htmlspecialchars($row_old['VH_1ere']) : ''; ?>"><br><br>

            <label for="vh_2eme">Volume Horaire 2ème Année:</label>
            <input type="text" id="vh_2eme" name="vh_2eme" value="<?php echo isset($row_old['VH_2eme']) ? htmlspecialchars($row_old['VH_2eme']) : ''; ?>"><br><br>

            <label for="coefficient">Coefficient:</label>
            <input type="text" id="coefficient" name="coefficient" value="<?php echo isset($row_old['coefficient']) ? htmlspecialchars($row_old['coefficient']) : ''; ?>"><br><br>

            <label for="niveau">Niveau:</label>
            <select id="niveau" name="niveau">
                <option value="" disabled>Choisissez le niveau</option>
                <option value="1ér Année" <?php echo isset($row_old['niveau']) && $row_old['niveau'] == '1ér Année' ? 'selected' : ''; ?>>1ér Année</option>
                <option value="2ème Année" <?php echo isset($row_old['niveau']) && $row_old['niveau'] == '2ème Année' ? 'selected' : ''; ?>>2ème Année</option>
                <option value="1ér et 2ème Année" <?php echo isset($row_old['niveau']) && $row_old['niveau'] == '1ér et 2ème Année' ? 'selected' : ''; ?>>1ér et 2ème Année</option>
            </select><br><br>

            <input type="hidden" id="form_type" name="form_type" value="update">
            <button type="submit"><i class="fa-solid fa-pen"></i>&nbsp;Modifier Formation</button>
        </form>

        <div class="hrefs">
            <div class="btn"><a href="dashboard_formation.php">Retour au tableau de bord</a></div>
        </div>

        <?php
        $conn->close();
        ?>
    </div>
</body>
</html>
