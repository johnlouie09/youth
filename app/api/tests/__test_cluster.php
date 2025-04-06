<?php
// Set the content type to JSON.
header('Content-Type: application/json');

// Define the directory containing your images (ensure the path is correct).
$imageDir = rtrim(__DIR__ . '\..\..\..\public\achievements', '/');

// Check if the directory exists.
if (!is_dir($imageDir)) {
    echo $imageDir;
    echo json_encode([]);
    exit;
}

// Scan the directory for files and filter to include only image files.
$files = array_filter(scandir($imageDir), function($file) use ($imageDir) {
    $filePath = $imageDir . '/' . $file;
    return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
});

// Re-index the array and return the result as JSON.
echo json_encode(array_values($files));
