<?php
include 'connection.php'; // Inclure votre fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_src'])) {
    $CIN = $_POST['CIN'];
    $target_dir = "telechargements/";

    // Assurez-vous que le dossier telechargements existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Calculer le hachage du fichier téléchargé
    $temp_file = $_FILES["image_src"]["tmp_name"];
    $uploaded_file_hash = md5_file($temp_file);

    // Vérifier si un fichier avec le même hachage existe déjà
    $existing_file = null;
    foreach (glob($target_dir . "*") as $file) {
        if (md5_file($file) == $uploaded_file_hash) {
            $existing_file = $file;
            break;
        }
    }

    // Si un fichier identique existe, utilisez ce fichier
    if ($existing_file) {
        $target_file = $existing_file;
    } else {
        // Sinon, téléchargez le nouveau fichier
        $filename = pathinfo($_FILES["image_src"]["name"], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES["image_src"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $filename . '_' . time() . '.' . $extension;

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifiez si le fichier image est une image réelle ou une fausse image
        $check = getimagesize($_FILES["image_src"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifiez la taille du fichier
        if ($_FILES["image_src"]["size"] > 5000000) { // 5MB
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichier
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifiez si $uploadOk est mis à 0 par une erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";
            exit;
        } else {
            if (!move_uploaded_file($_FILES["image_src"]["tmp_name"], $target_file)) {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                exit;
            }
        }
    }

    // Mettez à jour la base de données avec le chemin de l'image
    $sql = "UPDATE formateurs SET image_src = ? WHERE CIN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $target_file, $CIN);
    if ($stmt->execute()) {
        echo "Le fichier " . htmlspecialchars(basename($_FILES["image_src"]["name"])) . " a été téléchargé.";
        header("Location: details.php?CIN=" . $CIN); // Redirige vers la page de détails du formateur
        exit;
    } else {
        echo "Erreur lors de la mise à jour de la base de données.";
    }
}
?>
