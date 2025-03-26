<?php
echo "<pre>";

// include necessary models
require_once __DIR__ . '/../../models/Achievement.php';
require_once __DIR__ . '/../../models/SkOfficial.php';
require_once __DIR__ . '/../../models/Barangay.php';

// retrieve all achievements (with associated SK Official full name)
$achievements = Achievement::all(true, true);

echo "<h1>All Achievements</h1>";
foreach ($achievements as $achievement) {
    echo "Title: " . $achievement['title'] . "\n";
    echo "Subtitle: " . $achievement['subtitle'] . "\n";
    // instead of showing sk_official_id, we expect to see sk_official_name:
    echo "Official Name: " . $achievement['sk_official_name'] . "\n";
    echo "Date: " . $achievement['date'] . "\n";
    echo "Info: " . $achievement['info'] . "\n";
    echo "-----------------------------\n";
}

echo "</pre>";

