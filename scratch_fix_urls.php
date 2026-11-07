<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = ['services', 'blogs', 'team_members', 'hero_slides', 'gallery_items', 'partners', 'industries'];
    
    foreach ($tables as $table) {
        if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
            $column = in_array($table, ['partners']) ? 'logo_path' : 'image';
            if (\Illuminate\Support\Facades\Schema::hasColumn($table, $column)) {
                \Illuminate\Support\Facades\DB::table($table)
                    ->where($column, 'LIKE', '%interglob-api.ceygen.com%')
                    ->orWhere($column, 'LIKE', '%/storage/uploads/%')
                    ->get()
                    ->each(function ($row) use ($table, $column) {
                        $oldUrl = $row->{$column};
                        $filename = basename($oldUrl);
                        $newUrl = "http://127.0.0.1:8000/uploads/" . $filename;
                        \Illuminate\Support\Facades\DB::table($table)
                            ->where('id', $row->id)
                            ->update([$column => $newUrl]);
                        echo "Updated $table ID {$row->id}: $oldUrl -> $newUrl\n";
                    });
            }
        }
    }
    echo "Database URL cleanup complete.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
