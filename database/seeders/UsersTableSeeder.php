<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id'=>'1',
            'name'=>'Test.Admin',
            'username'=>'admin',
            'email'=>'admin@blog.com',
            'password'=>bcrypt('rootadmin'),
        ]);

        DB::table('users')->insert([
            'role_id'=>'2',
            'name'=>'Test.Author',
            'username'=>'author',
            'email'=>'author@blog.com',
            'password'=>bcrypt('rootauthor'),
        ]);

    }
}
