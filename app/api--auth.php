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
if ($action === 'process-google')
{
    // 1. Create a provider (Google example)
    $provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => $GLOBALS['client_id_google'],
    'clientSecret' => $GLOBALS['client_secret_google'],
    'redirectUri'  => 'http://localhost:5173/login',
    ]);


    // 2. Redirect user to Google login
    if(!isset($_POST["code"])) {
        $authUrl = $provider->getAuthorizationUrl();
        header('Location: ' . $authUrl);
        returnError('Invalid code received.', 400);
        exit;
    }

    // 3. Handle callback: exchange code for access token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_POST['code']
    ]);

    $user = $provider->getResourceOwner($token);
    $data = $user->toArray();

    // Extract user info
    $googleId = $user->getId();
    $email = $data['email'] ?? null;

    // 4. Find the Account in the Database
    $accounts = AuthorizedAccount::findBy('provider_user_id', $googleId);

    if(!$accounts) {
        returnError("This Google Account is not Authorized. Please contact the developer if you want to be authorized. Thank you :>", 400);
    }

    $barangay = $accounts->getBarangay();

    // 5. Issue your own JWT/cookie
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
}

// Authorization using Third Party Accounts (Facebook)
else if ($action === 'process-facebook')
{
    // 1. Create a provider
    $provider = new League\OAuth2\Client\Provider\Facebook([
    'clientId'     => $GLOBALS['client_id_facebook'],
    'clientSecret' => $GLOBALS['client_secret_facebook'],
    'graphApiVersion' => 'v23.0',
    'redirectUri'  => 'http://localhost:5173/login',
    ]);


    // 2. Redirect user to Facebook login
    if(!isset($_POST["code"])) {
        $authUrl = $provider->getAuthorizationUrl();
        header('Location: ' . $authUrl);
        returnError('Invalid code received.', 400);
        exit;
    }

    // 3. Handle callback: exchange code for access token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_POST['code']
    ]);

    $user = $provider->getResourceOwner($token);
    $data = $user->toArray();

    // Extract user info
    $googleId = $user->getId();
    $email = $data['email'] ?? null;

    // 4. Find the Account in the Database
    $accounts = AuthorizedAccount::findBy('provider_user_id', $googleId);
    $barangay = $accounts->getBarangay();

    // 5. Issue your own JWT/cookie
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

}
