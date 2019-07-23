<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
    protected $table = 'posts';

    public function categories()
    {
    	// 1 bai viet thuoc ve 1 danh muc
    	return $this->belongsTo('App\Models\Categories','categories_id');
    }

    public function getTopPostdFocus()
    {
    	// chi lay ra 3 bai viet moi nhat
    	// lay dc ca ten danh muc
    	// lay dc ca ten - avatar tac gia
    	$posts = DB::table('posts as p')
    	           ->select('p.id','p.title','p.sapo','p.publish_date','p.avatar','c.id as cate_id', 'c.name','a.username','a.id as user_id')
    	           ->join('categories as c', 'c.id', '=', 'p.categories_id')
    	           ->join('admins as a', 'a.id', '=', 'p.user_id')
    	           ->where('p.status', 1)
    	           //->offset(0)
    	           ->limit(3)
    	           ->orderBy('p.publish_date', 'DESC')
    	           ->get();
    	$posts = json_decode(json_encode($posts),true);
    	return $posts;
    }

    public function getLastestPostByPage($arrId = [])
    {
    	// $arrId : id cua 3 bai viet moi nhat noi bat
    	$posts = DB::table('posts as p')
    	           ->select('p.id','p.title','p.sapo','p.publish_date','p.avatar','a.username','a.id as user_id')
    	           ->join('admins as a', 'a.id', '=', 'p.user_id')
    	           ->where('p.status', 1)
    	           ->whereNotIn('p.id', $arrId)
    	           ->orderBy('p.publish_date', 'DESC')
    	           ->paginate(2);
    	return $posts;
    }
}
