<?php
include 'connection.php'; 

$data = json_decode(file_get_contents("php://input"), true);
$taux = $data['taux'];
$ir = $data['ir'];

$sql = "UPDATE config SET Taux = ?, IR = ? WHERE id = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dd", $taux, $ir);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Values updated successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update values';
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
