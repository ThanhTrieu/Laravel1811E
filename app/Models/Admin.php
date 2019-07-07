<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    // dinh nghia model lam viec voi bang du lieu nao
    protected $table = 'admins';

    // truy van database theo chuan ORM laravel
   	
   	public function getAllData()
   	{
   		$data = Admin::all(); // tra ve du lieu la object
   		// DB::table('admins')->get();
   		if($data){
   			$data = $data->toArray();
   		}
   		return $data;
   	}

   	public function getDataByCondition($id = 0)
   	{
   		//$data = Admin::find($id);
   		// DB::table('admins')
   		// 	   -> where('id', $id)
   		// 	   ->first();
   		$data = Admin::select('*')
   					->where('status', 1)
   					->get();
   		//$data = DB::table('tags')->get();
   		// convert to array
   		if($data){
   			$data = $data->toArray();
   		}
   		return $data;
   	}

    public function loginAdmin($user, $pass)
    {
      $resutl = [];
      $data = Admin::select('*')
                    ->where([
                      'username' => $user,
                      'password' => $pass,
                      'status' => 1,
                      'role' => -1
                    ])
                    ->first();
      if($data){
        $resutl = $data->toArray();
      }
      return $resutl;
    }
}
