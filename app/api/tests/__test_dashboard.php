<?php
echo "<a href='__test_login.php'>Login</a> | ";
echo "<a href='__test_dashboard.php'>Dashboard</a> | ";
echo "<a href='__test_logout.php'>Logout</a> ";
echo "<hr>";
echo "<h2>Test Dashboard</h2>";
echo "<p>Displays the currently logged-in SkOfficial</p>";
echo "<hr>";
echo "<pre>";
// ======================================================
require_once __DIR__ . '/models/SkOfficial.php';


$sk_official = SkOfficial::getLoggedIn();
if ($sk_official === null) {
    echo "<p style='color: red;'>No one is logged in.</p>";
}
else {
    echo "<p>Logged in:</p>";
    print_r($sk_official->getAssoc());
}


// ======================================================
echo "</pre>";