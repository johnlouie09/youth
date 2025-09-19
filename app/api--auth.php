<?php
declare(strict_types=1);
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Firebase\JWT\Key;
require_once('../vendor/autoload.php');

// Models Imports
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ . '/models/Barangay.php';
require_once __DIR__ . '/models/AuthorizedAccount.php';

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }



function getGoogleTokens($code) {
    $clientId = $GLOBALS['client_id'];
    $clientSecret = $GLOBALS['client_secret'];
    $redirectUri = "http://localhost:5173/login";
    // Token endpoint
    $url = "https://oauth2.googleapis.com/token";

    // Data for POST request
    $data = [
        "code" => $code,
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "redirect_uri" => $redirectUri,
        "grant_type" => "authorization_code"
    ];

    // Initialize cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute
    $response = curl_exec($ch);

    // Handle error
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    // Decode JSON response
    return json_decode($response, true);    
}

/** Extract Action */
$action = $_GET['a'] ?? '';



// Authentication & Authorization API
if ($action === 'login')
{
    // Get Inputs
    $identifier = $_POST['identifier'] ?? '';
    $password   = $_POST['password']   ?? '';

    // validate inputs
    if (empty(trim($identifier)) || empty($password)) {
        returnError('Username/Email and password are required.');
    }

    // Try
    try {
        $barangay = Barangay::login($identifier, $password);
        require_once __DIR__ . '/models/Barangay.php';

        returnSuccess([
            'barangay' => $barangay->getAssoc(true),
        ]);
    }
    catch (Exception $e) {
        returnError($e->getMessage());
    }
}

else if ($action === 'authorized')
{
    $sk_official = null;
    if (isset($_COOKIE['jwt'])) {
        $jwt = $_COOKIE['jwt'];
        try {
            $decoded = JWT::decode($jwt, new Key($GLOBALS['secret_key'], 'HS256'));            // ✅ token is valid
            $barangay = Barangay::findBy('id', $decoded->barangayId);
        } catch (Exception $e) {
            // ❌ token is missing/invalid/expired
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }
    } else {
        http_response_code(401);
        echo json_encode(["error" => "No token provided"]);
        exit;
    }


    try {
        returnSuccess([
            'barangay' => $barangay->getAssoc(true),
        ]);
    }
    catch (Exception $e) {
        returnError($e->getMessage());
    }
}

else if($action === 'logout') {
    authorizeRequest(); // Ensure the user is authorized
    
    // Clear the JWT cookie
    setcookie('jwt', '', time() - 3600, '/', '', false, true); // Adjust path and domain as needed
    returnSuccess(['message' => 'Logged out successfully.']);
}






// Authorization using Third Party Accounts (Facebook and Google)
if ($action === 'process')
{
    if(!isset($_POST["code"])) {
        returnError('Invalid code received.', 400);
    }

    $code = $_POST["code"];

    $tokens = getGoogleTokens($code);
    // Get Google public keys
    $jwks = json_decode(file_get_contents("https://www.googleapis.com/oauth2/v3/certs"), true);

    try {
    // Convert Google's JWKS into an array of usable keys
    $keys = JWK::parseKeySet($jwks);

    // Decode and verify Google ID token
    JWT::$leeway = 60; // allow 1 minute clock skew
    $decoded = JWT::decode($tokens['id_token'], $keys);

    // Validate claims 
    if ($decoded->aud !== $GLOBALS['client_id']) {
        throw new Exception("Invalid audience");
    }
    if ($decoded->iss !== "https://accounts.google.com" && $decoded->iss !== "accounts.google.com") {
        throw new Exception("Invalid issue");
    }

    // Extract user info
    $googleId = $decoded->sub;
    $email = $decoded->email ?? null;

    $accounts = AuthorizedAccount::findBy('provider_user_id', $googleId);
    $barangay = $accounts->getBarangay();

    if($accounts) {
        $date   = new DateTimeImmutable();
        $expire_at = $date->modify('+4 week')->getTimestamp();
        $request_data = [
            'iss'  => 'localhost.youth',                    // Issuer
            'exp'  => $expire_at,                           // Expire
            'barangayId' => $accounts->getId(),
            'barangayName' => $barangay->getName(),  
            'barangayUsername' => $barangay->getUsername()                  
        ];

        // Create the Token
        $jwt = JWT::encode($request_data, $GLOBALS['secret_key'], 'HS256');      

        // Create and Set the JWT Cookie
        setcookie(
            "jwt",
            $jwt,
            [
                "path" => "/",
                // Set this to true in production
                "secure" => false,     // only HTTPS
                "httponly" => true,   // JavaScript can’t read it
                "samesite" => "Strict"
            ]
        );


        returnSuccess([
            'barangay' => $barangay->getAssoc(true),
        ]);
    }
    else {
        // TODO: return error
    }


    

    } catch (Exception $e) {
        echo "Token invalid: " . $e->getMessage();
    }
}