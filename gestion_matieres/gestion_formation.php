    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Gestion de Formation</title>
    <style>
       body{
    background:#f0f0f0;
}    
*{
    font-family: "Raleway", sans-serif;
padding:0;
margin:0;
			text-decoration: none;
		}
        body{
            background-color: #166d3b;
background-image: linear-gradient(147deg, #166d3b 0%, #000000 74%);
padding-bottom:400px;
overflow: hidden;
        }
		.navbar{
            border:none;
            border-radius:10px;
            background-color: #fff;
            color:#000;
            font-family: calibri;
            padding-right: 15px;
            padding-left: 15px;
		}
		.navdiv{
			display: flex;
            align-items: center;
            justify-content: space-between;
		}
		
		li{
			list-style: none; 
            display: inline-block;
            
		}
		li a{
            border:solid 1px #fff;
            padding:10px 20px;
            border-radius:10px;
            color:#000;
            background:#fff;
            font-size: 18px; 
            font-weight: bold; 
            margin-right: 25px;
            transition: ease-in-out 0.2s;
		}
        li a:hover{
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3), inset 0px -2px 0px rgba(182, 244, 146, 0.8);
        }
		
        .flexes {
            border:none;
            padding:20px;
            margin-top:100px;
            border-radius:10px;
            display: flex;
            width:90%;
            margin-left:60px;
            align-items:center;
            justify-content: space-around;
            background: none;

        }
        .flexes a {
            text-decoration: none;
            color: #000;

        }
        
        .flexes div {
            
            width: 150px;
            height: 150px;
            border: 1px solid #dedede;
            border-radius:10px;
            background:#fff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            padding:10px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            text-align:center;
            transition:ease-in-out 0.2s;
        }
        .flexes div:hover{
            box-shadow: rgba(255, 255, 255, 0.35) 0px 5px 15px;
            
            padding:10px;
        }
        p{
            color:black;
            transition:ease-in-out 0.1s;
            font-weight:bold;
        }
        
        img{
            margin-left:50px;
        }


footer {
            background-color: #fff;
            color: #000;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            
            width: 100%;
        }

    </style>
    
    </head>
    <body>
    <nav class="navbar">
		<div class="navdiv">
        
        <a href="http://localhost/IFTTS/home/home.php"><img src="img/logo_iftts.png" alt=""></a>

        
        <div class="logo">
        <h2>IFTTS AL HOCEIMA</h2>
        </div>

        	<ul>
				<li><a href="#">Home</a></li>
				<li><a href="http://localhost/IFTTS/home/about.php">About</a></li>
				<li><a href="#">Contact</a></li>

			</ul>
		</div>
</nav>




       <div class="flexes">
        <a href="premiere_annee.php">
        <div><p><i class="fa-solid fa-calendar-days"></i>&nbsp Premiere <br> annee</p></div>
        </a>
        <a href="deuxieme_annee.php">
        <div><p><i class="fa-solid fa-calendar-days"></i>&nbsp deuxieme <br> annee</p></div>
        </a>
        <a href="liste_formation.php">
        <div><p><i class="fa-solid fa-school"></i>&nbsp tout les matiere</p></div>
        </a>
       </div>
       <footer>
<p>&copy;IFTTS 2024. Tous les droits sont réservés.</p>
</footer>
    </body>

    </html>
