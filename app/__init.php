<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

require_once 'config/database.php';
require_once 'models/SkOfficial.php';

/**
 * Restricts access to authenticated users only
 * @return SkOfficialController
 */
function requireAuthentication(): SkOfficialController
{
    $loggedIn = SkOfficial::getLoggedIn();

    if ($loggedIn === null) {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 401,
            'message' => 'Authentication required',
            'data' => ['authenticated' => false]
        ]);
        exit;
    }

    return $loggedIn;
}

/**
 * Returns a standard error response
 * @param string $statusCode HTTP status code
 * @param string $message Error message
 * #[NoReturn]
 */
function returnError(string $statusCode, string $message): void
{
    header($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => intval(substr($statusCode, 9)),
        'message' => $message,
        'data' => null
    ]);
    exit;
}

/**
 * Returns the current authenticated user
 * @return SkOfficialController
 */
function getUser(): SkOfficialController
{
    return SkOfficial::getLoggedIn();
}
