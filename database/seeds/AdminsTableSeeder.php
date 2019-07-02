<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i= 1; $i <= 10; $i++) { 
        	DB::table('admins')->insert([
        		'username' => 'admin_' . $i,
        		'password' => Str::random(8),
        		'email' => Str::random(5) . '@gmail.com',
        		'role' => 1,
        		'status' => 1,
        		'gender' => 1,
        		'phone' => rand(10,11),
        		'add' => Str::random(6),
        		'created_at' => date('Y-m-d H:i:s'),
        		'updated_at' => null
        	]);
        }
    }
}
