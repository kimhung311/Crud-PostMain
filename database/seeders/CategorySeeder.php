<?php

namespace Database\Seeders;

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
        $date = date('Y-m-d H:i:s');
        $data = [

            ['name' => 'Áo' ,'paren_id' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['name' => ' Quần','paren_id' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Mũ' ,'paren_id' => 3, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Đồ trẻ em','paren_id' => 4, 'created_at' => $date, 'updated_at' => $date],
            
        ];
        DB::table('categories')->insert($data);
    }
}
