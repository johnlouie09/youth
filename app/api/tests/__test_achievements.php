<?php
echo "<pre>";

// Include necessary models
require_once __DIR__ . '/../../models/Achievement.php';
require_once __DIR__ . '/../../models/SkOfficial.php';  // Required for join
require_once __DIR__ . '/../../models/Barangay.php';    // In case filtering is needed

// Retrieve all achievements (with associated SK Official full name)
$achievements = Achievement::all(true, true);

echo "=== All Achievements ===\n";
foreach ($achievements as $achievement) {
    echo "Title: " . $achievement['title'] . "\n";
    echo "Subtitle: " . $achievement['subtitle'] . "\n";
    // Instead of showing sk_official_id, we expect to see sk_official_name:
    echo "Official Name: " . $achievement['sk_official_name'] . "\n";
    echo "Date: " . $achievement['date'] . "\n";
    echo "Info: " . $achievement['info'] . "\n";
    echo "-----------------------------\n";
}

echo "</pre>";

