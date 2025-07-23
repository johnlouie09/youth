<?php
echo "<pre>";

require_once __DIR__ . '/../../models/Announcement.php';
require_once __DIR__ . '/../../models/Barangay.php';


// retrieve all announcements (using assoc basic format)
$announcements = Announcement::all(true, true);
echo "<h1>All Announcements (Assoc Basic):\n</h1>";
print_r($announcements);
echo "<hr>";

// --- Test the relationship method in Barangay: getAnnouncements() ---
// retrieve a Barangay record
$barangay = Barangay::findBy('name', 'San Francisco');
if ($barangay) {
    echo "<h1>Announcements for Barangay 'San Francisco':\n</h1>";
    $barangayAnnouncements = $barangay->getAnnouncements(true, true);
    print_r($barangayAnnouncements);
} else {
    echo "Barangay 'San Francisco' not found.\n";
}


// Retrieve 10 random announcements (as associative arrays with basic columns)
$randomAnnouncements = Announcement::getRandomAnnouncements(10, true, true);
echo "<h2>Random Announcements for Carousel</h2>";
foreach ($randomAnnouncements as $announcement) {
    echo "Announcement ID: " . $announcement['id'] . "\n";
    // if the img field is stored as a comma-separated string and getAssoc() converts it to an array:
    echo "Images: " . (is_array($announcement['img']) ? implode(', ', $announcement['img']) : $announcement['img']) . "\n";
    echo "-----------------------------\n";
}

echo "</pre>";

