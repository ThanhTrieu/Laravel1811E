<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    public function posts()
    {
        // 1 danh muc co nhieu bai viet
        return $this->hasMany('App\Models\Posts');
    }

    public function countPostCategory()
    {
        // inner join ORM
        // inner join Query bluider
        $data = Categories::with('posts')->get();
        return $data;
    }

    public function getAllDataCategories()
    {
    	$result = [];
    	$data = Categories::all();
    	if($data){
    		$result = $data->toArray();
    	}
    	return $result;
    }

    public function getDataCategoriesById($id)
    {
        $result = [];
        $data = Categories::find($id);
        if($data){
            $result = $data->toArray();
        }
        return $result;
    }
}
