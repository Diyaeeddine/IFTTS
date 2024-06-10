<?php
include 'connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION['N_Groupe']) && isset($_SESSION['filiere']) && isset($_SESSION['promotion'])) {
        $N_Groupe = $_SESSION['N_Groupe'];
        $filiere = $_SESSION['filiere'];
        $promotion = $_SESSION['promotion'];


        if (isset($_POST['New_N_Groupe']) && isset($_POST['New_promotion']) && isset($_POST['New_filiere'])) {
            $New_N_Groupe = mysqli_real_escape_string($conn, $_POST['New_N_Groupe']);
            $New_promotion = mysqli_real_escape_string($conn, $_POST['New_promotion']);
            $New_filiere = mysqli_real_escape_string($conn, $_POST['New_filiere']);

            $sql = "UPDATE groupes
            SET N_Groupe='$New_N_Groupe',promotion='$New_promotion',filiere='$New_filiere'
            WHERE (N_Groupe='$N_Groupe' OR N_Groupe='$New_N_Groupe')
              AND (promotion='$promotion' OR promotion='$New_promotion')
              AND (filiere='$filiere' OR filiere='$New_filiere')
              ";

            if (mysqli_query($conn, $sql)) {
                header("Location: liste_groupe.php?msg=Success");
                exit();
            } else {
                header("Location: liste_groupe.php?msg=Error");
            }
        } else {
            echo "Tous les champs sont obligatoires.";
        }
    } else {
        echo "<p class='text-center alert alert-danger'>N_Groupe and Niveau not found in session.</p>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
