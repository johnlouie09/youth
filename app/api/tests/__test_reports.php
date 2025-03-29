<?php
echo "<pre>";

require_once __DIR__ . '/../../models/SkOfficial.php';
require_once __DIR__ . '/../../models/Achievement.php';
require_once __DIR__ . '/../../models/Announcement.php';

// Test 1: SK Official Position Count
echo "<h2>Overall Position Count (All Barangays)</h2>";
try {
    $allCounts = SkOfficial::getPositionCount();
    print_r($allCounts);
} catch (Exception $e) {
    echo "Error in getPositionCount(): " . $e->getMessage() . "\n";
}
echo "<hr>";

echo "<h2>Position Count for Barangay with slug 'san-francisco'</h2>";
try {
    $barangayCounts = SkOfficial::getPositionCount('san-francisco');
    print_r($barangayCounts);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "<hr>";

// Test 2: Monthly/Annual Achievements Summary for a Specific Barangay
echo "<h2>Monthly/Annual Achievements Summary for Barangay 'san-francisco'</h2>";
try {
    // pass the barangay slug to filter the summary
    $summary = Achievement::getMonthlySummary('san-francisco');
    echo "Monthly Summary:\n";
    print_r($summary['monthly']);
    echo "\nAnnual Summary:\n";
    print_r($summary['annual']);
} catch (Exception $e) {
    echo "Error in getMonthlySummary(): " . $e->getMessage() . "\n";
}
echo "<hr>";

// Test 3: Annual Announcements Count for a Specific Barangay and Year
echo "<h2>Annual Announcements Count for 2025 in Barangay 'san-francisco'</h2>";
try {
    // now getAnnualCount() expects a barangay slug and a year
    $annualCount = Announcement::getAnnualCount('san-francisco', 2025);
    echo "Total Announcements in 2025 for 'san-francisco': " . $annualCount . "\n";
} catch (Exception $e) {
    echo "Error in getAnnualCount(): " . $e->getMessage() . "\n";
}

echo "</pre>";
