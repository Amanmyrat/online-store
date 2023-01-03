<?php

namespace Database\Seeders;

use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Schema;

class ProductSpecificationSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ProductSpecification::truncate();
        Schema::enableForeignKeyConstraints();

        $file = public_path("/seeders/product_specifications.csv");

        $records = $this->import_CSV($file);

        foreach ($records as $record) {
            ProductSpecification::create([
                "id" => $record['id'],
                "product_id" => $record['product_id'],
                "name" => $record['name'],
                "value" => $record['value'],
            ]);
        }
    }
}
