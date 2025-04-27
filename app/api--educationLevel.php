<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/EducationLevel.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

if ($action === 'fetchEducationLevel')
{
    try {
        $educationLevel = EducationLevel::all(true);
        returnSuccess([
            'educationLevel' =>  $educationLevel
        ]);
    }
    catch (Exception $e) {
        returnError($e->getMessage(), 401);
    }
}