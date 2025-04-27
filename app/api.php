<?php

// enable error reporting for development
ini_set('display_errors', 1);           // tells PHP to display runtime errors
ini_set('display_startup_errors', 1);   // tells PHP to display errors that occur during PHP's startup sequence
error_reporting(E_ALL);                    // sets the error reporting level to report all PHP errors


/** Guard Constant */
define('__BASE', __DIR__);

// Define allowed origins
$allowedOrigins = ['http://localhost:5173', 'https://testdeploy.irigayouth.com'];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Handle OPTIONS preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    if (in_array($origin, $allowedOrigins)) {
        header('Access-Control-Allow-Origin: ' . $origin);
    }
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
    http_response_code(200);
    exit;
}

// Set headers for regular requests
if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
} else {
    header('Access-Control-Allow-Origin: https://testdeploy.irigayouth.com'); // Default to production
}
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
else if($endpoint == 'education-level') {
    require_once __DIR__ . '/api--educationLevel.php';
}
else if($endpoint == 'csrf') {
    require_once __DIR__ . '/csrf.php';
}

else
{
    returnError('Main Endpoint Not Found.', 404);
}
