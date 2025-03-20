<?php
echo "<pre>";

require_once __DIR__ . '/../../models/SkOfficial.php';

$sk_official = SkOfficial::findBy('slug', 'dessa-mare');

if (!$sk_official) {
    echo "SK Official not found.";
    exit;
}

echo "<h2>Info of SK Official:</h2>";
print_r($sk_official->getAssoc());

echo "<h3>Sending Password Reset Email...</h3>";
try {
    if ($sk_official->sendPasswordResetEmail()) {
        echo "<h3 style='color: green'>Password Reset Email Sent!</h3>";
    } else {
        echo "<h3 style='color: red'>Failed to send Password Reset Email.</h3>";
    }
} catch (Exception $e) {
    echo "<h3 style='color: red'>Error: " . $e->getMessage() . "</h3>";
}
