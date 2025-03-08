<?php

require_once __DIR__ . '/../models/SkOfficial.php';

class SkOfficialController {
    /**
     * Processes authentication requests
     *
     * @return void
     */
    public static function authenticate() {
        // Ensure request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::jsonResponse(405, 'Method Not Allowed');
            return;
        }

        // Get and validate input data
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['identifier']) || !isset($data['password'])) {
            self::jsonResponse(400, 'Missing required fields: identifier and password');
            return;
        }

        $identifier = trim($data['identifier']);
        $password = trim($data['password']);
        $remember = isset($data['remember']) ? (bool)$data['remember'] : false;

        // Attempt login
        try {
            $official = SkOfficial::login($identifier, $password, $remember);
            self::jsonResponse(200, 'Authentication successful', [
                'user' => $official->getAssoc(true),
                'authenticated' => true
            ]);
        } catch (Exception $e) {
            self::jsonResponse(401, $e->getMessage());
        }
    }

    /**
     * Handles user logout
     *
     * @return void
     */
    public static function logout() {
        // Check if user is already logged in
        if (SkOfficial::getLoggedIn() === null) {
            self::jsonResponse(400, 'No active session');
            return;
        }

        SkOfficial::logout();
        self::jsonResponse(200, 'Logout successful');
    }

    /**
     * Retrieves the current authenticated user
     *
     * @return void
     */
    public static function getCurrentUser() {
        $official = SkOfficial::getLoggedIn();
        if ($official === null) {
            self::jsonResponse(401, 'Not authenticated');
            return;
        }

        self::jsonResponse(200, 'User retrieved successfully', [
            'user' => $official->getAssoc()
        ]);
    }

    /**
     * Retrieves all SK officials (protected endpoint)
     *
     * @return void
     */
    public static function getAllOfficials() {
        if (!self::isAuthenticated()) {
            return;
        }

        $officials = SkOfficial::all(true);
        self::jsonResponse(200, 'Officials retrieved successfully', [
            'officials' => $officials
        ]);
    }

    /**
     * Retrieves a specific SK official by ID (protected endpoint)
     *
     * @return void
     */
    public static function getOfficialById() {
        if (!self::isAuthenticated()) {
            return;
        }

        // Ensure ID parameter exists
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            self::jsonResponse(400, 'Invalid or missing ID parameter');
            return;
        }

        $id = (int)$_GET['id'];
        $official = SkOfficial::find($id);

        if ($official === null) {
            self::jsonResponse(404, 'Official not found');
            return;
        }

        self::jsonResponse(200, 'Official retrieved successfully', [
            'official' => $official->getAssoc()
        ]);
    }

    /**
     * Updates official information (protected endpoint)
     *
     * @return void
     */
    public static function updateOfficial() {
        if (!self::isAuthenticated()) {
            return;
        }

        // Ensure request method is PUT or POST
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::jsonResponse(405, 'Method Not Allowed');
            return;
        }

        // Get and validate input data
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['id']) || !is_numeric($data['id'])) {
            self::jsonResponse(400, 'Invalid or missing ID field');
            return;
        }

        $id = (int)$data['id'];
        $official = SkOfficial::find($id);

        if ($official === null) {
            self::jsonResponse(404, 'Official not found');
            return;
        }

        // Update fields that are present in the request
        $updated = false;
        $fields = [
            'full_name' => 'setFullName',
            'position' => 'setPosition',
            'contact_number' => 'setContactNumber',
            'email' => 'setEmail',
            'birthday' => 'setBirthday',
            'motto' => 'setMotto',
            'term_start' => 'setTermStart',
            'term_end' => 'setTermEnd'
        ];

        foreach ($fields as $field => $setter) {
            if (isset($data[$field])) {
                $official->$setter($data[$field]);
                $updated = true;
            }
        }

        if (!$updated) {
            self::jsonResponse(400, 'No fields to update were provided');
            return;
        }

        // Save the updated official (assuming we need to add this method to the model)
        try {
            // This would need to be implemented in the SkOfficial model
            if (method_exists($official, 'save')) {
                $official->save();
                self::jsonResponse(200, 'Official updated successfully', [
                    'official' => $official->getAssoc()
                ]);
            } else {
                self::jsonResponse(500, 'Update functionality not implemented');
            }
        } catch (Exception $e) {
            self::jsonResponse(500, 'Failed to update official: ' . $e->getMessage());
        }
    }

    /**
     * Checks if user is authenticated and returns appropriate response if not
     *
     * @return bool
     */
    private static function isAuthenticated() {
        $official = SkOfficial::getLoggedIn();
        if ($official === null) {
            self::jsonResponse(401, 'Authentication required');
            return false;
        }
        return true;
    }

    /**
     * Sends JSON response with appropriate headers
     *
     * @param int $status HTTP status code
     * @param string $message Response message
     * @param array $data Additional data
     * @return void
     */
    private static function jsonResponse($status, $message, $data = []) {
        http_response_code($status);
        header('Content-Type: application/json');

        $response = [
            'status' => $status,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        echo json_encode($response);
        exit;
    }
}