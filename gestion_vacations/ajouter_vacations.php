<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter des frais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-container {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .form-group {
      flex: 1 1 calc(50% - 1rem);
    }

    .form-group-full {
      flex: 1 1 100%;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php
    include 'connection.php';
    if (isset($_GET['success']) || isset($_GET['error'])) {
      $message = isset($_GET['success']) ? $_GET['success'] : $_GET['error'];
      echo "<div class='alert alert-success' role='alert'>$message</div>";
    }
    ?>
    <div class="container w-75">
      <h2 class="container mt-3 mb-3">Inserer les vacations</h2>
      <form action="traitement.php" method="POST" class="form-container">
        <div class="form-floating mb-3 form-group">
          <select name="CIN" id="CIN" class="form-select" required>
            <option value="">Sélectionner le formateur</option>
            <?php
            $sqlcin = "SELECT * FROM formateurs";
            $result = $conn->query($sqlcin);
            if ($result) {
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['CIN'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                }
              } else {
                echo "<option disabled>Aucun formateur trouvé</option>";
              }
            } else {
              echo "Erreur: " . $conn->error;
            }
            ?>
          </select>
          <label for="CIN">CIN:</label>
        </div>

        <div class="form-floating mb-3 form-group">
          <select class="form-select" id="mois" name="mois" required>
            <option value="">Sélectionner le mois</option>
            <?php
            $mois = array(
              1 => "Janvier",
              2 => "Février",
              3 => "Mars",
              4 => "Avril",
              5 => "Mai",
              6 => "Juin",
              7 => "Juillet",
              8 => "Août",
              9 => "Septembre",
              10 => "Octobre",
              11 => "Novembre",
              12 => "Décembre"
            );

            foreach ($mois as $numMois => $nomMois) {
              echo "<option value='$nomMois'>$nomMois</option>";
            }
            ?>
          </select>
          <label for="mois">Le mois</label>
        </div>

        <div class="form-floating mb-3 form-group">
          <?php
          $sqlG = "SELECT N_Groupe FROM groupes GROUP BY N_Groupe ORDER BY N_Groupe ASC";
          $result = $conn->query($sqlG);
          ?>
          <select name="N_Groupe" id="N_Groupe" class='form-select' required>
            <?php if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['N_Groupe'] . "'>Groupe " . $row['N_Groupe'] . "</option>";
              }
            } else {
              echo "<option disabled>Aucun groupe trouvé</option>";
            }
            ?>
          </select>
          <label for="N_Groupe">Groupe</label>
        </div>

        <div class="form-floating mb-3 form-group">
          <select name="Niveau" id="Niveau" class='form-select' required>
            <option value='1'>1ère année</option>
            <option value='2'>2ème année</option>
          </select>
          <label for="Niveau">Niveau</label>
        </div>

        <div class="form-floating mb-3 form-group-full">
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder=" " required>
          <label for="nombre">Le nombre des heures</label>
        </div>

        <div class="form-floating mb-3 form-group">
          <input type="text" class="form-control" id="Taux" name="Taux" value="105.6" placeholder=" ">
          <label for="Taux">Taux</label>
        </div>

        <div class="form-floating mb-3 form-group">
          <input type="text" class="form-control" id="pourceir" name="pourceir" value="30" placeholder=" ">
          <label for="pourceir">Pourcentage IR</label>
        </div>

        <button type="submit" class="btn btn-primary w-25 mb-5 form-group-full">Inserer la vacation</button>
      </form>
    </div>
  </div>
  <script>
    document.querySelectorAll('#CIN, #mois, #N_Groupe, #Niveau').forEach(element => {
      element.addEventListener('change', fetchHours);
    });

    async function fetchHours() {
      const CIN = document.getElementById('CIN').value;
      const mois = document.getElementById('mois').value;
      const N_Groupe = document.getElementById('N_Groupe').value;
      const Niveau = document.getElementById('Niveau').value;

      if (CIN && mois && N_Groupe && Niveau) {
        const response = await fetch('fetch_hours.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            CIN: CIN,
            mois: mois,
            N_Groupe: N_Groupe,
            Niveau: Niveau
          })
        });

        const result = await response.json();
        document.getElementById('nombre').value = result.nombre;
      }
    }
  </script>
</body>

</html>
