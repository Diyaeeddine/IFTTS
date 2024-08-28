<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un formateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../home/img/logo.svg" type="image/icon">
    
    <style>
    body, html {
        font-family: poppins, sans-serif;
    }
    .link{
        text-decoration: none;
        font-weight: 500;

    }
    .link:hover{
        text-decoration: underline;

    }
    </style>
</head>

<body>
<div class='m-5' ><a href="liste_formateurs.php" class='link'><img src="back.svg" alt=""> Retour vers la liste</a></div>

    <div class="container-sm w-75 h-100 ">
        <div class='d-flex justify-content-between align-items-center'>
            <div>
                <h2 class="mb-5 text-bold ">Ajouter un formateur</h2>
            </div>
        </div>
        <form action="traitement.php" method="POST">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-3 form-floating">
                        <input type="text" id="CIN" name="CIN" class="form-control" placeholder=" ">
                        <label for="CIN" class="form-label">CIN</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="nom" name="nom" class="form-control" placeholder=" ">
                        <label for="nom" class="form-label">Nom</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder=" ">
                        <label for="prenom" class="form-label">Prénom</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="sexe" id="sexe" class="form-select">
                            <option value="H">Homme</option>
                            <option value="F">Femme</option>
                        </select>
                        <label for="sexe" class="form-label">Sexe</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <select name="Situation_familiale" id="Situation_familiale" class="form-select">
                            <option value="célibataire">Célibataire</option>
                            <option value="marié">Marié</option>
                            <option value="divorcé">Divorcé</option>
                            <option value="veuf">Veuf</option>
                        </select>
                        <label for="Situation_familiale" class="form-label">Situation familiale</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="ville" name="ville" class="form-control" placeholder=" ">
                        <label for="ville" class="form-label">Ville</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="tel" id="telephone" name="telephone" class="form-control" placeholder=" " oninput="formatPhoneNumber(this)">
                        <label for="telephone" class="form-label">Téléphone</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3 form-floating">
                        <input type="email" id="email" name="email" class="form-control" placeholder=" ">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="grade" name="grade" class="form-control" placeholder=" ">
                        <label for="grade" class="form-label">Grade</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="diplome_re" name="diplome_re" class="form-control" placeholder=" ">
                        <label for="diplome_re" class="form-label">Diplôme Re</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="diplome_acces" name="diplome_acces" class="form-control" placeholder=" ">
                        <label for="diplome_acces" class="form-label">Diplôme d'accès</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="date" id="date_naissance" name="date_naissance" class="form-control">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="text" id="rib" name="rib" class="form-control" placeholder=" ">
                        <label for="rib" class="form-label">RIB</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100 p-2 mb-5 fs-5">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
