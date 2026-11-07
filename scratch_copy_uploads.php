<?php
require __DIR__ . '/vendor/autoload.php';

$sourceDir = __DIR__ . '/storage/app/public/uploads';
$destDir = __DIR__ . '/public/uploads';

if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

if (is_dir($sourceDir)) {
    $files = scandir($sourceDir);
    $copied = 0;
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $srcFile = $sourceDir . '/' . $file;
        $dstFile = $destDir . '/' . $file;
        if (is_file($srcFile)) {
            copy($srcFile, $dstFile);
            $copied++;
        }
    }
    echo "Successfully copied $copied files to public/uploads.\n";
} else {
    echo "Source dir does not exist.\n";
}
