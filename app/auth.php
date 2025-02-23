<?php
session_start();
require_once '../app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(str_replace(' ', '-', $_POST['username']));
    $password = $_POST['password'];

    // First, get the barangay ID based on the barangay name
    $barangay_query = "SELECT id FROM barangays WHERE LOWER(REPLACE(name, ' ', '-')) = ?";
    $stmt = $conn->prepare($barangay_query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $barangay_result = $stmt->get_result();

    if ($barangay_result->num_rows === 1) {
        $barangay = $barangay_result->fetch_assoc();
        $barangay_id = $barangay['id'];

        // Now check if there's an SK chairperson for this barangay
        $sk_query = "SELECT * FROM sk_chairpersons WHERE barangay_id = ?";
        $stmt = $conn->prepare($sk_query);
        $stmt->bind_param('i', $barangay_id);
        $stmt->execute();
        $sk_result = $stmt->get_result();

        if ($sk_result->num_rows === 1) {
            // For now, using a simple password verification
            // In production, you should use password_verify() with hashed passwords
            if ($password === 'sk@'.$username) {
                $sk_chair = $sk_result->fetch_assoc();
                $_SESSION['barangay_id'] = $barangay_id;
                $_SESSION['sk_name'] = $sk_chair['full_name'];
                $_SESSION['barangay_name'] = str_replace('-', ' ', ucwords($username));

                header("Location: dashboard.php");
                exit();
            }
        }
    }

    header("Location: index.php?error=1");
    exit();
}