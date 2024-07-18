<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<title>Dashboard Formation</title>
<style>
* {
    text-decoration: none;
    overflow: hidden;
    margin: 0;
    padding: 0;
    font-family: "Raleway", sans-serif;
}

body {
    background: #166d3b;
    background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
    padding-bottom: 400px;
}

.container {
    max-width: 1200px;
    height: 200px;
    margin: 100px auto;
    padding: 20px;
    border: solid 1px #fff;
    font-weight: bold;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
}

.btn-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.btn {
    padding: 10px 20px;
    background-color: #fff;
    text-decoration: none;
    color: #000;
    border-radius: 5px;
    transition: ease-in-out 0.3s;
    position: relative;
    overflow: hidden;
    display: inline-flex; /* Ensure button takes only necessary width */
    align-items: center;
}

.btn a {
    position: relative;
    color: inherit;
    z-index: 1;
}

.btn::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #0A5C36;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
    z-index: 0;
}

.btn:hover::before {
    transform: scaleX(1);
}

.return {
    float:right;
    padding: 10px 10px;
    background-color: #fff;
    text-decoration: none;
    color: #000;
    border-radius: 5px;
    transition: ease-in-out 0.3s;
    position: relative;
    overflow: hidden;
    display: inline-flex; /* Ensure link takes only necessary width */
    align-items: center;
    justify-content:right;
     /* Center align items vertically */
    white-space: nowrap; /* Prevents text wrapping */
}

.return::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #0A5C36;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
    z-index: 0;
}

.return:hover::before {
    transform: scaleX(1);
}

.navbar {
    border: none;
    border-radius: 10px;
    background-color: #fff;
    color: #000;
    font-family: calibri;
    padding-right: 15px;
    padding-left: 15px;
}

.navdiv {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

li {
    list-style: none;
    display: inline-block;
}

li a {
    border: solid 1px #fff;
    padding: 10px 10px;
    border-radius: 10px;
    color: #000;
    background: #fff;
    font-size: 18px;
    font-weight: bold;
    margin-right: 25px;
    transition: ease-in-out 0.2s;
}

li a:hover {
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3), inset 0px -2px 0px rgba(182, 244, 146, 0.8);
}

footer {
    background-color: #fff;
    color: #000;
    padding: 20px;
    text-align: center;
    position: fixed;
    bottom: 0;
    font-weight: bold;
    width: 100%;
}

h1 {
    margin-bottom: 50px;
}

img {
    margin-left: 50px;
}
.head{
    padding: 10px;
}

</style>
</head>
<body>

<nav class="navbar">
    <div class="navdiv">
        <img src="img/logo_iftts.png" alt="">
        <div class="logo">
            <h2>IFTTS AL HOCEIMA</h2>
        </div>
        <ul>
            <li><a href="../home/about.php">À propos</a></li>
            <li><a href="../home/contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class='head'>
    <a href="../home/home.php" class="return"><i class="fa-solid fa-arrow-left"></i>&nbspRetour à la page d'accueil</a>
    <h1>Page des matières </h1></div>
    <div class="btn-container">
        <a href="liste_formation.php" class="btn" title="Accéder à la gestion des formations qui contient la liste des formation"><i class="fa-solid fa-gears"></i>&nbsp; Gestion matières</a>
        <a href="create_formation.php" class="btn" title="Créer une nouvelle formation en spécifiant les détails et les modules"><i class="fa-solid fa-folder-plus"></i>&nbsp; Créer matières</a>
        <a href="supprimer_formation.php" class="btn" title="Supprimer une formation existante en choisissant parmi la liste"><i class="fa-solid fa-eraser"></i>&nbsp; Supprimer matières</a>
        <a href="update_formation.php" class="btn" title="Modifier une formation existante en apportant des modifications aux détails"><i class="fa-solid fa-pen"></i>&nbsp; Modifier matières</a>
        <a href="filtration.php" class="btn" title="filtrer les resultat"><i class="fa-solid fa-pen"></i>&nbsp; Filtrer les résultats</a>
    </div>
</div>

<footer>
    <p>&copy;IFTTS 2024. Tous les droits sont réservés.</p>
</footer>

</body>
</html>
