<?php

namespace App\Support;

class FileUploadService
{
    /**
     * Safely delete an uploaded file from disk if it exists inside public/uploads or storage.
     * Guarantees default static assets (e.g. /images/) are never deleted.
     */
    public static function deleteUploadFile(?string $urlOrPath): void
    {
        if (empty($urlOrPath)) {
            return;
        }

        // Parse path from full URL or relative path
        $path = parse_url($urlOrPath, PHP_URL_PATH) ?: $urlOrPath;
        $cleanPath = ltrim($path, '/');

        // Prevent path traversal attacks
        if (str_contains($cleanPath, '..')) {
            return;
        }

        // Safety check: Only delete files located inside uploads/ or storage/
        if (str_starts_with($cleanPath, 'uploads/')) {
            $fullPath = public_path($cleanPath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath);
            }
        } elseif (str_starts_with($cleanPath, 'storage/')) {
            $storageSub = substr($cleanPath, strlen('storage/'));
            $fullPath = storage_path('app/public/' . $storageSub);
            if (file_exists($fullPath) && is_file($fullPath)) {
                @unlink($fullPath);
            }
        }
    }

    /**
     * Safely delete multiple files from disk.
     */
    public static function deleteUploadFiles(?array $files): void
    {
        if (empty($files)) {
            return;
        }

        foreach ($files as $file) {
            if (is_string($file)) {
                self::deleteUploadFile($file);
            }
        }
    }
}
