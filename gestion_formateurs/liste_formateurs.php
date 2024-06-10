<?php 
include 'connection.php';

$nomPrenom = isset($_GET['NomFormateur']) ? $_GET['NomFormateur'] : "";
$selectVille = isset($_GET['selectVille']) ? $_GET['selectVille'] : 0;
$msg = isset($_GET['msg']) ? $_GET['msg'] : "";
$msgupdate = isset($_GET['msgupdate']) ? $_GET['msgupdate'] : "";
$msgAjoute = isset($_GET['msgAjoute']) ? $_GET['msgAjoute'] : "";

$requeteFormateur = "SELECT CIN, nom, prenom, ville, telephone, email 
                    FROM formateurs 
                    WHERE (nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%')";
$requeteCount = "SELECT count(*) FROM formateurs WHERE (nom LIKE '%$nomPrenom%' OR prenom LIKE '%$nomPrenom%')";

if ($selectVille != 0) {
    $requeteFormateur .= " AND ville = '$selectVille'";
    $requeteCount .= " AND ville = '$selectVille'";
}

$requeteFormateur .= " ORDER BY CIN ASC";

$resultatFormateur = $conn->query($requeteFormateur);
$resultatCount = $conn->query($requeteCount);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des formateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        font-family: poppins, sans-serif;
    }
    </style>
</head>

<body>
    <div class="container">
        <?php 
        if (!empty($msg) || !empty($msgupdate) || !empty($msgAjoute)) {
            if ($msg === "Success" || $msgupdate === "success" || $msgAjoute === "Success") {
                echo "<div id='successAlert' class='alert alert-success alert-dismissible fade show' role='alert'>
                        Opération réussie !
                      </div>";                     
            } elseif ($msgupdate === "errorUpdate" || $msgAjoute === "ErrorAjoute") {
                echo "<div id='errorAlert' class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Opération échouée!
                      </div>";
            } elseif ($msgAjoute === "ErrorCINExists") {
                echo "<div id='errorAlert' class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Ce numéro CIN existe déjà.
                      </div>";
            } else {
                echo "<div id='errorAlert' class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Opération échouée!
                      </div>";
            }
            echo "<script>
                    setTimeout(function() {
                        document.getElementById('successAlert').style.display = 'none';
                        document.getElementById('errorAlert').style.display = 'none';
                    }, 3000);
                  </script>";
        }
        ?>
    </div>

    <div class='d-flex align-items-center m-5 justify-content-between'>
        <div class=''>
            <a href="../home/home.php" class='link d-flex'><img src="back.svg" alt="">Retour à la page d'accueil</a>
        </div>
        <div class="btn-container d-flex justify-content-between align-items-center ">
            <a href="./Ajouter_formateurs.php" class="btn btn-success"><img src="person-plus.svg" class="imgsvg"
                    alt="person-plus">Ajouter un formateur</a>
        </div>
    </div>

    <div class="container">
        <div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h1>Liste des formateurs</h1>
            </div>

            <form action="liste_formateurs.php" method="get" class="w-100">
                <div class="input-group w-75 d-flex flex-row ">
                    <div class='w-50'>
                        <input type="text" id="NomFormateur" name="NomFormateur"
                            placeholder='Nom ou prenom du formateur' class="form-control w-100"
                            value="<?php echo htmlspecialchars($nomPrenom); ?>">
                    </div>

                    <div class='ms-1'>
                        <select class="form-select w-100" name="selectVille" id='selectVille'
                            onchange="this.form.submit()">
                            <option selected value="0">Sélectionnez une ville</option>
                            <?php 
                                $sql = "SELECT DISTINCT ville FROM formateurs";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='". htmlspecialchars($row['ville']). "' ";
                                        if ($row['ville'] == $selectVille) {
                                            echo "selected";
                                        }
                                        echo ">" . htmlspecialchars($row['ville']) . "</option>";
                                    }    
                                }
                            ?>
                        </select>
                    </div>
                    <div class='ms-1'>
                        <button type="submit" class="btn btn-warning w-100" data-mdb-ripple-init><img src="search.svg"
                                alt="Rechercher"></button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-4">
                <table class="table ">
                    <thead class="thead">
                        <tr>
                            <th scope="col">CIN</th>
                            <th scope="col">NOM</th>
                            <th scope="col">PRENOM</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col" class="action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    if ($resultatFormateur->num_rows > 0) {
                        while ($row = $resultatFormateur->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["CIN"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo '<td class="tdBtn d-flex flex-nowrap justify-content-around">
                                   <div class=""> <a href="edit.php?CIN=' . htmlspecialchars($row["CIN"]) . '" class="btn btn-warning"><img src="pen.svg" class=""
                                    alt="Modifier"></a></div>
                                    <div> <a href="delete.php?CIN=' . htmlspecialchars($row["CIN"]) . '" class="btn btn-danger" onclick="return confirm(\'Êtes-vous sûr de supprimer ce formateur  [ ' . htmlspecialchars($row["prenom"]) . ' ] ?\')"><img src="trash.svg" class=""
                                    alt="Supprimer"></a></div>
                                    <div> <a href="details.php?CIN=' . htmlspecialchars($row["CIN"]) . '" class="btn btn-secondary"><img src="info.svg" class=""
                                    alt="Details"></a></div>
                                </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'><h4>Aucun formateur trouvé !</h4></td></tr>";
                    }
                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
