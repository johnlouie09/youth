<?php
echo "<pre>";


require_once __DIR__ . '/models/Barangay.php';
require_once __DIR__ . '/models/SkOfficial.php';
require_once __DIR__ . '/models/EducationLevel.php';

/** Find By Unique Column */
$barangay = Barangay::findBy('name', 'San Francisco');
if ($barangay !== null) {
    print_r($barangay->getAssoc(true));
}
echo "<hr>";


/** Get all records as object */
$barangays = Barangay::all();
echo "<h1>All Barangay (Objects):</h1>";
print_r($barangays);
echo "<hr>";


/** Find By Unique Column */
$sk_official = SkOfficial::findBy('slug', 'dessa-mare');
if ($sk_official !== null) {
    print_r($sk_official->getAssoc(true));
}
echo "<hr>";


/** Get all records as object */
$sk_officials = SkOfficial::all();
echo "<h1>All SK Officials (Objects):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Get all records as assoc */
$sk_officials = SkOfficial::all(true);
echo "<h1>All SK Officials (Assoc):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Get all records as assoc basic */
$sk_officials = SkOfficial::all(true, true);
echo "<h1>All SK Officials (Assoc Basic):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Find SK Official */
$id = 18;
$sk_official = SkOfficial::find($id);
echo "<h1>SK [id = $id]</h1>";
print_r($sk_official);
echo "<hr>";



/** Get assoc demo */
$id = 19;
$sk_official = SkOfficial::find($id);
if ($sk_official !== null) {
    echo "<h1>SK Assoc [id = $id]</h1>";
    print_r($sk_official->getAssoc());
}
echo "<hr>";


/** Get assoc-basic demo */
$id = 20;
$sk_official = SkOfficial::find($id);
if ($sk_official !== null) {
    echo "<h1>SK Assoc Basic [id = $id]</h1>";
    print_r($sk_official->getAssoc(true));
}
echo "<hr>";

/** Display the Education Background for an SK Official using join query method */
$sk_official = SkOfficial::findBy('slug', 'dessa-mare');
if ($sk_official !== null) {
    echo "<h1>Education Background for SK Official: " . $sk_official->getAssoc()['full_name'] . "</h1>";
    print_r($sk_official->getEducationBackground());
}
echo "<hr>";


$official = SkOfficial::findBy('slug', 'dessa-mare');

if ($official) {
    // official data
    echo "<h1>{$official->getFullName()}</h1>";
    echo "<p>Position: {$official->getPosition()}</p>";

    // education background
    $educationRecords = $official->getEducationBackground();
    foreach ($educationRecords as $record) {
        echo "<h3>{$record['education_level']} ({$record['start_year']}-{$record['end_year']})</h3>";
        echo "<p>School: {$record['school_name']}</p>";
        if (!empty($record['course'])) {
            echo "<p>Course: {$record['course']}</p>";
        }
    }
}
echo "<hr>";






















echo "</pre>";