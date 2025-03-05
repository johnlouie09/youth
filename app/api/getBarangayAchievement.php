<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $barangayId = isset($_GET['barangay_id']) ? (int)$_GET['barangay_id'] : null;

    if ($barangayId === null) {
        echo json_encode(['success' => false, 'error' => 'Barangay ID is required']);
        exit;
    }

    $query = "SELECT * FROM barangay_achievement WHERE barangay_id = ? ORDER BY date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $barangayId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $achievements = [];
        while ($row = $result->fetch_assoc()) {
            $year = date('Y', strtotime($row['date']));
            $month = date('F', strtotime($row['date']));
            
            if (!isset($achievements[$year])) {
                $achievements[$year] = [];
            }
            
            if (!isset($achievements[$year][$month])) {
                $achievements[$year][$month] = [];
            }
            
            $achievements[$year][$month][] = [
                'img' => '/public/' . 'ex.jpg',
                'title' => $row['title'],
                'subtitle' => $row['subtitle'],
                'info' => $row['info']
            ];
        }
        echo json_encode(['success' => true, 'data' => $achievements]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to fetch achievements']);
    }
}
