<?php
/** imports */

require_once __DIR__ . '/../../models/Barangay.php';



$sanf = Barangay::findBy('san-francisco');

if ($sanf === null) {
    echo "<p style='color: red;'>No one is logged in.</p>";
} else {
    echo "<p>Logged in:</p>";
    echo "<pre>";
    print_r($sanf->getAssoc(true));
    echo "</pre>";
}
