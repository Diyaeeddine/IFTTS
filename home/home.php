<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
    * {
        font-family: "Raleway", sans-serif;
        padding: 0;
        margin: 0;
        text-decoration: none;

    }

    body {
        background-color: #166d3b;
        background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
        background-attachment: fixed;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        overflow: hidden;
        height: 100vh;

    }

    .navbar {
        border: none;
        border-radius: 10px;
        background-color: #fff;
        color: #000;
        font-family: calibri;

        width: 100%;

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

    @media screen and (max-width: 614px) {
        li a {
            display: none;
        }
    }

    @media screen and (max-width: 346px) {
        .logo {
            display: none;
        }

    }


    li a:hover {
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3), inset 0px -2px 0px rgba(182, 244, 146, 0.8);
    }

    .flexes {
        border: none;
        padding: 20px 0;
        margin-top: 100px;
        border-radius: 10px;
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        align-items: center;
        justify-content: space-evenly;
        background: none;

    }

    .flexes a {
        text-decoration: none;
        color: #000;

    }

    #imgee {
        margin: 0;
        padding: 0;
        vertical-align: middle;
        height: 24px;
        width: 24px;
    }

    .flexes div {

        width: 160px;
        height: 30px;
        border: 1px solid #dedede;
        border-radius: 10px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        text-align: center;
        transition: ease-in-out 0.2s;
    }

    .flexes div:hover {
        box-shadow: rgba(255, 255, 255, 0.35) 0px 5px 15px;

        padding: 10px;
    }

    p {
        color: black;
        transition: ease-in-out 0.1s;
        font-weight: bold;
    }

    img {
        margin: 5px 0 5px 50px;
        width: 70px;
        height: 70px;
    }

    footer {
        background-color: #fff;
        color: #fff;
        padding: 20px;
        text-align: center;
        position: fixed;
        bottom: 0;

        width: 100%;
    }

    img {
        margin: 5px 0 5px 50px;
        width: 70px;
        height: 70px;
    }

    .cont {
        margin-right: 20px;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        /* Initially hidden */
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body>

<nav class="navbar">
        <div class="navdiv">
            <img src="../home/img/logo.svg" alt="">
            <div class="logo">
                <h2>IFTTS AL HOCEIMA</h2>
            </div>
            <ul>
                <li><a href="http://localhost/IFTTS/home/about.php">À propos</a></li>
                <li><a href="./contact.php" class='cont'>Contact</a></li>

            </ul>
        </div>
    </nav>

    <h1></h1>
    <div class="flexes">
        <a href="../gestion_formation/dashboard_formation.php" class="custom-link">
            <div>
                <p><i class="fa-solid fa-school"></i>&nbsp Les matières</p>
            </div>
        </a>

        <a href="../gestion_groupes/liste_groupe.php">
            <div>
                <p><i class="fa-solid fa-people-group"></i>&nbsp Les Groupes</p>
            </div>
        </a>

        <a href="../gestion_formateurs/liste_formateurs.php">
            <div>
                <p><i class="fa-solid fa-graduation-cap"></i>&nbsp Les Formateurs</p>
            </div>
        </a>
        <a href="../gestion_stagiaires/select_groupe.php">
            <div>
                <p><i class="fa-solid fa-graduation-cap"></i>&nbsp Les stagiaires</p>
            </div>
        </a>
        <a href="../gestion_suivi_formation/liste_groupe.php">
            <div>
                <p><img src="./img/tracking.png " id='imgee' alt="">&nbsp Suivi formation</p>
            </div>
        </a>

        <a href="../gestion_vacations/recherche.php">
            <div>
                <p><i class="fa-solid fa-sack-dollar"></i>&nbsp Les vacations</p>
            </div>
        </a>
    </div>

    <footer>
        <p>&copy;IFTTS 2024. Tous les droits sont réservés.</p>
    </footer>
    <div id="loader" class="loader"></div>


</body>

</html>