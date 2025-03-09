<?php
require_once '../__init.php';

$authUser = getUser();
if (!$authUser) {
    denyAccess();
} else if ($authUser->getPosition() !== 'SK Chairperson') {
    denyAccess();
} else {
    require_once '../models/SkOfficial.php';
    $official = new SkOfficial();
    $official = SkOfficial::getLoggedIn();

    if (!$official) {
        denyAccess();
    } else {
        if (isset($_POST['authenticate'])) {
            if (!isset($_POST['identifier']) || !isset($_POST['password'])) {
                returnError('HTTP/1.1 400 Bad Request', 'Missing required fields: identifier and password');
            }

            $identifier = trim($_POST['identifier']);
            $password = trim($_POST['password']);
            $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;

            try {
                $official = SkOfficial::login($identifier, $password, $remember);
                echo json_encode([
                    'status' => 200,
                    'message' => 'Authentication successful',
                    'data' => [
                        'user' => $official->getAssoc(true),
                        'authenticated' => true
                    ]
                ]);
            } catch (Exception $e) {
                returnError('HTTP/1.1 401 Unauthorized', $e->getMessage());
            }
        }
        // Logout endpoint
        else if (isset($_POST['logout'])) {
            SkOfficial::logout();
            echo json_encode([
                'status' => 200,
                'message' => 'Logout successful'
            ]);
        }
        else {
            denyAccess();
        }
    }
}