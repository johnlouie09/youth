<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Barangay.php';
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ . '/models/Announcement.php';
/** Extract Action */
$action = $_GET['a'] ?? '';

if($action === 'fetchBarangays')
{
    $clusters = new Cluster();
    returnSuccess([
        'clusters' => $clusters->all(true)
    ]);
}
else if($action === 'barangayInfo') {
    $barangaySlug = $_POST['barangaySlug'];
    $barangay = Barangay::findBy('slug',$barangaySlug);
    returnSuccess([
        'barangayInfo' => $barangay->getAssoc(true),
    ]);
}
else if($action === 'barangay-dashboard') {
    returnSuccess([
        'SkOfficialCount' => $SKOfficialsCount = SkOfficial::getPositionCount( $_POST['barangaySlug'])
    ]);
}
else if($action === 'sk-officials') {
    $barangay_id = $_POST['barangayId'] ?? '';
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'skChairman' => $barangay->getSkChairman(true),
        'skMembers' => $barangay->getSkMembers(true, true)
    ]);
}
else if($action === 'achievements') {
    $barangay_id = $_POST['barangayId'] ?? '';
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'achievements' => $barangay->getAllAchievements(true, false),
    ]);
}
else if($action === 'announcements') {
    $barangay_id = $_POST['barangayId'] ?? '';
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'announcements' => $barangay->getAnnouncements(true, false),
    ]);
}

else if ($action === 'add-announcement') {
    // Ensure announcement data exists.
    if (!isset($_POST['announcementInfo'])) {
        returnError('Invalid announcement information received.', 400);
    }

    // Decode the JSON data (if not already an array).
    $announcementInfo = is_array($_POST['announcementInfo']) ? $_POST['announcementInfo'] : json_decode($_POST['announcementInfo'], true);
    if (!$announcementInfo) {
        returnError('Invalid announcement information format.', 400);
    }

    // Ensure that a barangay ID is provided.
    if (!isset($announcementInfo['barangay_id'])) {
        returnError('Barangay ID is required.', 400);
    }

    $announcement = new Announcement();

    // Set the barangay ID.
    $announcement->setBarangayId($announcementInfo['barangay_id']);

    // Process file upload if a file was provided.
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as needed).
        $uploadDir = __DIR__ . '/../public/announcements/';
        // Create the directory if it doesn't exist.
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        // Sanitize the filename.
        $filename = basename($_FILES['file']['name']);
        // Set the target file path.
        $targetFile = $uploadDir . $filename;
        // Move the uploaded file.
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $announcement->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($announcementInfo['img'])) {
        // If no file was uploaded, use the provided image value if any.
        $announcement->setImg($announcementInfo['img']);
    }

    // Insert the new announcement.
    if ($announcement->insert()) {
        returnSuccess([
            'message' => 'Announcement added successfully.',
            'announcement' => $announcement->getAssoc()
        ]);
    } else {
        returnError("Announcement insertion failed.", 500);
    }
}

else if ($action === 'delete-announcement') {
    // Ensure the announcement ID is provided
    if (!isset($_POST['id'])) {
        returnError('Announcement ID is required.', 400);
    }
    
    $announcementId = $_POST['id'];
    
    // Fetch the announcement from the database using the provided ID
    $announcement = Announcement::findBy('id', $announcementId);
    
    if (!$announcement) {
        returnError("No announcement found with ID $announcementId", 404);
    }
    
    // Attempt to delete the announcement
    if ($announcement->delete()) {
        returnSuccess([
            'message' => 'Announcement deleted successfully.'
        ]);
    } else {
        returnError("Failed to delete announcement. No changes detected or an error occurred.", 500);
    }
}