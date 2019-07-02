<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=1; $i <=5 ; $i++) { 
    		DB::table('categories')->insert([
	        	'name' => Str::random(5),
	        	'slug' => Str::random(5),
	        	'parent_id' => 0,
	        	'status' => 1,
	        	'created_at' => date('Y-m-d H:i:s'),
	        	'updated_at' => null
        	]);
    	}
        
    }
}
