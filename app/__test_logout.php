<?php
echo "<a href='__test_login.php'>Login</a> | ";
echo "<a href='__test_dashboard.php'>Dashboard</a> | ";
echo "<a href='__test_logout.php'>Logout</a> ";
echo "<hr>";
echo "<h2>Test Logout</h2>";
echo "<p>Manually Logout an SkOfficial</p>";
echo "<hr>";
echo "<pre>";
// ======================================================
require_once __DIR__ . '/models/SkOfficial.php';

SkOfficial::logout();

echo "<p style='color: orange;'>Logged out done.</p>";


// ======================================================
echo "</pre>";