<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ .'/models/Achievement.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

/** Login Request *********************************************/
if ($action === 'login')
{
    // get inputs
    $identifier = $_POST['identifier'] ?? '';
    $password   = $_POST['password']   ?? '';
    $remember   = filter_var($_POST['remember'], FILTER_VALIDATE_BOOLEAN);

    // validate inputs
    if (empty(trim($identifier)) || empty($password)) {
        returnError('Username/Email and password are required.');
    }

    // try to login
    try {
        $sk_official = SkOfficial::login($identifier, $password, $remember);
        require_once __DIR__ . '/models/Barangay.php';
        
        $barangay = $sk_official->getBarangay();
        returnSuccess([
            'sk_official' => $sk_official->getAssoc(true),
            'barangay' => $barangay->getAssoc(true)
        ]);
    }
    catch (Exception $e) {
        returnError($e->getMessage(), 401);
    }
}


/** Session Request *******************************************/
else if ($action === 'session')
{
    $sk_official = SkOfficial::getLoggedIn();
    require_once __DIR__ . '/models/Barangay.php';
    $barangay = $sk_official->getBarangay();


    if ($sk_official === null) {
        returnError('No logged-in SkOfficial.', 401);
    }
    else {
        returnSuccess([
            'sk_official' => $sk_official->getAssoc(true),
            'barangay' => $barangay->getAssoc(true)
        ]);
    }
}

/** Logout Request ********************************************/
else if ($action === 'logout')
{
    // get inputs
    $username = $_POST['username'] ?? '';

    // validate inputs
    if (empty(trim($username))) {
        returnError('Username is required.');
    }

    // proceed to logout
    $sk_official_logged_in = SkOfficial::getLoggedIn();
    if ($sk_official_logged_in !== null) {
        if ($sk_official_logged_in->getUsername() === $username) {
            SkOfficial::logout();
        }
    }
    returnSuccess([
        'logged_out' => true
    ]);
}

else if ($action === 'personalInfo') {
    // Use null coalescing to provide a default value
    $slug = $_POST['officialSlug'] ?? '';
    
    // Validate that a slug was provided
    if (empty(trim($slug))) {
        returnError('Official slug is required.', 400);
    }
    
    $official = SkOfficial::findBy('slug', $slug);
    
    // Validate that an official was found
    if ($official === null) {
        returnError("No official found with slug '$slug'.", 404);
    }
    
    returnSuccess([
        'personalInfo' => $official->getAssoc(),
        'educationalBackgrounds' => $official->getEducations(true),
        'achievements' => $official->getAchievements(true)
    ]);
}

else if ($action === 'updatePersonalInfo') {
    // Ensure data exists
    if (!isset($_POST['personalInfo'])) {
        returnError('Invalid personal information received.', 400);
    }
    
    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $personalInfo = is_array($_POST['personalInfo']) ? $_POST['personalInfo'] : json_decode($_POST['personalInfo'], true);
    
    if (!$personalInfo) {
        returnError('Invalid personal information format.', 400);
    }
    
    // Ensure ID exists
    if (!isset($personalInfo['id'])) {
        returnError('Official ID is required.', 400);
    }
    
    // Fetch official from database
    $official = SkOfficial::findBy('id', $personalInfo['id']);
    
    if (!$official) {
        returnError("No official found with ID " . $personalInfo['id'], 404);
    }
    
    // Update fields if provided
    if (isset($personalInfo['full_name'])) {
        $official->setFullName($personalInfo['full_name']);
    }
    if (isset($personalInfo['email'])) {
        $official->setEmail($personalInfo['email']);
    }
    if (isset($personalInfo['contact_number'])) {
        $official->setContactNumber($personalInfo['contact_number']);
    }
    if (isset($personalInfo['birthday'])) {
        $official->setBirthday($personalInfo['birthday']); // Ensure correct format (YYYY-MM-DD)
    }
    if (isset($personalInfo['term_start'])) {
        $official->setTermStart($personalInfo['term_start']); // Ensure correct format
    }
    if (isset($personalInfo['term_end'])) {
        $official->setTermEnd($personalInfo['term_end']); // Ensure correct format
    }
    if (isset($personalInfo['motto'])) {
        $official->setMotto($personalInfo['motto']);
    }
    
    // Process file upload if a file was provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as needed)
        $uploadDir = __DIR__ . '/../public/OfficialImages/'; 
        
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Get a sanitized version of the filename
        $filename = basename($_FILES['file']['name']);
        
        // Set the target file path
        $targetFile = $uploadDir . $filename;
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Update the official record with the new filename
            $official->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($personalInfo['img'])) {
        // If no new file is uploaded, update with the provided img value if any
        $official->setImg($personalInfo['img']);
    }
    
    // Execute update
    if ($official->update()) {
        returnSuccess([
            'message' => 'Personal information updated successfully.',
            'personalInfo' => $official->getAssoc()
        ]);
    } else {
        returnError("Update failed. No changes detected or an error occurred.", 500);
    }
}

