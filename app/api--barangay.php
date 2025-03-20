<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Barangay.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

if($action === 'fetchBarangays')
{
    $clusters = new Cluster();
    returnSuccess([
        'clusters' => $clusters->all(true)
    ]);
}
else if($action === 'barangayInfo') {
    $barangay_id = $_POST['barangayId'];
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'barangayInfo' => $barangay->getAssoc(true),
    ]);
}
else if($action === 'sk-officials') {
    $barangay_id = $_POST['barangayId'] ?? '';
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'skChairman' => $barangay->getSkChairman(true),
        'skMembers' => $barangay->getSkMembers(true, true)
    ]);
}
else if($action === 'achievements') {
    $barangay_id = $_POST['barangayId'] ?? '';
    $barangay = new Barangay($barangay_id);
    returnSuccess([
        'achievements' => $barangay->getAllAchievements(true, false),
    ]);
}