<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            array('name' => 'Muhammad Zuhaib' , 'role'=>1 , 'password' => bcrypt(123456789) ,'password_txt' => 123456789,'email' => 'zuhaib.pbhub002@gmail.com' ,'email_verified_at' => Carbon::now(), 'username' => 'm_zuhaib')
        );
    }
}
