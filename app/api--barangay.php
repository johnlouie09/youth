<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Barangay.php';
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ . '/models/Announcement.php';
require_once __DIR__ . '/models/Achievement.php';
require_once __DIR__ . '/models/Cluster.php';
require_once __DIR__ . '/models/AnnouncementDateTime.php';
require_once __DIR__ . "/models/AnnouncementImage.php";


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
    // Ensure announcement data exists
    if (empty($_POST['announcementInfo'])) {
        returnError('Invalid announcement information received.', 400);
    }

    $announcementInfo = is_array($_POST['announcementInfo']) 
        ? $_POST['announcementInfo'] 
        : json_decode($_POST['announcementInfo'], true);

    if (json_last_error() !== JSON_ERROR_NONE || !$announcementInfo) {
        returnError('Invalid announcement information format.', 400);
    }

    // ✅ Required fields
    $requiredFields = ['barangay_id', 'title', 'description'];
    foreach ($requiredFields as $field) {
        if (empty($announcementInfo[$field]) || trim($announcementInfo[$field]) === '') {
            returnError(ucfirst(str_replace('_', ' ', $field)) . ' is required.', 400);
        }
    }

    // Validate datetimes - at least one datetime is required
    if (!isset($announcementInfo['datetimes']) || !is_array($announcementInfo['datetimes']) || empty($announcementInfo['datetimes'])) {
        returnError('At least one datetime is required for the announcement.', 400);
    }

    foreach ($announcementInfo['datetimes'] as $index => $datetime) {
        if (empty($datetime['date'])) returnError("Date is required for datetime entry " . ($index + 1) . ".", 400);
        if (empty($datetime['start'])) returnError("Start time is required for datetime entry " . ($index + 1) . ".", 400);
        if (empty($datetime['end'])) returnError("End time is required for datetime entry " . ($index + 1) . ".", 400);
    }

    $announcementInfo['is_featured'] = $announcementInfo['is_featured'] ?? 0;

    try {
        // Create new Announcement instance
        $announcement = new Announcement();

        // Set core fields
        $announcement->setBarangayId($announcementInfo['barangay_id']);
        $announcement->setTitle(trim($announcementInfo['title']));
        $announcement->setDescription(trim($announcementInfo['description']));
        $announcement->setIsFeatured((int) $announcementInfo['is_featured']);

        // ✅ Optional fields
        if (isset($announcementInfo['what'])) $announcement->setWhat($announcementInfo['what']);
        if (isset($announcementInfo['who'])) $announcement->setWho($announcementInfo['who']);
        if (isset($announcementInfo['where'])) $announcement->setWhere($announcementInfo['where']);
        if (isset($announcementInfo['why'])) $announcement->setWhy($announcementInfo['why']);

        // ✅ Insert announcement first
        if ($announcement->insert()) {
            $announcementId = $announcement->getId();

            // --- MULTIPLE IMAGE UPLOAD HANDLING ---
            $uploadDir = __DIR__ . '/../public/Announcements/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (!empty($_FILES['files']) && isset($_FILES['files']['name'])) {
                for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                    if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                        $filename = basename($_FILES['files']['name'][$i]);
                        $targetFile = $uploadDir . $filename;

                        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                            $img = new AnnouncementImage();
                            $img->setAnnouncementId($announcementId);
                            $img->setName($filename);
                            $img->insert();
                        } else {
                            error_log("❌ Failed to upload file: " . $_FILES['files']['name'][$i]);
                        }
                    }
                }
            }

            // ✅ Insert datetimes
            $datetimes = $announcementInfo['datetimes'];
            $successfulDatetimes = 0;
            foreach ($datetimes as $dt) {
                $start = strlen($dt['start']) === 5 ? $dt['start'] . ':00' : $dt['start'];
                $end   = strlen($dt['end']) === 5   ? $dt['end']   . ':00' : $dt['end'];

                $adt = new AnnouncementDatetime();
                $adt->setAnnouncementId($announcementId);
                $adt->setDate($dt['date']);
                $adt->setStartTime($start);
                $adt->setEndTime($end);

                if ($adt->insert()) {
                    $successfulDatetimes++;
                }
            }

            returnSuccess([
                'message' => 'Announcement added successfully.',
                'announcement' => $announcement->getAssoc(true),
                'datetimes_added' => $successfulDatetimes,
                'images' => AnnouncementImage::getByAnnouncement($announcementId, true)
            ]);
        } else {
            returnError("Announcement insertion failed.", 500);
        }

    } catch (Exception $e) {
        error_log("Announcement add error: " . $e->getMessage());
        returnError("An error occurred while adding the announcement: " . $e->getMessage(), 500);
    }
}

