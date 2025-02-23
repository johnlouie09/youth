<?php
require_once '../../../app/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Test with cluster_id = 1 (Poblacion Unit)
$cluster_id = 1;

$query = "SELECT * FROM barangays WHERE cluster_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cluster_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $barangays = [];
    while ($row = $result->fetch_assoc()) {
        $barangays[] = $row;
    }
    echo json_encode([
        'success' => true,
        'message' => 'Barangays retrieved successfully',
        'data' => $barangays
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving barangays: ' . $stmt->error
    ]);
}