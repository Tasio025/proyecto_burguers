<?php
require 'bootstrap/app.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement('ALTER TABLE clientes CHANGE COLUMN apellido direccion VARCHAR(150) NOT NULL');
    echo "✓ Columna apellido cambiada a direccion correctamente\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
