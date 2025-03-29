<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ .'/models/Achievement.php';
require_once __DIR__ .'/models/SkEducation.php';
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


// SK Official Achievement 
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
    if (isset($achievementInfo['sk_official_id'])) {
        $achievement->setSkOfficialId($achievementInfo['sk_official_id']);
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

// SK Official Education
else if ($action === 'updateEducation') {
    // Ensure education data is provided
    if (!isset($_POST['educationInfo'])) {
        returnError('Invalid Education Information Received.', 400);
    }

    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $educationInfo = is_array($_POST['educationInfo'])
        ? $_POST['educationInfo']
        : json_decode($_POST['educationInfo'], true);

    if (!$educationInfo) {
        returnError('Invalid Education Information Format.', 400);
    }

    // Ensure ID exists
    if (!isset($educationInfo['id'])) {
        returnError('Education ID is required.', 400);
    }

    // Fetch education record from database using the provided ID
    $education = SkEducation::findBy('id', $educationInfo['id']);
    if (!$education) {
        returnError("No education record found with ID " . $educationInfo['id'], 404);
    }

    // Update fields if provided
    if (isset($educationInfo['school_name'])) {
        $education->setSchoolName($educationInfo['school_name']);
    }
    if (isset($educationInfo['course'])) {
        $education->setCourse($educationInfo['course']);
    }
    if (isset($educationInfo['start_year'])) {
        $education->setStartYear($educationInfo['start_year']);
    }
    if (isset($educationInfo['end_year'])) {
        $education->setEndYear($educationInfo['end_year']);
    }
    if (isset($educationInfo['education_level_id'])) {
        $education->setEducationLevelId($educationInfo['education_level_id']);
    }
    if (isset($educationInfo['sk_official_id'])) {
        $education->setSkOfficialId($educationInfo['sk_official_id']);
    }

    // Process file upload if a file was provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory (adjust path as needed)
        $uploadDir = __DIR__ . '/../public/schoolLogos/'; 

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
            // Update the education record with the new school logo filename
            $education->setSchoolLogo($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($educationInfo['school_logo'])) {
        // If no new file is uploaded, update with the provided school_logo value if any
        $education->setSchoolLogo($educationInfo['school_logo']);
    }

    // Execute update
    if ($education->update()) {
        returnSuccess([
            'message' => 'Education record updated successfully.',
            'education' => $education->getAssoc()
        ]);
    } else {
        returnError("Update failed. No changes detected or an error occurred.", 500);
    }
}

else if ($action === 'deleteEducation') {
    // Ensure an ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        returnError("Education ID is required.", 400);
    }

    // Fetch the education record from the database using the provided ID
    $education = SkEducation::findBy('id', $_POST['id']);
    if (!$education) {
        returnError("No education record found with ID " . $_POST['id'], 404);
    }

    // Attempt to delete the education record
    if ($education->delete()) {
        returnSuccess([
            'message' => 'Education deleted successfully.'
        ]);
    } else {
        returnError("Delete failed. No changes detected or an error occurred.", 500);
    }
}

else if ($action === 'addEducation') {
    // Ensure education data is provided
    if (!isset($_POST['educationInfo'])) {
        returnError('Invalid education information received.', 400);
    }
    
    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $educationInfo = is_array($_POST['educationInfo']) 
        ? $_POST['educationInfo'] 
        : json_decode($_POST['educationInfo'], true);
    
    if (!$educationInfo) {
        returnError('Invalid education information format.', 400);
    }
    
    // Ensure that required fields are provided; for adding, the primary key is auto-incremented.
    if (!isset($educationInfo['sk_official_id'])) {
        returnError('SK Official ID is required.', 400);
    }
    
    // Create a new Education record
    $education = new SkEducation();
    
    // Set fields if provided
    if (isset($educationInfo['sk_official_id'])) {
        $education->setSkOfficialId($educationInfo['sk_official_id']);
    }
    if (isset($educationInfo['education_level_id'])) {
        $education->setEducationLevelId($educationInfo['education_level_id']);
    }
    if (isset($educationInfo['school_name'])) {
        $education->setSchoolName($educationInfo['school_name']);
    }
    if (isset($educationInfo['course'])) {
        $education->setCourse($educationInfo['course']);
    }
    if (isset($educationInfo['start_year'])) {
        $education->setStartYear($educationInfo['start_year']);
    }
    if (isset($educationInfo['end_year'])) {
        $education->setEndYear($educationInfo['end_year']);
    }
    
    // Process file upload if a file was provided (for the school logo)
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
            // Update the education record with the new logo filename
            $education->setSchoolLogo($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($educationInfo['school_logo'])) {
        // If no new file is uploaded, update with the provided school_logo value if any
        $education->setSchoolLogo($educationInfo['school_logo']);
    }
    
    // Insert the new education record
    if ($education->insert()) {
        returnSuccess([
            'message' => 'Education added successfully.',
            'education' => $education->getAssoc()
        ]);
    } else {
        returnError("Insert failed. No changes detected or an error occurred.", 500);
    }
}



