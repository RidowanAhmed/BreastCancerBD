<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->get()->count() == 0){

            DB::table('users')->insert([
                [
                    'name' => 'Ridowan Ahmed',
                    'role_id' => 1,
                    'photo_id' => 1,
                    'email' => 'ridowan.ahmed.dev@gmail.com',
                    'password' => bcrypt('19951995'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Nova Ahmed',
                    'role_id' => 2,
                    'photo_id' => 2,
                    'email' => 'nova.ahmed@northsouth.edu',
                    'password' => bcrypt('12345678'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Anik Saha',
                    'role_id' => 1,
                    'photo_id' => 3,
                    'email' => 'aniksaha@northsouth.edu',
                    'password' => bcrypt('12345678'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]);
            echo "User seed complete\n";
        } else {
            echo "User table is not empty\n";
        }
    }
}