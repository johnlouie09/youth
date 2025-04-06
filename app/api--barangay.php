<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Barangay.php';
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ . '/models/Announcement.php';
require_once __DIR__ . '/models/Achievement.php';
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
        'SkOfficialCount' => $SKOfficialsCount = SkOfficial::getPositionCount( $_POST['barangaySlug']),
        'reportAchievement' => $BarangayAchievement = Achievement::getMonthlySummary($_POST['barangaySlug']),
        'reportAnnouncement' => $barangayAnnouncement = Announcement::getMonthlySummary($_POST['barangaySlug'], 2025)
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
    
    // Decode JSON data (if not already an array)
    $announcementInfo = is_array($_POST['announcementInfo']) 
        ? $_POST['announcementInfo'] 
        : json_decode($_POST['announcementInfo'], true);
    
    if (!$announcementInfo) {
        returnError('Invalid announcement information format.', 400);
    }
    
    // Ensure that a barangay ID is provided.
    if (!isset($announcementInfo['barangay_id'])) {
        returnError('Barangay ID is required.', 400);
    }
    // Ensure required fields are provided.
    if (!isset($announcementInfo['title']) || trim($announcementInfo['title']) === '') {
        returnError('Announcement title is required.', 400);
    }
    if (!isset($announcementInfo['description']) || trim($announcementInfo['description']) === '') {
        returnError('Announcement description is required.', 400);
    }
    if (!isset($announcementInfo['date']) || trim($announcementInfo['date']) === '') {
        returnError('Announcement date is required.', 400);
    }
    // If is_featured is not provided, default it to 0.
    if (!isset($announcementInfo['is_featured'])) {
        $announcementInfo['is_featured'] = 0;
    }
    
    // Create a new Announcement instance.
    $announcement = new Announcement();
    
    // Set properties from the received data.
    $announcement->setBarangayId($announcementInfo['barangay_id']);
    $announcement->setTitle($announcementInfo['title']);
    $announcement->setDescription($announcementInfo['description']);
    $announcement->setDate($announcementInfo['date']);
    $announcement->setIsFeatured($announcementInfo['is_featured']);
    
    // Process file upload if a file is provided.
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as necessary).
        $uploadDir = __DIR__ . '/../public/announcements/';
        
        // Create the directory if it doesn't exist.
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Sanitize the filename.
        $filename = basename($_FILES['file']['name']);
        
        // Set the target file path (ensure the directory ends with a slash).
        $targetFile = rtrim($uploadDir, '/') . '/' . $filename;
        
        // Move the uploaded file.
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $announcement->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($announcementInfo['img'])) {
        // If no file was uploaded, use the provided image value (if any).
        $announcement->setImg($announcementInfo['img']);
    }
    
    // Attempt to insert the new announcement into the database.
    if ($announcement->insert()) {
        returnSuccess([
            'message' => 'Announcement added successfully.',
            'announcement' => $announcement->getAssoc()
        ]);
    } else {
        returnError("Announcement insertion failed.", 500);
    }
}

else if ($action === 'update-announcement') {
    // Ensure announcement data exists.
    if (!isset($_POST['announcementInfo'])) {
        returnError('Invalid announcement information received.', 400);
    }
    
    // Decode JSON data (if not already an array).
    $announcementInfo = is_array($_POST['announcementInfo']) 
        ? $_POST['announcementInfo'] 
        : json_decode($_POST['announcementInfo'], true);
    
    if (!$announcementInfo) {
        returnError('Invalid announcement information format.', 400);
    }
    
    // Ensure that required fields are provided.
    if (!isset($announcementInfo['id']) || trim($announcementInfo['id']) === '') {
        returnError('Announcement ID is required for update.', 400);
    }
    if (!isset($announcementInfo['barangay_id'])) {
        returnError('Barangay ID is required.', 400);
    }
    if (!isset($announcementInfo['title']) || trim($announcementInfo['title']) === '') {
        returnError('Announcement title is required.', 400);
    }
    if (!isset($announcementInfo['description']) || trim($announcementInfo['description']) === '') {
        returnError('Announcement description is required.', 400);
    }
    if (!isset($announcementInfo['date']) || trim($announcementInfo['date']) === '') {
        returnError('Announcement date is required.', 400);
    }
    // Default is_featured to 0 if not provided.
    if (!isset($announcementInfo['is_featured'])) {
        $announcementInfo['is_featured'] = 0;
    }
    
    // Create an Announcement instance with the given ID.
    $announcement = new Announcement($announcementInfo['id']);
    
    // Set properties from the received data.
    $announcement->setBarangayId($announcementInfo['barangay_id']);
    $announcement->setTitle($announcementInfo['title']);
    $announcement->setDescription($announcementInfo['description']);
    $announcement->setDate($announcementInfo['date']);
    $announcement->setIsFeatured($announcementInfo['is_featured']);
    
    // Process file upload if a file is provided.
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as necessary).
        $uploadDir = __DIR__ . '/../public/announcements/';
        
        // Create the directory if it doesn't exist.
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Sanitize the filename.
        $filename = basename($_FILES['file']['name']);
        
        // Set the target file path.
        $targetFile = rtrim($uploadDir, '/') . '/' . $filename;
        
        // Move the uploaded file.
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $announcement->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($announcementInfo['img'])) {
        // If no file was uploaded, use the provided image value (if any).
        $announcement->setImg($announcementInfo['img']);
    }
    
    // Attempt to update the announcement in the database.
    if ($announcement->update()) {
        returnSuccess([
            'message' => 'Announcement updated successfully.',
            'announcement' => $announcement->getAssoc()
        ]);
    } else {
        returnError("Announcement update failed.", 500);
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

else if ($action === 'image-filenames') {
    // Define the directory containing your images.
    // Adjust the path as necessary (ensure the path is correct relative to this file).
    $imageDir = __DIR__ . '\..\public\achievements';

    // Check if the directory exists.
    if (!is_dir($imageDir)) {
        echo json_encode([]);
        exit;
    }

    // Scan the directory for files and filter to include only image files.
    $files = array_filter(scandir($imageDir), function($file) use ($imageDir) {
        $filePath = $imageDir . '/' . $file;
        return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    });

    // Re-index the array and return the result as JSON.
    echo json_encode(array_values($files));
}