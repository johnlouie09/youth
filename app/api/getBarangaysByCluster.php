<?php
require_once '../../app/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $clusterId = isset($_GET['cluster_id']) ? (int)$_GET['cluster_id'] : null;

    if ($clusterId === null) {
        echo json_encode(['success' => false, 'error' => 'Cluster ID is required']);
        exit;
    }

    $query = "SELECT id, name, img FROM barangays WHERE cluster_id = ? ORDER BY name";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $clusterId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $barangays = [];
        while ($row = $result->fetch_assoc()) {
            $barangays[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $barangays]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to fetch barangays']);
    }
}