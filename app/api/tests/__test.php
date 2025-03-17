<?php
echo "<pre>";

/**
 * Test script for the models with relationship methods.
 *
 * This script demonstrates:
 * - Finding a record by a unique column.
 * - Fetching all records as objects or associative arrays.
 * - Using many-to-one relationships (e.g., a Barangay getting its parent Cluster, and an SK Official getting its parent Barangay).
 * - Using one-to-many relationships (e.g., a Cluster getting all its Barangays, a Barangay getting all its Events, Projects, and SK Officials, and an SK Official getting all its Achievements and Educations).
 * - Displaying additional related data such as the education background for an SK Official.
 */


require_once __DIR__ . '/../../models/Barangay.php';
require_once __DIR__ . '/../../models/Cluster.php';
require_once __DIR__ . '/../../models/SkOfficial.php';
require_once __DIR__ . '/../../models/Event.php';
require_once __DIR__ . '/../../models/Project.php';
require_once __DIR__ . '/../../models/Achievement.php';
require_once __DIR__ . '/../../models/SkEducation.php';
require_once __DIR__ . '/../../models/EducationLevel.php';

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
    echo "<h1>SK Official: dessa-mare (Assoc)</h1>";
    print_r($sk_official->getAssoc(true));
}
echo "<hr>";


// test for optional parameters on many-to-one relationship: SK Official -> Barangay
if ($sk_official) {
    echo "<h1>Testing SK Official->getBarangay()</h1>";

    // call getBarangay without optional parameters; expect an object.
    $barangayObj = $sk_official->getBarangay();
    echo "getBarangay() without options:\n";
    print_r($barangayObj);
    echo "<br><br>";

    // call getBarangay with assoc = true; expect an associative array.
    $barangayAssoc = $sk_official->getBarangay(true);
    echo "getBarangay(true):\n";
    print_r($barangayAssoc);
    echo "<br><br>";

    // call getBarangay with assoc = true and assoc_basic = true; expect a basic associative array.
    $barangayAssocBasic = $sk_official->getBarangay(true, true);
    echo "getBarangay(true, true):\n";
    print_r($barangayAssocBasic);
    echo "<br><br>";

} else {
    echo "SK Official 'dessa-mare' not found.";
}
echo "<hr>";


/** Get all SK Officials as object */
$sk_officials = SkOfficial::all();
echo "<h1>All SK Officials (Objects):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Get all SK Officials as assoc arrays */
$sk_officials = SkOfficial::all(true);
echo "<h1>All SK Officials (Assoc):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Get all Sk Officials as assoc basic */
$sk_officials = SkOfficial::all(true, true);
echo "<h1>All SK Officials (Assoc Basic):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Find SK Official by ID */
$id = 18;
$sk_official = SkOfficial::find($id);
echo "<h1>SK [id = $id]</h1>";
print_r($sk_official);
echo "<hr>";



/** Get assoc demo for SK Official */
$id = 19;
$sk_official = SkOfficial::find($id);
if ($sk_official !== null) {
    echo "<h1>SK Assoc [id = $id]</h1>";
    print_r($sk_official->getAssoc());
}
echo "<hr>";


/** Get assoc-basic demo for SK Official */
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


/** Display Education Background for an SK Official */
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


/** Relationship Testing: Many-to-One and One-to-Many */

/** Many-to-One: Get the Cluster for a Barangay */
if ($barangay !== null) {
    echo "<h1>Parent Cluster for Barangay '{$barangay->getName()}':</h1>";
    $cluster = $barangay->getCluster();
    print_r($cluster ? $cluster->getAssoc(true) : 'No cluster found.');
    echo "<hr>";
}

/** One-to-Many: Get all Barangays for a Cluster */
if (isset($cluster) && $cluster !== null) {
    echo "<h1>All Barangays in Cluster '{$cluster->getName()}':</h1>";
    $clusterBarangays = $cluster->getBarangays();
    print_r($clusterBarangays);
    echo "<hr>";
}

/** Many-to-One: Get the Barangay for an SK Official */
if ($sk_official !== null) {
    echo "<h1>Parent Barangay for SK Official '{$sk_official->getFullName()}':</h1>";
    $parentBarangay = $sk_official->getBarangay();
    print_r($parentBarangay ? $parentBarangay->getAssoc(true) : 'No barangay found.');
    echo "<hr>";
}

/** One-to-Many: Get all SK Officials for a Barangay */
if ($barangay !== null) {
    echo "<h1>All SK Officials in Barangay '{$barangay->getName()}':</h1>";
    $barangayOfficials = $barangay->getSkOfficials();
    print_r($barangayOfficials);
    echo "<hr>";
}


/** One-to-Many: Get all Events for a Barangay */
if ($barangay !== null) {
    echo "<h1>All Events in Barangay '{$barangay->getName()}':</h1>";
    $events = $barangay->getEvents();
    print_r($events);
    echo "<hr>";
}


/** One-to-Many: Get all Projects for a Barangay */
if ($barangay !== null) {
    echo "<h1>All Projects in Barangay '{$barangay->getName()}':</h1>";
    $projects = $barangay->getProjects();
    print_r($projects);
    echo "<hr>";
}


/** One-to-Many: Get all Achievements for an SK Official */
if ($sk_official !== null) {
    echo "<h1>All Achievements for SK Official '{$sk_official->getFullName()}':</h1>";
    $achievements = $sk_official->getAchievements();
    print_r($achievements);
    echo "<hr>";
}


/** One-to-Many: Get all Achievements for a Barangay */
$barangay = Barangay::findBy('name', 'San Francisco');
if ($barangay !== null) {
    echo "<h1>All Achievements for Barangay '{$barangay->getName()}':</h1>";
    $allAchievements = $barangay->getAllAchievements();
    print_r($allAchievements);
    echo "<hr>";
}


/** One-to-Many: Get all Educations for an SK Official */
if ($sk_official !== null) {
    echo "<h1>All Educations for SK Official '{$sk_official->getFullName()}':</h1>";
    $educations = $sk_official->getEducations();
    print_r($educations);
    echo "<hr>";
}


/** Many-to-One for Event: For each Event in the Barangay, display its parent Barangay */
if (!empty($events)) {
    echo "<h1>Parent Barangay for each Event in Barangay '{$barangay->getName()}':</h1>";
    foreach ($events as $event) {
        // If $event is returned as an object, use it directly; otherwise, create a new object instance.
        $eventObj = is_object($event) ? $event : new Event($event['id']);
        echo "Event: " . $eventObj->getEventName() . "<br>";
        $parent = $eventObj->getBarangay();
        echo "Parent Barangay: " . ($parent ? $parent->getName() : "None") . "<br><br>";
    }
    echo "<hr>";
}


/** Many-to-One for Project: For each Project in the Barangay, display its parent Barangay */
if (!empty($projects)) {
    echo "<h1>Parent Barangay for each Project in Barangay '{$barangay->getName()}':</h1>";
    foreach ($projects as $project) {
        $projectObj = is_object($project) ? $project : new Project($project['id']);
        echo "Project: " . $projectObj->getProjectName() . "<br>";
        $parent = $projectObj->getBarangay();
        echo "Parent Barangay: " . ($parent ? $parent->getName() : "None") . "<br><br>";
    }
    echo "<hr>";
}



echo "</pre>";