else if ($action === 'update-announcement') {

    if (!isset($_POST['announcementInfo'])) {
        returnError('Invalid announcement information received.', 400);
    }

    $announcementInfo = is_array($_POST['announcementInfo']) 
        ? $_POST['announcementInfo'] 
        : json_decode($_POST['announcementInfo'], true);

    if (!$announcementInfo) {
        returnError('Invalid announcement information format.', 400);
    }

    // Required fields validation
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

    $announcementInfo['is_featured'] = $announcementInfo['is_featured'] ?? 0;

    try {
        $announcement = new Announcement($announcementInfo['id']);
        
        if (!$announcement->getId()) {
            returnError('Announcement not found.', 404);
        }

        // Set core fields
        $announcement->setBarangayId($announcementInfo['barangay_id']);
        $announcement->setTitle($announcementInfo['title']);
        $announcement->setDescription($announcementInfo['description']);
        $announcement->setIsFeatured($announcementInfo['is_featured']);

        // Optional fields
        if (isset($announcementInfo['what'])) $announcement->setWhat($announcementInfo['what']);
        if (isset($announcementInfo['who'])) $announcement->setWho($announcementInfo['who']);
        if (isset($announcementInfo['where'])) $announcement->setWhere($announcementInfo['where']);
        if (isset($announcementInfo['why'])) $announcement->setWhy($announcementInfo['why']);

        // --- IMAGE HANDLING ---
        $uploadDir = __DIR__ . '/../public/Announcements/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $announcementId = $announcement->getId();
        $existingImages = AnnouncementImage::getByAnnouncement($announcementId, true);

        // ✅ Build set of current image IDs from payload
        $incomingImages = $announcementInfo['images'] ?? [];
        $incomingIds = array_filter(array_map(fn($img) => $img['id'] ?? null, $incomingImages));

        // Delete images not in payload
        foreach ($existingImages as $existing) {
            if (!in_array($existing['id'], $incomingIds)) {
                $imgObj = new AnnouncementImage($existing['id']);
                $imgObj->delete();

                // also delete file from disk (optional)
                $filePath = $uploadDir . $existing['name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // ✅ Handle newly uploaded files
        if (!empty($_FILES['files']) && isset($_FILES['files']['name'])) {
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                    $filename = basename($_FILES['files']['name'][$i]);
                    $targetFile = $uploadDir . $filename;

                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                        $img = new AnnouncementImage();
                        $img->setAnnouncementId($announcementId);
                        $img->setName($filename);
                        $img->insert();
                    } else {
                        error_log("❌ Failed to upload file: " . $_FILES['files']['name'][$i]);
                    }
                }
            }
        }

        // ✅ Update announcement + datetimes
        $datetimes = isset($announcementInfo['datetimes']) && is_array($announcementInfo['datetimes']) 
                    ? $announcementInfo['datetimes'] 
                    : [];

        if ($announcement->updateWithDatetimes($datetimes)) {
            returnSuccess([
                'message' => 'Announcement updated successfully.',
                'announcement' => $announcement->getAssoc(true),
                'images' => AnnouncementImage::getByAnnouncement($announcementId, true)
            ]);
        } else {
            returnError("Announcement update failed. Check server logs.", 500);
        }

    } catch (Exception $e) {
        error_log("Announcement update error: " . $e->getMessage());
        returnError("An error occurred while updating the announcement: " . $e->getMessage(), 500);
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
    $imageDirLocal = __DIR__ . '/../public/achievements';  // Local path
    $imageDirDeployed = __DIR__ . '/../achievements';      // Deployed path

    // Use the directory that exists
    if (is_dir($imageDirLocal)) {
        $imageDir = $imageDirLocal;
    } elseif (is_dir($imageDirDeployed)) {
        $imageDir = $imageDirDeployed;
    } else {
        echo json_encode([]);
        exit;
    }

    // Scan the directory for files and filter to include only image files
    $files = array_filter(scandir($imageDir), function($file) use ($imageDir) {
        $filePath = $imageDir . '/' . $file;
        return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    });

    // Re-index the array and return the result as JSON.
    echo json_encode(array_values($files));
}