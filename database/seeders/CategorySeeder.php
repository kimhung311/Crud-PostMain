<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Adapters\Phpunit\Style;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $date = date('Y-m-d H:i:s');
        $data = [

            [
                'name' => 'Tủ ', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',

            ],
            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],

            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],
            [
                'name' => ' Giường', 'created_at' => $date, 'updated_at' => $date,
                'thumbnail' => 'products/1.jpg',
            ],


        ];

        DB::table('categories')->insert($data);
    }
}