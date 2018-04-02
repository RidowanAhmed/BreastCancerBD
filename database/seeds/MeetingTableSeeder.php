<?php

use Illuminate\Database\Seeder;

class MeetingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('meetings')->get()->count() == 0){

            DB::table('meetings')->insert([
                [
                    'user_id' => 1,
                    'users' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 2,
                    'users' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'user_id' => 3,
                    'users' => '{}',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);
            echo "Meetings seed complete\n";
        } else {
            echo "Meetings table is not empty\n";
        }

    }
}
