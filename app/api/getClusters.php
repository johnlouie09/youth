<?php

require_once '../../app/config/database.php';

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow GET, POST, OPTIONS
header("Access-Control-Allow-Headers: Content-Type, x-requested-with"); // Allow the necessary headers




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
