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
            array('name' => 'Hassan Murad' , 'role'=>1 , 'password' => bcrypt(123456789) ,'email' => 'hassan2109f@aptechgdn.net' ,'email_verified_at' => Carbon::now(), 'username' => 'Hassan_murad')
        );
    }
}
