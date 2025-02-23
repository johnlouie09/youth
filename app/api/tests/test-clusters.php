<?php
require_once '../../../app/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$query = "SELECT * FROM clusters";
$result = $conn->query($query);

if ($result) {
    $clusters = [];
    while ($row = $result->fetch_assoc()) {
        $clusters[] = $row;
    }
    echo json_encode([
        'success' => true,
        'message' => 'Clusters retrieved successfully',
        'data' => $clusters
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving clusters: ' . $conn->error
    ]);
}

