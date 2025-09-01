<?php

/** Check Guard Constant */
if (!defined('__BASE')) { exit(); }

/** imports */
require_once __DIR__ . '/models/SkEducation.php';

/** Extract Action */
$action = $_GET['a'] ?? '';

if ($action === 'fetchEducationTypes')
{
    try {
        $educationTypes = SkEducation::fetchEducationTypes();
        returnSuccess([
            'educationTypes' =>  $educationTypes
        ]);
    }
    catch (Exception $e) {
        returnError($e->getMessage(), 401);
    }
}