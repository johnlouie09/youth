<?php
/** Guard Constant */
define('__BASE', __DIR__);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
    http_response_code(200);
    exit;
}

/** Request Headers */
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
header('Content-Type: application/json');

/** Start Session */
session_start();

// For state-changing requests, verify the CSRF token.
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    // Retrieve the token from the request header
    $requestCsrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

    // Check if the token exists and matches the session token
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $requestCsrfToken)) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error'   => true,
            'message' => 'Invalid CSRF token.'
        ]);
        exit;
    }
}


/**
 * Returns successful JSON response with a status code.
 * @param mixed $data
 * @param int $status
 * @return void
 */
function returnSuccess(mixed $data, int $status = 200): void
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode([
        'success' => true,
        'error'   => false,
        'data'    => $data
    ]);

    exit;
}


/**
 * Returns error JSON response with a status code.
 * @param string $message
 * @param int $status
 * @return void
 */
function returnError(string $message, int $status = 500): void
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode([
        'success' => false,
        'error'   => true,
        'message' => $message
    ]);

    exit;
}

/** Extract Main Endpoint */
$endpoint = $_GET['e'] ?? '';

/** Main Endpoints */
if ($endpoint == 'sk-official')
{
    require_once __DIR__ . '/api--sk-official.php';
}

else if ($endpoint == 'cluster')
{
    require_once __DIR__ . '/api--cluster.php';
}
else if($endpoint == 'barangay') {
    require_once __DIR__ . '/api--barangay.php';
}
else if($endpoint == 'csrf') {
    require_once __DIR__ . '/csrf.php';
}

else
{
    returnError('Main Endpoint Not Found.', 404);
}
