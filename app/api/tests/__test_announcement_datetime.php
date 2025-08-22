<?php
echo "<pre>";

require_once __DIR__ . '/../../models/Announcement.php';
require_once __DIR__ . '/../../models/AnnouncementDatetime.php';
require_once __DIR__ . '/../../models/Barangay.php';

// --- Load the announcement you want to update ---
$announcement = new Announcement(2);

echo "<h1>Before Update (Announcement ID: 2)</h1>\n";
print_r($announcement->getAssoc(true));

// --- Update core fields ---
$announcement->setBarangayId(1);
$announcement->setTitle("Youth Leadership Bootcamp 2025");
$announcement->setDescription("A 3-day leadership training camp...");
$announcement->setWhat("Workshops, talks");
$announcement->setWho("Youth leaders");
$announcement->setWhy("To enhance leadership");
$announcement->setWhere("Community Center");
$announcement->setIsFeatured(1);
$announcement->setImg("interzone_bb.jpg");

// Save update
$announcement->update();

// --- Handle datetimes like API does ---
$newDatetimes = [
    ["id" => 12, "date" => "2025-02-15", "start" => "16:35", "end" => "19:30"],
    ["id" => 13, "date" => "2025-04-09", "start" => "08:00:00", "end" => "17:00:00"],
    ["id" => null, "date" => "2025-09-01", "start" => "10:00:00", "end" => "12:00:00"],
];

// Get existing datetimes (objects)
$existingDatetimes = AnnouncementDatetime::getByAnnouncement(2);
$existingMap = [];

echo "<h2>Existing Datetimes for Announcement ID: 2 (before update)</h2>\n";
print_r(array_map(fn($d) => $d->getAssoc(), $existingDatetimes));

foreach ($existingDatetimes as $dt) {
    $existingMap[$dt->getId()] = $dt; // ✅ store by ID
}

$usedIds = [];

foreach ($newDatetimes as $dt) {
    // Normalize times → HH:mm:ss
    $start = strlen($dt['start']) === 5 ? $dt['start'] . ':00' : $dt['start'];
    $end   = strlen($dt['end']) === 5   ? $dt['end']   . ':00' : $dt['end'];

    if (!empty($dt['id']) && isset($existingMap[$dt['id']])) {
        // 🔄 Update existing datetime
        $adt = new AnnouncementDatetime($dt['id']);
        $adt->setDate($dt['date']);
        $adt->setStartTime($start);
        $adt->setEndTime($end);
        $adt->update();

        $usedIds[] = $dt['id'];
        echo "🔄 Updated datetime ID {$dt['id']}\n";
    } else {
        // ➕ Insert new datetime
        $adt = new AnnouncementDatetime();
        $adt->setAnnouncementId(2);
        $adt->setDate($dt['date']);
        $adt->setStartTime($start);
        $adt->setEndTime($end);
        $adt->insert();

        echo "➕ Inserted new datetime {$dt['date']} {$start}-{$end}\n";
    }
}

// 🗑️ Delete unused datetimes
foreach ($existingMap as $id => $dt) {
    if (!in_array($id, $usedIds)) {
        $delDt = new AnnouncementDatetime($id);
        $delDt->delete();
        echo "🗑️ Deleted datetime ID {$id}\n";
    }
}

// --- Verify after update ---
echo "<h1>After Update (Announcement ID: 2)</h1>\n";
$updated = new Announcement(2);
print_r($updated->getAssoc(true));

echo "<h2>Datetimes for Announcement ID: 2</h2>\n";
print_r(array_map(fn($d) => $d->getAssoc(), AnnouncementDatetime::getByAnnouncement(2)));

echo "</pre>";
