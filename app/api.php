<?php
/** Guard Constant */
define('__BASE', __DIR__);

/** Request Headers */
header('Access-Control-Allow-Origin: http://localhost:5173');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

/** Start Session */
session_start();

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

/* if ($endpoint == 'barangay')
{
    require_once __DIR__ . '/api--barangay.php';
}*/

else
{
    returnError('Main Endpoint Not Found.', 404);
}
