<?php
// Enable CORS
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
session_start();

require_once 'config/database.php';

/**
 * Returns the current authenticated user
 * @return mixed Current authenticated SkOfficial or null
 */
function getUser() {
    require_once 'models/SkOfficial.php';
    return SkOfficial::getLoggedIn();
}

/**
 * Denies access with 401 Unauthorized response
 * @return void
 */
function denyAccess() {
    header('HTTP/1.1 401 Unauthorized');
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 401,
        'message' => 'Authentication required',
        'data' => ['authenticated' => false]
    ]);
    exit;
}

/**
 * Returns an error response
 * @param string $statusCode HTTP status code
 * @param string $message Error message
 * @return void
 */
function returnError(string $statusCode, string $message): void {
    header($statusCode);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => intval(substr($statusCode, 9, 3)),
        'message' => $message,
        'data' => null
    ]);
    exit;
}
