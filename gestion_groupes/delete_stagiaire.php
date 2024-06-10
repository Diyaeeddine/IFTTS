<?php
include "connection.php";

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="DELETE FROM stagiaires where id='$id'";
    $result=$conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        header("Location: liste_stagiaires.php?msg=Success");
        exit();
    } else {
        header("Location: liste_stagiaires.php?msg=Error");
        exit();
    }

    $conn->close();
} else {
    header("Location: liste_stagiaires.php");
    exit();
}

?>