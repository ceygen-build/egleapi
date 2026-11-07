<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== TEAM MEMBERS IMAGES ===\n";
    foreach (\Illuminate\Support\Facades\DB::table('team_members')->get() as $t) {
        echo "ID {$t->id} [{$t->name}]: {$t->image}\n";
    }

    echo "\n=== SERVICES IMAGES ===\n";
    foreach (\Illuminate\Support\Facades\DB::table('services')->get() as $s) {
        echo "ID {$s->id} [{$s->title}]: {$s->image}\n";
    }

    echo "\n=== BLOGS IMAGES ===\n";
    foreach (\Illuminate\Support\Facades\DB::table('blogs')->get() as $b) {
        echo "ID {$b->id} [{$b->title}]: {$b->image}\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
