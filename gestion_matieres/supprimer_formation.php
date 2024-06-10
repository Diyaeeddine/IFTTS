<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<title>Suppression de Formation</title>
<style>
    *{
        margin: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
        font-weight:500;
        text-decoration:none;
        overflow:hidden;
    }
    /* Additional CSS styles for the Suppression de Formation page */

body {
    background-color: #166d3b;
    background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
    padding-bottom:300px;    
    margin-top: 100px;
}

.container {
    width: 50%;
    margin: auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

select, button[type="submit"] {
    width: calc(100% - 16px); /* Adjust for button padding */
    padding: 15px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensure padding is included in width */
}

button[type="submit"] {
    color: #000;
    border: none;
    font-size:15px;
    border-radius: 5px;
    background-color: #ffc107; /* Blue color for submit button */
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #c69500; /* Darker blue color on hover */
}

.error {
    color: #dc3545; /* Red color for error message */
    margin-bottom: 10px;
    text-align: center;
}

.success {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 15px;
}

/* Styles for back buttons */
.hrefs {
    margin-left: 100px;
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
  
    .success {
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Suppression de Formation</h1>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "iftts";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if form data is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $matieres = $_POST['matieres'];

            // Delete formation from the database based on matieres
            $sql_delete = "DELETE FROM programme_formation WHERE matieres='$matieres'";

            if ($conn->query($sql_delete) === TRUE) {
                echo '<div class="success">Formation supprimée avec succès!</div>';
            } else {
                echo '<div class="error">Erreur lors de la suppression de la formation: ' . $conn->error . '</div>';
            }
        }

        $sql = "SELECT matieres FROM programme_formation";
        $result = $conn->query($sql);
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="matieres">Sélectionner une Formation à Supprimer:</label>
            <select id="matieres" name="matieres">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['matieres']."'>".$row['matieres']."</option>";
                    }
                }
                ?>
            </select>
            
            <button type="submit"><i class="fa-solid fa-eraser"></i>&nbsp;Supprimer Formation</button>

            <div class="hrefs">
                <div class="btn"><a href="gestion_formation.php">Retour à la liste des formations</a></div>
                <p>or</p>
                <div class="btn"><a href="dashboard_formation.php">Retour au dashboard page</a></div>
            </div>
        </form>
    </div>
</body>
</html>
