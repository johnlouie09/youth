<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/SkOfficial.php';

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

// Handle updatePersonalInfo action
else if ($action === 'updatePersonalInfo') {
    // Ensure data exists
    if (!isset($_POST['personalInfo'])) {
        returnError('Invalid personal information received.', 400);
    }

    // Decode JSON if needed (only necessary if it arrives as a JSON string)
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
        $official->setBirthday($personalInfo['birthday']); // Ensure correct format
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
    if (isset($personalInfo['img'])) {
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

/** Invalid Request *******************************************/
else
{
    returnError('Action Not Found.', 404);
}