else if ($action === 'addOfficial') {
    // Ensure officialInfo is provided
    if (!isset($_POST['officialInfo'])) {
        returnError('Official information is required.', 400);
    }
    
    // Decode JSON data if necessary
    $officialInfo = is_array($_POST['officialInfo']) 
        ? $_POST['officialInfo'] 
        : json_decode($_POST['officialInfo'], true);
    
    if (!$officialInfo) {
        returnError('Invalid official information format.', 400);
    }
    
    // Check required fields: Barangay ID, Full Name, Email, and Position
    if (!isset($officialInfo['barangay_id'])) {
        returnError('Barangay ID is required.', 400);
    }
    if (!isset($officialInfo['full_name']) || trim($officialInfo['full_name']) === '') {
        returnError('Full Name is required.', 400);
    }
    if (!isset($officialInfo['email']) || trim($officialInfo['email']) === '') {
        returnError('Email is required.', 400);
    }
    if (!isset($officialInfo['position']) || trim($officialInfo['position']) === '') {
        returnError('SK Official position is required.', 400);
    }
    
    // Validate SK position using allowed constants
    $allowedPositions = [
        SkOfficial::POSITION_SK_CHAIRPERSON,
        SkOfficial::POSITION_SK_SECRETARY,
        SkOfficial::POSITION_SK_TREASURER,
        SkOfficial::POSITION_SK_KAGAWAD
    ];
    if (!in_array($officialInfo['position'], $allowedPositions)) {
        returnError('Invalid SK Official position provided.', 400);
    }
    
    // Create a new SK Official instance
    $official = new SkOfficial();
    
    // Set the provided properties
    $official->setBarangayId($officialInfo['barangay_id']);
    
    // Use the provided slug if available; otherwise, auto-generate from full_name
    if (isset($officialInfo['slug']) && trim($officialInfo['slug']) !== '') {
        $official->setSlug($officialInfo['slug']);
    } else {
        $slug = strtolower(explode(" ", $officialInfo['full_name'])[0]);
        $official->setSlug($slug);
    }
    
    // Do not set username and password from the input; set them as empty strings.
    $official->setUsername('');
    $official->setPassword('');
    
    // Set the remaining properties
    $official->setFullName($officialInfo['full_name']);
    $official->setPosition($officialInfo['position']);
    if (isset($officialInfo['contact_number'])) {
        $official->setContactNumber($officialInfo['contact_number']);
    }
    $official->setEmail($officialInfo['email']);
    if (isset($officialInfo['birthday'])) {
        $official->setBirthday($officialInfo['birthday']);
    }
    if (isset($officialInfo['motto'])) {
        $official->setMotto($officialInfo['motto']);
    }
    if (isset($officialInfo['img'])) {
        $official->setImg($officialInfo['img']);
    }
    if (isset($officialInfo['term_start'])) {
        $official->setTermStart($officialInfo['term_start']);
    }
    if (isset($officialInfo['term_end'])) {
        $official->setTermEnd($officialInfo['term_end']);
    }
    
    // Process file upload if provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory
        $uploadDir = __DIR__ . '/../public/OfficialImages/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Sanitize the filename and construct the target path
        $filename = basename($_FILES['file']['name']);
        $targetFile = rtrim($uploadDir, '/') . '/' . $filename;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $official->setImg($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    }
    
    // Attempt to insert the new official into the database
    if ($official->insert()) {
        returnSuccess([
            'message' => 'SK Official added successfully.',
            'official' => $official->getAssoc()
        ]);
    } else {
        returnError("Failed to add SK Official.", 500);
    }
}


else if ($action === 'deleteOfficial') {
    // Ensure the official ID is provided.
    if (!isset($_POST['id'])) {
        returnError('Official ID is required.', 400);
    }
    
    $id = $_POST['id'];
    // Fetch the official from the database
    $official = SkOfficial::findBy('id', $id);
    
    if (!$official) {
        returnError("No official found with ID $id.", 404);
    }
    
    // Attempt to delete the official.
    if ($official->delete()) {
        returnSuccess([
            'message' => 'SK Official deleted successfully.'
        ]);
    } else {
        returnError("Failed to delete SK Official.", 500);
    }
}

/** Invalid Request *******************************************/
else
{
    returnError('Action Not Found.', 404);
}