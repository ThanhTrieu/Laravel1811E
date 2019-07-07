<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// su dung thu vien DB de thao tac voi database
use Illuminate\Support\Facades\DB;
// nap model vao controller
use App\Models\Admin;

class QueryController extends Controller
{
    public function select()
    {
    	// thuc hanh cac cau lenh query
    	// 1 - lay all du lieu
    	// SELECT * FROM admins;
    	// tra ve object stdclass php
    	$dt = DB::table('admins')->get();

    	// chuyen ve mang
    	$dt = json_decode($dt, true);
    	/*
    	foreach ($dt as $key => $val) {
    		//echo $val->id;
    		echo $val['id'];
    		echo "<br/>";
    	}
    	dd($dt);
    	*/

    	// 2 - where dieu kien
    	// SELECT name FROM categories WHERE id = 30 OR id = 4 OR name= 'abc' OR status = 1;
    	$dt2 = DB::table('categories')
    			->select('name')
    			->where('id',30)
    			->orWhere(['id'=> 4, 'name' => 'abc', 'status' => 1])
    			// ->orWhere('id',4)
    			// ->orWhere('name','abc')
    			// ->orWhere('status',1)
    			->first(); // tra ve 1 dong du lieu
    			// chinh la fetch cua pdo
    	// tra ve object
    	//dd($dt2->name);
    	
    	// SELECT a.username, a.password, a.role FROM admins AS a WHERE a.username = 'sas' AND a.password = '1212' AND a.status = 1;
    	$dt3 = DB::table('admins AS a')
    				->select('a.username','a.password','a.role')
    				->where([
    					'a.username' => 'admin_1',
    					'a.password' => 'vUHHlqAq',
    					'a.status' => 1
    				])
    				// ->where('a.username','admin_1')
    				// ->where('a.password','vUHHlqAq')
    				// ->where('a.status',1)
    				->first();
    	//dd($dt3);
    	
    	// dem so dong du lieu trong bang database
    	$countPost = DB::table('posts')->count();
    	//dd($countPost);
    	// lay ra id lon nhat hoac nho nhat
    	$maxId = DB::table('posts')->max('id');
    	$minId = DB::table('posts')->min('id');
    	$avg   = DB::table('posts')->avg('id');
    	$sum   = DB::table('posts')->sum('id');
    	//dd($maxId, $minId, $avg, $sum);

    	// SELECT * FROM posts WHERE id NOT IN(1,2,3);
    	$dt4 = DB::table('posts')
    				->select('*')
    				//->whereIn('id',[1,2,3])
    				->where('status','<>',0)
    				->whereNotIn('id',[1,2,3])
    				->get();
    	//dd($dt4);
    	// SELECT * FROM tags WHERE name LIKE '%ly%' OR slug LIKE '%abc%';
    	$dt5 = DB::table('tags')
    				->select('*')
    				->where('name','LIKE','%ly%')
    				->orWhere('slug', 'LIKE', '%abc%')
    				->get();
    	//dd($dt5);
    	// SELECT a.title, b.content_web FROM posts AS a
    	// INNER JOIN contents AS b ON a.id = b.posts_id
    	// WHERE a.id = 5; 
        
        // insert data to table tags
        /*
        $insert = DB::table('tags')->insert([
            'name' => 'Lap Trinh Laravel',
            'slug' => 'lap-trinh-laravel',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ]);
         
        if($insert){
            dd('OK');
        } else {
            dd('ERR');
        }
        */
       // update data to table tags
       /*
       $up = DB::table('tags')
                ->where('id',6)
                ->update([
                    'name' => 'Lap Trinh PHP'
                ]);
        if($up){
            dd('OK');
        } else {
            dd('ERR');
        }
        */
       // delete data from table tags
       /*
       $del = DB::table('tags')
                ->where('id',6)
                ->delete();
        if($del){
            dd('OK');
        } else {
            dd('ERR');
        }
        */
    }

    public function demoOrm(Admin $admin)
    {
        // trieu goi ham lay du lieu tu phia model
        $data = $admin->getAllData();
        //dd($data);
        $dt = $admin->getDataByCondition(1);
        dd($dt);
    }
}
