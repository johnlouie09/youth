<?php
require_once '../__init.php';

$authUser = getUser();
if (!$authUser) {
    denyAccess();
} else if ($authUser->getPosition() !== 'position') {
    denyAccess();
} else {
    require_once '../models/SkOfficial.php';
    $official = new SkOfficial();
    $official = SkOfficial::getLoggedIn();

    if (!$official) {
        denyAccess();
    } else {
        if (isset($_POST['authenticate'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['identifier']) || !isset($data['password'])) {
                returnError('HTTP/1.1 400 Bad Request', 'Missing required fields: identifier and password');
            }

            $identifier = trim($data['identifier']);
            $password = trim($data['password']);
            $remember = isset($data['remember']) ? (bool)$data['remember'] : false;

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