<?php 
include 'connection.php';

// Validate and sanitize GET parameters
$Num_S = isset($_GET['Num_S']) ? (int) $_GET['Num_S'] : NULL;
$N_Groupe = isset($_GET['N_Groupe']) ? (int) $_GET['N_Groupe'] : 0;
$Niveau = isset($_GET['Niveau']) ? (int) $_GET['Niveau'] : 0;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$matiere = isset($_GET['matiere']) ? mysqli_real_escape_string($conn, $_GET['matiere']) : '';

// Use prepared statements to fetch the student's grades
$stmt = $conn->prepare("SELECT note1, note2, note3 FROM resultats WHERE id_S = ? AND matiere = ? AND N_Groupe= ? AND Niveau= ?");
$stmt->bind_param("isii", $id, $matiere, $N_Groupe, $Niveau);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt2 = $conn->prepare("SELECT * FROM stagiaires WHERE id = ? AND Num_S=?");
$stmt2->bind_param("ii", $id, $Num_S);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();

$stmt->close();
$stmt2->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">

    <style>
        form {
            width: 75%;
            padding: 20px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        input[type="text"] {
            width: 70%;
            height: 30px;
        }

        .inp {
            display: flex;
            align-items: center;
            margin: 0 !important;
        }

        .infos {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
            margin-bottom: 30px;
        }

        .infos tr,
        .infos td,
        .infos th {
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
        }

        .btn {
            width: 25%;
        }

        .link {
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .form-control {
            border: 2px solid grey;
        }
    </style>
</head>

<body>
    <div class="d-flex align-items-center m-5 justify-content-between">
        <div><a href="./resultats.php?N_Groupe=<?php echo $N_Groupe ?>&Niveau=<?php echo $Niveau ?>&id=<?php echo $id ?>&Num_S=<?php echo $Num_S ?>" class='link'>
                <img src="back.svg" alt="">Retour</a></div>
        <table>
            <tr>
                <th>Niveau :</th>
                <td><?php echo ($Niveau == 1) ? "$Niveau"."<sup>ère</sup> année" : "$Niveau"."ème année"; ?></td>
            </tr>
            <tr>
                <th>N° de stagiaire : </th>
                <td><?php echo htmlspecialchars($id); ?></td>
            </tr>
            <tr>
                <th>Nom et Prénom : </th>
                <td><?php echo htmlspecialchars($row2['nom'] . ' ' . $row2['prenom']); ?></td>
            </tr>
        </table>
    </div>

    <div class='container'>
        <table class='infos'>
            <tr>
                <td style='background-color:#e9e9e9;'>La matière</td>
                <th><?php echo htmlspecialchars($matiere); ?></th>
            </tr>
        </table>

        <form action="fillgrades.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="Num_S" id="Num_S" value='<?php echo $Num_S; ?>'>
            <input type="hidden" name="N_Groupe" id="N_Groupe" value='<?php echo $N_Groupe; ?>'>
            <input type="hidden" name="Niveau" id="Niveau" value='<?php echo $Niveau; ?>'>
            <input type="hidden" name="id" id="id" value='<?php echo $id; ?>'>
            <input type="hidden" name="matiere" id="matiere" value='<?php echo htmlspecialchars($matiere); ?>'>

            <div class="form-floating mb-3 inp">
                <input type="text" class="form-control" id="note1" name="note1" value="<?php echo htmlspecialchars($row['note1'] ?? ''); ?>" placeholder=''>
                <label for="note1">Note 1</label>
            </div>
            <div class="form-floating mb-3 inp">
                <input type="text" class="form-control" id="note2" name="note2" value="<?php echo htmlspecialchars($row['note2'] ?? ''); ?>" placeholder=''>
                <label for="note2">Note 2</label>
            </div>
            <div class="form-floating mb-3 inp">
                <input type="text" class="form-control" id="note3" name="note3" value="<?php echo htmlspecialchars($row['note3'] ?? ''); ?>" placeholder=''>
                <label for="note3">Note 3</label>
            </div>
            <button type="submit" class='btn btn-primary'><img src="./save.svg" alt=""> Enregister</button>
        </form>
    </div>

    <script>
        function validateForm() {
            const note1 = document.getElementById('note1').value;
            const note2 = document.getElementById('note2').value;
            const note3 = document.getElementById('note3').value;

            if (isNaN(note1) || isNaN(note2) || isNaN(note3)) {
                alert('Veuillez entrer des valeurs numériques valides pour les notes.');
                return false;
            }
            else{
                if(note1 < 0 || note1 > 20 || note2 < 0 || note2 > 20 || note3 < 0 || note3 > 20){
                    alert('Les notes doivent être compris entre 0 et 20.');
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
