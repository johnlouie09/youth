<?php
echo "<pre>";



require_once __DIR__ . '/models/SkOfficial.php';


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




























echo "</pre>";