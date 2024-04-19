<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table2024_04_14_153217_add_category_id_column_to_blogs('categories')->insert([
            ['name' => '日常', 'created_at' => $now, 'updated_at' => $now],
            ['name' => '成長', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'グッズ', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'その他', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
