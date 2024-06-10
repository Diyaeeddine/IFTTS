<?php 
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $N_Groupe = filter_input(INPUT_POST, 'N_Groupe', FILTER_VALIDATE_INT);
    $promotion = filter_input(INPUT_POST, 'promotion', FILTER_SANITIZE_STRING);
    $filiere = filter_input(INPUT_POST, 'filiere', FILTER_SANITIZE_STRING);

    if ($N_Groupe && $promotion && $filiere) {
        $conn->begin_transaction();
        
        try {
            $sqlCheck = "SELECT COUNT(*) AS count FROM groupes WHERE N_Groupe = $N_Groupe";
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                throw new Exception("Le groupe déja existe");
            }

            $sql1 = "INSERT INTO groupes (N_Groupe, Niveau, filiere, promotion) VALUES ($N_Groupe, 1, '$filiere', '$promotion')";
            $sql2 = "INSERT INTO groupes (N_Groupe, Niveau, filiere, promotion) VALUES ($N_Groupe, 2, '$filiere', '$promotion')";

            if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
                $conn->commit();
                header("Location: liste_groupe.php?msgajoute=Success");
                exit(); 
            } else {
                throw new Exception("Erreur d'inserer le groupe");
            }
        } catch (Exception $e) {
            $conn->rollback();
            header("Location: liste_groupe.php?msgajoute=Error&detail=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        $errmsg = 'Veuillez remplir tous les champs obligatoires.';
        header("Location: ajoutergroupe.php?msgmsgajoute=" . urlencode($errmsg));
    }
}
?>
