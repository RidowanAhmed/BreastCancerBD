<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            UserTableSeeder::class,
            RoleTableSeeder::class,
            PhotoTableSeeder::class,
            MeetingTableSeeder::class,
            LocationTableSeeder::class,
        ]);
    }
}