else if ($action === 'updateAchievement') {
    // Ensure data exists
    if (!isset($_POST['achievementInfo'])) {
        returnError('Invalid Achievement Information Received.', 400);
    }

    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $achievementInfo = is_array($_POST['achievementInfo']) 
        ? $_POST['achievement'] 
        : json_decode($_POST['achievementInfo'], true);

    if (!$achievementInfo) {
        returnError('Invalid Achievement Information Format.', 400);
    }

    // Ensure ID exists
    if (!isset($achievementInfo['id'])) {
        returnError('Achievement ID is required.', 400);
    }

    // Fetch Achievement from database
    $achievement = Achievement::findBy('id', $achievementInfo['id']);

    if (!$achievement) {
        returnError("No achievement found with ID " . $achievementInfo['id'], 404);
    }

    // Update fields if provided
    if (isset($achievementInfo['title'])) {
        $achievement->setTitle($achievementInfo['title']);
    }
    if (isset($achievementInfo['subtitle'])) {
        $achievement->setSubtitle($achievementInfo['subtitle']);
    }
    if (isset($achievementInfo['info'])) {
        $achievement->setInfo($achievementInfo['info']);
    }
    if (isset($achievementInfo['date'])) {
        $achievement->setDate($achievementInfo['date']); // Ensure correct format (e.g., YYYY-MM-DD)
    }

    // Process file upload if a file was provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as needed)
        $uploadDir = __DIR__ . '/../public/achievements/'; 
        
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Get a sanitized version of the filename
        $filename = basename($_FILES['file']['name']);
        
        // Set the target file path
        $targetFile = $uploadDir . $filename;
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Update the achievement record with the new filename
            $achievement->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($achievementInfo['img'])) {
        // If no new file is uploaded, update with the provided img value if any
        $achievement->setImg($achievementInfo['img']);
    }

    // Execute update
    if ($achievement->update()) {
        returnSuccess([
            'message' => 'Achievement updated successfully.',
            'achievement' => $achievement->getAssoc()
        ]);
    } else {
        returnError("Update failed. No changes detected or an error occurred.", 500);
    }
}

else if($action === 'addAchievement') {
    // Ensure achievement data exists
    if (!isset($_POST['achievementInfo'])) {
        returnError('Invalid Achievement Information Received.', 400);
    }
    
    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $achievementInfo = is_array($_POST['achievementInfo']) 
        ? $_POST['achievementInfo'] 
        : json_decode($_POST['achievementInfo'], true);
    
    if (!$achievementInfo) {
        returnError('Invalid Achievement Information Format.', 400);
    }
    
    // Ensure required field(s) exist - for example, SK Official ID is required
    if (!isset($achievementInfo['sk_official_id'])) {
        returnError('SK Official ID is required.', 400);
    }
    
    // Create a new Achievement object
    $achievement = new Achievement();
    
    // Set fields if provided
    if (isset($achievementInfo['sk_official_id'])) {
        $achievement->setSkOfficialId($achievementInfo['sk_official_id']);
    }
    if (isset($achievementInfo['title'])) {
        $achievement->setTitle($achievementInfo['title']);
    }
    if (isset($achievementInfo['subtitle'])) {
        $achievement->setSubtitle($achievementInfo['subtitle']);
    }
    if (isset($achievementInfo['info'])) {
        $achievement->setInfo($achievementInfo['info']);
    }
    if (isset($achievementInfo['date'])) {
        $achievement->setDate($achievementInfo['date']); // Expected format: YYYY-MM-DD
    }
    
    // Process file upload if a file was provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust the path as needed)
        $uploadDir = __DIR__ . '/../public/achievements/';
        
        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Get a sanitized version of the filename
        $filename = basename($_FILES['file']['name']);
        
        // Set the target file path
        $targetFile = $uploadDir . $filename;
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Update the achievement record with the new filename
            $achievement->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($achievementInfo['img'])) {
        // If no new file is uploaded, update with the provided img value if any
        $achievement->setImg($achievementInfo['img']);
    }
    
    // Insert the new achievement record
    if ($achievement->insert()) {
        returnSuccess([
            'message' => 'Achievement added successfully.',
            'achievement' => $achievement->getAssoc()
        ]);
    } else {
        returnError("Insert failed. An error occurred.", 500);
    }
}

else if ($action === 'deleteAchievement') {
    // Ensure an ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        returnError("Achievement ID is required.", 400);
    }

    // Instantiate the model with the given ID.
    // This assumes your model's constructor will load the record if an ID is passed.
    $achievement = new Achievement($_POST['id']);
    
    // Check if the achievement exists (this depends on your model logic)
    if (!$achievement) {
        returnError("No achievement found with ID " . $_POST['id'], 404);
    }

    // Call the delete() method on the model
    if ($achievement->delete()) {
        returnSuccess([
            'message' => 'Achievement deleted successfully.'
        ]);
    } else {
        returnError("Delete failed. No changes detected or an error occurred.", 500);
    }
}



/** Invalid Request *******************************************/
else
{
    returnError('Action Not Found.', 404);
}