<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $file = public_path("/seeders/categories.csv");

        $records = $this->import_CSV($file);

        foreach ($records as $record) {
            Category::create([
                "id" => $record['id'],
                "name" => $record['name'],
                "parent_id" => $record['parent_id'],
            ]);
        }
    }

}
