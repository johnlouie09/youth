<?php
/** imports */
require_once __DIR__ . '/models/Cluster.php';
$cluster = new Cluster(1);

if ($cluster === null) {
    echo "<p style='color: red;'>No one is logged in.</p>";
}
else {
    echo "<p>Logged in:</p>";
    print_r($cluster->getBarangays(true));
}


// ======================================================
echo "</pre>";