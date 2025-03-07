<?php

class SkOfficial
{
    private static $conn;
    private static $table = 'sk_officials';

    /*********************************************************************************************
     * Initialize database connection
     *
     * @return mysqli Database connection
     */
    private static function getConnection()
    {
        if (!isset(self::$conn)) {
            // include database configuration
            require_once '../app/config/database.php';

            self::$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }

        return self::$conn;
    }

    /*********************************************************************************************
     * Authenticate user login
     *
     * @param string $username Username
     * @param string $password Password
     * @return array|false User data if authenticated, false otherwise
     */
    public static function login($username, $password)
    {
        $conn = self::getConnection();

        // Prepare the query to check admin_users table
        $query = "SELECT * FROM admin_users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();

            // Verify password
            if (password_verify($password, $user['password']) || $user['password'] === $password) {
                // Password is correct, create session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = ($user['username'] === 'admin');
                $_SESSION['logged_in'] = true;

                // Update last login time (optional)
                $updateQuery = "UPDATE admin_users SET last_login = NOW() WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("i", $user['id']);
                $updateStmt->execute();
                $updateStmt->close();

                return $user;
            }
        } else {
            $stmt->close();
        }

        return false;
    }

    /*********************************************************************************************
     * Log out the current user
     *
     * @return void
     */
    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    /*********************************************************************************************
     * Check if user is logged in
     *
     * @return bool True if logged in, false otherwise
     */
    public static function isLoggedIn()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /*********************************************************************************************
     * Check if current user is an admin
     *
     * @return bool True if admin, false otherwise
     */
    public static function isAdmin()
    {
        if (!self::isLoggedIn()) {
            return false;
        }

        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }
}
