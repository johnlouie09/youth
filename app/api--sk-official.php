<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ .'/models/Achievement.php';
require_once __DIR__ .'/models/AchievementDate.php';
require_once __DIR__ .'/models/SkEducation.php';
require_once __DIR__ .'/models/SkAdvocacies.php';
require_once __DIR__ .'/models/SkPlatforms.php';
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




//---------------------- SK Official Management API --------------------
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
        'achievements' => $official->getAchievements(true),
        'advocacies' => $official->getAdvocacies(),
        'platforms' => $official->getPlatforms()
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




// ---------------------- SK Official Achievement API --------------------
else if ($action === 'updateAchievement') {

    if (!isset($_POST['achievementInfo'])) {
        returnError('Invalid Achievement Information Received.', 400);
    }

    $achievementInfo = is_array($_POST['achievementInfo'])
        ? $_POST['achievementInfo']
        : json_decode($_POST['achievementInfo'], true);

    if (!$achievementInfo) {
        returnError('Invalid Achievement Information Format.', 400);
    }

    // Required fields
    if (empty($achievementInfo['id'])) {
        returnError('Achievement ID is required for update.', 400);
    }
    if (empty($achievementInfo['sk_official_id'])) {
        returnError('SK Official ID is required.', 400);
    }
    if (empty($achievementInfo['title'])) {
        returnError('Achievement title is required.', 400);
    }

    try {
        $achievement = new Achievement($achievementInfo['id']);
        if (!$achievement->getId()) {
            returnError('Achievement not found.', 404);
        }

        // ✅ Update basic fields
        $achievement->setSkOfficialId($achievementInfo['sk_official_id']);
        $achievement->setTitle($achievementInfo['title']);
        if (isset($achievementInfo['subtitle'])) $achievement->setSubtitle($achievementInfo['subtitle']);
        if (isset($achievementInfo['info'])) $achievement->setInfo($achievementInfo['info']);
        if (isset($achievementInfo['sk_official_comment'])) $achievement->setSkOfficialComment($achievementInfo['sk_official_comment']);

        $achievementId = $achievement->getId();
        $achievement->update();

        // ✅ Handle dates with new helper
        $dates = isset($achievementInfo['dates']) && is_array($achievementInfo['dates'])
            ? $achievementInfo['dates']
            : [];

        if(empty($dates)) {
            AchievementDate::deleteByAchievement($achievementId);
        } else {
            $achievement->updateDates($dates);
        }

        // --- IMAGE HANDLING ---
        $uploadDir = __DIR__ . '/../public/Achievements/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $achievementId = $achievement->getId();
        $existingImages = AchievementImage::getByachievement($achievementId, true);

        $incomingImages = $achievementInfo['images'] ?? [];
        $incomingIds = array_filter(array_map(fn($img) => $img['id'] ?? null, $incomingImages));

        // Delete images not in payload
        foreach ($existingImages as $existing) {
            if (!in_array($existing['id'], $incomingIds)) {
                $imgObj = new AchievementImage($existing['id']);
                $imgObj->delete();
                $filePath = $uploadDir . $existing['img'];
                if (file_exists($filePath)) unlink($filePath);
            }
        }

        // ✅ Map tempIds for new uploads
        $tempIdMap = [];

        if (!empty($_FILES['files']) && isset($_FILES['files']['name'])) {
            for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                    $originalName = basename($_FILES['files']['name'][$i]);
                    $filename = uniqid() . "_" . $originalName; // ✅ prevent overwrite
                    $targetFile = $uploadDir . $filename;

                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                        $img = new AchievementImage();
                        $img->setAchievementId($achievementId);
                        $img->setImg($filename);
                        $img->insert();

                        $newImageId = $img->getId();

                        // ✅ Find matching tempId from payload
                        if (!empty($achievementInfo['images'])) {
                            foreach ($achievementInfo['images'] as $imgInfo) {
                                if (empty($imgInfo['id']) && !empty($imgInfo['tempId'])) {
                                    // first unassigned tempId gets mapped
                                    $tempIdMap[$imgInfo['tempId']] = $newImageId;
                                    break;
                                }
                            }
                        }
                    } else {
                        error_log("❌ Failed to move uploaded file: " . $_FILES['files']['name'][$i]);
                    }
                }
            }
        }

        // ✅ Resolve thumbnail (updates should respect null)
        $thumbnailImageId = null;

        if (!empty($achievementInfo['thumbnail_tempId']) && isset($tempIdMap[$achievementInfo['thumbnail_tempId']])) {
            $thumbnailImageId = $tempIdMap[$achievementInfo['thumbnail_tempId']];
        } elseif (array_key_exists('thumbnail_id', $achievementInfo)) {
            // Respect explicit null or a real id
            $thumbnailImageId = $achievementInfo['thumbnail_id'] ?: null;
        }

        if ($thumbnailImageId !== null) {
            $achievement->setThumbnailId($thumbnailImageId);
            $achievement->updateThumbnail();
        } else {
            // ✅ If explicitly null, clear it in DB
            $achievement->setThumbnailId(null);
            $achievement->updateThumbnail();
        }



        if ($thumbnailImageId !== null) {
            $achievement->setThumbnailId($thumbnailImageId);
            $achievement->updateThumbnail();
        }



        if ($achievement->updateDates($dates)) {
            returnSuccess([
                'message'     => 'Achievement updated successfully.',
                'achievement' => $achievement->getAssoc(true),
                'dates'       => AchievementDate::getByAchievement($achievementId, true),
                'images'      => AchievementImage::getByAchievement($achievementId, true)     
            ]);
        } else {
            returnError("Achievement update failed. Check server logs.", 500);
        }


    } catch (Exception $e) {
        error_log("Achievement update error: " . $e->getMessage());
        returnError("An error occurred while updating the achievement: " . $e->getMessage(), 500);
    }
}


