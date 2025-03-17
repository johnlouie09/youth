<?php
echo "<a href='__test_login.php'>Login</a> | ";
echo "<a href='__test_dashboard.php'>Dashboard</a> | ";
echo "<a href='__test_logout.php'>Logout</a> ";
echo "<hr>";
echo "<h2>Test Login</h2>";
echo "<p>Manually Login an SkOfficial</p>";
echo "<hr>";
echo "<pre>";
// ======================================================
require_once __DIR__ . '/../../models/SkOfficial.php';


$username = 'irish';
$email    = 'irish@example.com';
$password = '123';
$remember = false;

try {
    $sk_official = SkOfficial::login($username, $password, $remember);
    echo "<p style='color: green'>" . $sk_official->getFullName() . " logged in! [remembered = " . ($remember ? 'YES' : 'NO') . "]</p>";
}
catch (Exception $e) {
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
}


// ======================================================
echo "</pre>";