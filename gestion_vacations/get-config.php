<?php
include 'connection.php';
$sql = "SELECT Taux, IR FROM config LIMIT 1";
$result = $conn->query($sql);

$config = array();
if ($result->num_rows > 0) {
    $config = $result->fetch_assoc();
} else {
    $config = array("Taux" => null, "IR" => null);
}

$conn->close();
echo json_encode($config);
?>
