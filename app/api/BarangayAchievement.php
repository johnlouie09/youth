<?php

require_once '../../app/config/database.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

// Fetch achievements
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $barangayId = isset($_GET['barangay_id']) ? (int)$_GET['barangay_id'] : null;

    if ($barangayId === null) {
        echo json_encode(['success' => false, 'error' => 'Barangay ID is required']);
        exit;
    }

    $query = "SELECT * FROM achievements WHERE barangay_id = ? ORDER BY date DESC";
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
                'id' => $row['id'],
                'img' => '/public/' . 'ex.jpg', // no img file stored
                'title' => $row['title'],
                'subtitle' => $row['subtitle'],
                'info' => $row['info'],
                'date' => $row['date']
            ];
        }
        echo json_encode(['success' => true, 'data' => $achievements]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to fetch achievements']);
    }
}

// Add new achievement
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    // Ensure all required fields are provided
    if (!isset($input['barangay_id'], $input['title'], $input['subtitle'], $input['info'], $input['img'], $input['date'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }

    $query = "INSERT INTO barangay_achievement (barangay_id, title, subtitle, info, img, date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssss', $input['barangay_id'], $input['title'], $input['subtitle'], $input['info'], $input['img'], $input['date']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Achievement added successfully', 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add achievement']);
    }
}

// Update an existing achievement
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['id'], $input['title'], $input['subtitle'], $input['info'], $input['img'], $input['date'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }

    $query = "UPDATE barangay_achievement SET title = ?, subtitle = ?, info = ?, img = ?, date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $input['title'], $input['subtitle'], $input['info'], $input['img'], $input['date'], $input['id']);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Achievement updated successfully']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update achievement']);
    }
}

// Delete an achievement
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['id'])) {
        echo json_encode(['success' => false, 'error' => 'Achievement ID is required']);
        exit;
    }

    $query = "DELETE FROM barangay_achievement WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $input['id']);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Achievement deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete achievement']);
    }
}
?>
