<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        $file = public_path("/seeders/products.csv");

        $records = $this->import_CSV($file);

        foreach ($records as $record) {
            Product::create([
                "id" => $record['id'],
                "category_id" => $record['category_id'],
                "name" => $record['name'],
                "description" => $record['description'],
                "slug" => $record['slug'],
                "price" => $record['price'],
            ]);
        }
    }
}