else if ($action === 'addAchievement') {
    if (!isset($_POST['achievementInfo'])) {
        returnError('Invalid Achievement Information Received.', 400);
    }

    $achievementInfo = is_array($_POST['achievementInfo'])
        ? $_POST['achievementInfo']
        : json_decode($_POST['achievementInfo'], true);

    if (!$achievementInfo) {
        returnError('Invalid Achievement Information Format.', 400);
    }

    // Required fields
    if (empty($achievementInfo['sk_official_id'])) {
        returnError('SK Official ID is required.', 400);
    }
    if (empty($achievementInfo['title'])) {
        returnError('Achievement title is required.', 400);
    }

    try {
        $achievement = new Achievement();

        // ✅ Set fields
        $achievement->setSkOfficialId($achievementInfo['sk_official_id']);
        $achievement->setTitle($achievementInfo['title']);
        if (isset($achievementInfo['subtitle'])) $achievement->setSubtitle($achievementInfo['subtitle']);
        if (isset($achievementInfo['info'])) $achievement->setInfo($achievementInfo['info']);
        if (isset($achievementInfo['sk_official_comment'])) $achievement->setSkOfficialComment($achievementInfo['sk_official_comment']);

        // ✅ Insert first (so we have an ID)
        if ($achievement->insert()) {
            $achievementId = $achievement->getId();

            // ✅ Handle dates
            $dates = isset($achievementInfo['dates']) && is_array($achievementInfo['dates'])
                ? $achievementInfo['dates']
                : [];

            if (!empty($dates)) {
                $achievement->updateDates($dates);
            }

            // --- IMAGE HANDLING ---
            $uploadDir = __DIR__ . '/../public/Achievements/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $incomingImages = $achievementInfo['images'] ?? [];
            $incomingIds = array_filter(array_map(fn($img) => $img['id'] ?? null, $incomingImages));
            $tempIdMap = [];

            if (!empty($_FILES['files']) && isset($_FILES['files']['name'])) {
                for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
                    if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                        $originalName = basename($_FILES['files']['name'][$i]);
                        $filename = uniqid() . "_" . $originalName; // ✅ prevent overwrite
                        $targetFile = $uploadDir . $filename;

                        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                            $img = new AchievementImage();
                            $img->setAchievementId($achievementId);
                            $img->setImg($filename);
                            $img->insert();

                            $newImageId = $img->getId();

                            // ✅ Match to tempId from payload
                            if (!empty($achievementInfo['images'])) {
                                foreach ($achievementInfo['images'] as $imgInfo) {
                                    if (empty($imgInfo['id']) && !empty($imgInfo['tempId'])) {
                                        $tempIdMap[$imgInfo['tempId']] = $newImageId;
                                        break;
                                    }
                                }
                            }
                        } else {
                            error_log("❌ Failed to upload file: " . $_FILES['files']['name'][$i]);
                        }
                    }
                }
            }

            // ✅ Resolve thumbnail only if explicitly set
            $thumbnailImageId = null;

            if (!empty($achievementInfo['thumbnail_tempId']) && isset($tempIdMap[$achievementInfo['thumbnail_tempId']])) {
                $thumbnailImageId = $tempIdMap[$achievementInfo['thumbnail_tempId']];
            } elseif (!empty($achievementInfo['thumbnail_id'])) {
                $thumbnailImageId = $achievementInfo['thumbnail_id'];
            }

            if ($thumbnailImageId !== null) {
                $achievement->setThumbnailId($thumbnailImageId);
                $achievement->updateThumbnail();
            }


            // ✅ Final response
            returnSuccess([
                'message'     => 'Achievement added successfully.',
                'achievement' => $achievement->getAssoc(true),
                'dates'       => AchievementDate::getByAchievement($achievementId, true),
                'images'      => AchievementImage::getByAchievement($achievementId, true),
                'tempIdMap'   => $tempIdMap // frontend can map tempId → real ID
            ]);
        } else {
            returnError("Insert failed. An error occurred.", 500);
        }

    } catch (Exception $e) {
        error_log("Achievement add error: " . $e->getMessage());
        returnError("An error occurred while adding the achievement: " . $e->getMessage(), 500);
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




// ---------------------- SK Official Education API --------------------
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
    if (isset($educationInfo['institution'])) {
        $education->setInstitution($educationInfo['institution']);
    }
    if (isset($educationInfo['course_or_details'])) {
         $education->setCourseOrDetails($educationInfo['course_or_details']);
    }
    if (isset($educationInfo['start_year'])) {
        $education->setStartYear($educationInfo['start_year']);
    }
    if (isset($educationInfo['end_year'])) {
        $education->setEndYear($educationInfo['end_year']);
    }
    if(isset($educationInfo['educational_achievements'])) {
        $education->setEducationalAchievements($educationInfo['educational_achievements']);
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
            $education->setInstitutionLogo($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($educationInfo['school_logo'])) {
        // If no new file is uploaded, update with the provided school_logo value if any
        $education->setInstitutionLogo($educationInfo['institution_logo']);
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

    // Ensure that required fields are provided
    if (!isset($educationInfo['sk_official_id'])) {
        returnError('SK Official ID is required.', 400);
    }

    // Create a new Education record
    $education = new SkEducation();

    // Set fields if provided
    if (isset($educationInfo['sk_official_id'])) {
        $education->setSkOfficialId($educationInfo['sk_official_id']);
    }
    if (isset($educationInfo['educational_type'])) {
        $education->setEducationalType($educationInfo['educational_type']);
    }
    if (isset($educationInfo['institution'])) {
        $education->setInstitution($educationInfo['institution']);
    }
    if (isset($educationInfo['course_or_details'])) {
        $education->setCourseOrDetails($educationInfo['course_or_details']);
    }
    if (isset($educationInfo['educational_achievements'])) {
        $education->setEducationalAchievements($educationInfo['educational_achievements']);
    }
    if (isset($educationInfo['start_year'])) {
        $education->setStartYear($educationInfo['start_year']);
    }
    if (isset($educationInfo['end_year'])) {
        $education->setEndYear($educationInfo['end_year']);
    }

    // Process file upload if a file was provided (for the institution logo)
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../public/schoolLogos/'; 

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = basename($_FILES['file']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $education->setInstitutionLogo($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (isset($educationInfo['institution_logo'])) {
        $education->setInstitutionLogo($educationInfo['institution_logo']);
    }

    // Insert the new education record
    if ($education->insert()) {
        returnSuccess([
            'message' => 'Education added successfully.',
            'education' => $education->getAssoc()
        ]);
    } else {
        returnError("Insert failed. An error occurred.", 500);
    }
}




// ---------------------- SK Official Advocacy API --------------------
else if ($action === 'addAdvocacy') {
    // Ensure advocacies data is provided
    if (!isset($_POST['advocacyInfo']) || !isset($_POST['sk_official_id'])) {
        returnError('Advocacy info and SK Official ID are required.', 400);
    }

    // Decode JSON if needed
    $advocacy = is_array($_POST['advocacyInfo']) 
        ? $_POST['advocacyInfo'] 
        : json_decode($_POST['advocacyInfo'], true);

    if (!is_array($advocacy)) {
        returnError('Invalid advocacy format.', 400);
    }

    $sk_official_id = (int) $_POST['sk_official_id'];

    // Create new advocacy instance
    $skAdvocacy = new SkAdvocacies();
    $skAdvocacy->setSkOfficialId($sk_official_id);
    $skAdvocacy->setTitle($advocacy['title'] ?? '');
    $skAdvocacy->setSubtitle($advocacy['subtitle'] ?? '');
    $skAdvocacy->setDetail($advocacy['detail'] ?? '');

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../public/advocacyImages/'; 
        $filename = time() . '_' . basename($_FILES['file']['name']); // unique filename
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $skAdvocacy->setThumbnail($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    } else if (!empty($advocacy['thumbnail'])) {
        $skAdvocacy->setThumbnail($advocacy['thumbnail']);
    }

    // Insert into DB
    if ($skAdvocacy->insert()) {
        returnSuccess([
            'message' => 'Advocacy added successfully.',
            'advocacy' => $skAdvocacy->getAssoc()
        ]);
    } else {
        returnError("Failed to add advocacy.", 500);
    }
}

else if ($action === 'updateAdvocacy') {
    // Ensure advocacies data is provided
    if (!isset($_POST['advocacyInfo']) || !isset($_POST['sk_official_id'])) {
        returnError('Advocacies and SK Official ID are required.', 400);
    }

    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $advocacy = is_array($_POST['advocacyInfo']) 
        ? $_POST['advocacyInfo'] 
        : json_decode($_POST['advocacyInfo'], true);

    if (!is_array($advocacy)) {
        returnError('Invalid advocacies format.', 400);
    }

    $sk_official_id = $_POST['sk_official_id'];

    // Fetch the SK Official to ensure they exist
    $skAdvocacy = SkAdvocacies::findBy('id', $advocacy['id']);
    if (!$skAdvocacy) {
        returnError("No SK advocacy found with ID",404);
    }

    // Update the properties of the advocacy if provided
    if(isset($advocacy['title'])) { $skAdvocacy->setTitle($advocacy['title']);}
    if(isset($advocacy['subtitle'])) { $skAdvocacy->setSubtitle($advocacy['subtitle']);}
    if(isset($advocacy['detail'])) { $skAdvocacy->setDetail($advocacy['detail']);}

    // Upload the file to Directory in the Server
    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
         // Define the upload directory (adjust path as needed)
        $uploadDir = __DIR__ . '/../public/advocacyImages/'; 

        // Get a sanitized version of the filename
        $filename = basename($_FILES['file']['name']);

        // Set the target file path
        $targetFile = $uploadDir . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            // Update the education record with the new school logo filename
            $skAdvocacy->setThumbnail($filename);
        } else {
            returnError("Failed to upload file.", 500);
        }
    }
    else if (isset($advocacy['thumbnail'])) {
        // If no new file is uploaded, update with the provided school_logo value if any
        $skAdvocacy->setThumbnail($advocacy['thumbnail']);
    }



    // Update advocacies
    if ($skAdvocacy->update()) {
        returnSuccess([
            'message' => 'Advocacies updated successfully.',
            'advocacies' => $skAdvocacy->getAssoc()
        ]);
    } else {
        returnError("Failed to update advocacies.", 500);
    }
}

else if ($action === 'deleteAdvocacy') {
    // Ensure the advocacy ID is provided.
    if (!isset($_POST['id'])) {
        returnError('Advocacy ID is required.', 400);
    }

    $id = $_POST['id'];
    // Fetch the advocacy from the database
    $skAdvocacy = SkAdvocacies::findBy('id', $id);

    if (!$skAdvocacy) {
        returnError("No advocacy found with ID $id.", 404);
    }

    // Attempt to delete the advocacy.
    if ($skAdvocacy->delete()) {
        returnSuccess([
            'message' => 'Advocacy deleted successfully.'
        ]);
    } else {
        returnError("Failed to delete advocacy.", 500);
    } 
}




// ---------------------- SK Official Platform API --------------------
else if ($action === 'updatePlatform') {
    // Ensure platform data is provided
    if (!isset($_POST['platformInfo'])) {
        returnError('Invalid Platform Information Received.', 400);
    }

    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $platformInfo = is_array($_POST['platformInfo']) 
        ? $_POST['platformInfo'] 
        : json_decode($_POST['platformInfo'], true);

    if (!$platformInfo) {
        returnError('Invalid Platform Information Format.', 400);
    }

    // Ensure ID exists
    if (!isset($platformInfo['id'])) {
        returnError('Platform ID is required.', 400);
    }

    // Fetch platform record from database using the provided ID
    $platform = SkPlatforms::findBy('id', $platformInfo['id']);
    if (!$platform) {
        returnError("No platform record found with ID " . $platformInfo['id'], 404);
    }

    // Update fields if provided
    if (isset($platformInfo['title'])) {
        $platform->setTitle($platformInfo['title']);
    }
    if (isset($platformInfo['detail'])) {
         $platform->setDetail($platformInfo['detail']);
    }
    if (isset($platformInfo['sk_advocacy_id'])) {
        $platform->setSkAdvocacyId($platformInfo['sk_advocacy_id']);
    }

    // Execute update
    if ($platform->update()) {
        returnSuccess([
            'message' => 'Platform record updated successfully.',
            'platform' => $platform->getAssoc()
        ]);
    } else {
        returnError("Update failed. No changes detected or an error occurred.", 500);
    }
}

else if ($action === 'deletePlatform') {
    // Ensure an ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        returnError("Platform ID is required.", 400);
    }

    // Fetch the platform record from the database using the provided ID
    $platform = SkPlatforms::findBy('id', $_POST['id']);
    if (!$platform) {
        returnError("No platform record found with ID " . $_POST['id'], 404);
    }

    // Attempt to delete the platform record
    if ($platform->delete()) {
        returnSuccess([
            'message' => 'Platform deleted successfully.'
        ]);
    } else {
        returnError("Delete failed. No changes detected or an error occurred.", 500);
    }
}

else if( $action === 'addPlatform') {
    // Ensure platform data is provided
    if (!isset($_POST['platformInfo'])) {
        returnError('Invalid platform information received.', 400);
    }

    // Decode JSON if needed (if sent via FormData, it may be a JSON string)
    $platformInfo = is_array($_POST['platformInfo']) 
        ? $_POST['platformInfo'] 
        : json_decode($_POST['platformInfo'], true);

    if (!$platformInfo) {
        returnError('Invalid platform information format.', 400);
    }

    // Ensure that required fields are provided
    if (!isset($platformInfo['sk_advocacy_id'])) {
        returnError('SK Advocacy ID is required.', 400);
    }
    if (!isset($platformInfo['title'])) {
        returnError('Platform title is required.', 400);
    }

    // Create a new Platform record
    $platform = new SkPlatforms();

    // Set fields if provided
    if (isset($platformInfo['sk_advocacy_id'])) {
        $platform->setSkAdvocacyId($platformInfo['sk_advocacy_id']);
    }
    if (isset($platformInfo['title'])) {
        $platform->setTitle($platformInfo['title']);
    }
    if (isset($platformInfo['detail'])) {
        $platform->setDetail($platformInfo['detail']);
    }

    // Insert the new platform record
    if ($platform->insert()) {
        returnSuccess([
            'message' => 'Platform added successfully.',
            'platform' => $platform->getAssoc()
        ]);
    } else {
        returnError("Insert failed. An error occurred.", 500);
    }
}

// ---------------------- SK Official Management API --------------------
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


// Get available year-months for Achievements
else if ($action === 'achievements-available-year-months') {
    $barangayId = $_POST['barangayId'] ?? null;

    $yearMonths = AchievementDate::getAvailableYearMonths(
        $barangayId ? (int)$barangayId : null
    );

    returnSuccess([
        'yearMonths' => $yearMonths
    ]);
}
/** Invalid Request *******************************************/
else
{
    returnError('Action Not Found.', 404);
}