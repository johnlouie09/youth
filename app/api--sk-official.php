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

        returnSuccess([
            'sk_official' => $sk_official->getAssoc(true)
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

    if ($sk_official === null) {
        returnError('No logged-in SkOfficial.', 401);
    }
    else {
        returnSuccess([
            'sk_official' => $sk_official->getAssoc(true)
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

/** Invalid Request *******************************************/
else
{
    returnError('Action Not Found.', 404);
}