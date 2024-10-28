<?php
$uploadDir = 'assets/uploads/';
$files = scandir($uploadDir);

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $filePath = $uploadDir . $file;
    //This assumes filenames are in the format:  username-documentType-otherstuff.extension
    $parts = explode('-', $file);
    if (count($parts) < 2) continue; //Skip files not matching the pattern

    $username = $parts[0];
    $documentType = $parts[1];
    $dateTime = date('YmdHis');
    $newFileName = $username . '-' . $documentType . '-' . $dateTime . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $newFilePath = $uploadDir . $newFileName;

    //Check if file already exists.  If not, rename.
    if (!file_exists($newFilePath)) {
        rename($filePath, $newFilePath);
    }
}
?>
