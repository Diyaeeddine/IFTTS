
<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trouver vos formateurs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class='m-5 mb-2 d-flex justify-content-between font-weight-bold'>
    <a href="../home/home.php" class='link font-weight-bold'><img src="back.svg" alt="Retour">Retour à la page d'accueil</a>
    <a href="settings.php" class='font-weight-bold'><img src="./settings.svg" alt="Paramètre">Paramètres</a>
  </div>

  <div class='container'>
    <header>
      <h1 class="m-5">Trouver vos formateurs</h1>
    </header>
    <main class="container">
      <form class="row gx-3" action='vacation.php' method='GET'>
        <div class="col-md-3">
          <label for="groupe" class="form-label">Groupe:</label>
          <select name="groupe" id="groupe" class="form-select">
            <option value="0">Sélectionner le groupe</option>
            <?php
              $groupe_request = "SELECT DISTINCT N_Groupe FROM vacations WHERE N_Groupe != '' ORDER BY N_Groupe ASC";
              $result = $conn->query($groupe_request);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['N_Groupe'] . "'>Groupe " . $row['N_Groupe'] . "</option>";
                }
              }
            ?>
          </select>
        </div>
        <div class="col-md-3">
          <label for="Niveau" class="form-label">Niveau:</label>
          <select name="Niveau" id="Niveau" class="form-select">
            <option value="0">Sélectionner le niveau</option>
            <?php
              $annee_request = "SELECT DISTINCT Niveau FROM vacations ORDER BY Niveau ASC";
              $result = $conn->query($annee_request);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['Niveau'] . "'>";
                  echo $row['Niveau'] == 1 ? "1ère année" : $row['Niveau'] . "ème année";
                  echo "</option>";
                }
              }
            ?>
          </select>
        </div>
        <div class="col-md-3">
          <label for="mois" class="form-label">Mois:</label>
          <select name="mois" id="mois" class="form-select">
            <option value="0">Sélectionner le mois</option>
            <?php
              $mois_request = "SELECT DISTINCT mois FROM vacations WHERE mois != ''";
              $result = $conn->query($mois_request);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['mois'] . "'>" . $row['mois'] . "</option>";
                }
              }
            ?>
          </select>
        </div>
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
      </form>
    </main>

    <?php
      $conn->close();
    ?>
  </div>
</body>
</html>
