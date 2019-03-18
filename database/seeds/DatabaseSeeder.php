<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'Organizer',
            'email' => 'organizer@domain.com',
            'password' => bcrypt('password'),
            'role' => \App\User::USER_ROLE_ORGANIZER,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Organizer2',
            'email' => 'organizer2@domain.com',
            'password' => bcrypt('password'),
            'role' => \App\User::USER_ROLE_ORGANIZER,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
