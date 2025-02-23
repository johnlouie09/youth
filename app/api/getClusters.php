<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT id, name FROM clusters ORDER BY id";
    $result = $conn->query($query);

    if ($result) {
        $clusters = [];
        while ($row = $result->fetch_assoc()) {
            $clusters[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $clusters]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to fetch clusters']);
    }
}
