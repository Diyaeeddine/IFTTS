<?php
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['groupe']) && isset($_GET['N_Groupe']) ) {
    include 'connection.php';

    $N_Groupe = (int)$_GET['N_Groupe'];
    $CIN = $_POST['CIN'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $groupe = (int)$_POST['groupe'];
    $date_N = $_POST['date_N'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $Num_S = $_POST['Num_S'];

    // Assurez-vous que la date est au bon format (YYYY-MM-DD)
    $date_N = date('Y-m-d', strtotime($date_N));

    // Préparez la déclaration SQL avec les types de paramètres corrects
    $sql = $conn->prepare("INSERT INTO stagiaires (Num_S, CIN, nom, prenom, date_N, address, tel, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssssss",$Num_S, $CIN, $nom, $prenom, $date_N, $address, $tel, $email);

    if ($sql->execute()) {
        // Obtenez l'ID inséré en dernier
        $id_stagiaire = $conn->insert_id;

        // Préparez la déclaration SQL pour la table stagiaires_groupes
        $sql2 = $conn->prepare("INSERT INTO stagiaires_groupes (id_stagiaire, N_Groupe, Niveau) VALUES (?, ?, ?)");

        // Insérez pour les deux niveaux 1 et 2
        foreach ([1, 2] as $Niveau) {
            $sql2->bind_param("iii", $id_stagiaire, $N_Groupe, $Niveau);
            if (!$sql2->execute()) {
                $error_msg = "Erreur dans stagiaires_groupes pour Niveau $Niveau : " . $conn->error;
                header("Location: ajouter_stagiaire.php?msg=" . urlencode($error_msg) . "&N_Groupe=" . $N_Groupe);
                $sql2->close();
                $sql->close();
                $conn->close();
                exit();
            }
        }

        $sql2->close();
        header("Location: liste_stagiaires.php?N_Groupe=" . $N_Groupe . "&Niveau=".$Niveau."&msg=success");
    } else {
        $error_msg = "Erreur dans stagiaires : " . $conn->error;
        header("Location: ajouter_stagiaire.php?msg=" . urlencode($error_msg) . "&N_Groupe=" . $N_Groupe."&Niveau= ".$Niveau."");
    }

    $sql->close();
    $conn->close();
} else {
    header("Location: ajouter_stagiaire.php?msg=" . urlencode("Tous les champs sont obligatoires.") . "&N_Groupe=" . $_GET['N_Groupe']);
}
?>
