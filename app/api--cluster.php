<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Cluster.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

if ($action === 'fetchClusters') {
    $clusters = new Cluster();
    returnSuccess([
        'clusters' => $clusters->all(true)
    ]);
} else if ($action === "fetchBarangays") {
    $barangayId = $_POST['barangayId'];
    $cluster = new Cluster($barangayId);
    returnSuccess([
        'barangays' => $cluster->getBarangays(true)
    ]);
}
