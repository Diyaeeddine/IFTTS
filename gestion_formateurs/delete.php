<?php
if (isset($_GET["CIN"])) {
    $CIN = $_GET["CIN"];

    include 'connection.php';

    // Commencer une transaction
    $conn->begin_transaction();

    try {
        // Supprimer les enregistrements dans les tables relationnelles et dépendantes
        $sql1 = "DELETE FROM formateurs_matieres WHERE CIN_formateur = '$CIN'";
        $conn->query($sql1);

        $sql2 = "DELETE FROM suivi_formations WHERE CIN = '$CIN'";
        $conn->query($sql2);

        $sql3 = "DELETE FROM programme_groupes WHERE CIN_formateur = '$CIN'";
        $conn->query($sql3);

        $sql4 = "DELETE FROM vacations WHERE CIN = '$CIN'";
        $conn->query($sql4);

        // Supprimer le formateur
        $sql5 = "DELETE FROM formateurs WHERE CIN = '$CIN'";
        $conn->query($sql5);

        // Commit transaction
        $conn->commit();

        header("Location: liste_formateurs.php?msg=Success");
        exit();
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();

        header("Location: liste_formateurs.php?msg=Error");
        exit();
    }

    $conn->close();
} else {
    header("Location: liste_formateurs.php");
    exit();
}
?>
