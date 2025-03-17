<?php
echo "<pre>";

require_once __DIR__ . '/../../models/Barangay.php';

// --- Insert ---
echo "=== Insert Operation ===\n";

$newBarangay = new Barangay();
$newBarangay->setClusterId(1);
$newBarangay->setSlug('test-barangay');
$newBarangay->setName('Test Barangay');

$newBarangay->insert();
echo "Inserted Barangay:\n";
print_r($newBarangay->getAssoc());

// --- Update ---
echo "\n=== Update Operation ===\n";

$newBarangay->setClusterId(2);
$newBarangay->setSlug('updated-barangay');
$newBarangay->setName('Updated Barangay');

$newBarangay->update();

$updatedBarangay = Barangay::find($newBarangay->getId());
echo "Updated Barangay:\n";
print_r($updatedBarangay->getAssoc());

// --- Delete ---
echo "\n=== Delete Operation ===\n";

$newBarangay->delete();

$deletedBarangay = Barangay::find($newBarangay->getId());
if ($deletedBarangay === null) {
    echo "Barangay with ID " . $newBarangay->getId() . " was successfully deleted.\n";
} else {
    echo "Delete failed. Retrieved Barangay:\n";
    print_r($deletedBarangay->getAssoc());
}

echo "</pre>";
