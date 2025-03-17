<?php
echo "<pre>";

require_once __DIR__ . '/../../models/Barangay.php';

$barangay = Barangay::findBy('name', 'San Francisco');

if ($barangay) {
    echo "<h1>Testing getSkChairman()</h1>";
    // test getSkChairman() with assoc parameters
    $chairmanAssoc = $barangay->getSkChairman(true, true);
    echo "SK Chairperson (assoc basic):\n";
    print_r($chairmanAssoc);
    echo "<hr>";

    echo "<h1>Testing getSkMembers() - Excluding Chairman (default)</h1>";
    // test getSkMembers() with default excludeChairman = true
    $membersExcluding = $barangay->getSkMembers();
    echo "SK Members (excluding chairman):\n";
    print_r($membersExcluding);
    echo "<hr>";

    echo "<h1>Testing getSkMembers() - Including Chairman</h1>";
    // test getSkMembers() with excludeChairman set to false, including the chairman
    $membersIncluding = $barangay->getSkMembers(false);
    echo "SK Members (including chairman):\n";
    print_r($membersIncluding);
    echo "<hr>";
} else {
    echo "Pasensya di masumpungan yung barangay :(.\n";
}

echo "</pre>";
