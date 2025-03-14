<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/Barangays.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

if($action = 'fetchBarangays')
{
    $clusters = new Cluster();
    returnSuccess([
        'clusters' => $clusters->all(true)
    ]);
    
}