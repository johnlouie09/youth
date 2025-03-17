<?php
echo "<pre>";

require_once __DIR__ . '/models/SkOfficial.php';

// query dessa-mare
$sk_official = SkOfficial::findBy('slug', 'dessa-mare');

echo "<h2>Info of SKOfficial:</h2>";
print_r($sk_official->getAssoc());

echo "<h3>Sending Test Email...</h3>";
if ($sk_official->sendHelloEmail()) {
    echo "<h3 style='color: green'>Email Sent!</h3>";
}