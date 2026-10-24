<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['description' => 'Teclado USB', 'price' => 19.95, 'stock' => 12], ['description' => 'Mouse inalámbrico', 'price' => 12.50, 'stock' => 25], ['description' => 'Memoria USB 64 GB', 'price' => 8.75, 'stock' => 30]] as $p) {
            Product::firstOrCreate(['description' => $p['description']], $p);
        }
    }
}
