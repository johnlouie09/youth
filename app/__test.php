<?php
echo "<pre>";



require_once __DIR__ . '/models/SkOfficial.php';


/** Get all records as object */
$sk_officials = SkOfficial::all();
echo "<h1>All SK Officials (Objects):</h1>";
print_r($sk_officials);
echo "<hr>";


/** Get all records as object */
$sk_officials = SkOfficial::all(true);
echo "<h1>All SK Officials (Assoc):</h1>";
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




























echo "</pre>";