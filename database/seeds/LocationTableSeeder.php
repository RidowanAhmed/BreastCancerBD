<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('locations')->get()->count() == 0){

            DB::table('locations')->insert([
                [
                    'user_id' => 1,
                    'position' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 2,
                    'position' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 3,
                    'position' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);
            echo "Location seed complete\n";
        } else {
            echo "Locations table is not empty\n";
        }
    }
}
