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
    	           ->select('p.id','p.title','p.slug','p.sapo','p.publish_date','p.avatar','a.username','a.id as user_id')
    	           ->join('admins as a', 'a.id', '=', 'p.user_id')
    	           ->where('p.status', 1)
    	           ->whereNotIn('p.id', $arrId)
    	           ->orderBy('p.publish_date', 'DESC')
    	           ->paginate(2);
    	return $posts;
    }

    public function getDataPopularPosts()
    {
        $posts = Posts::select('id','title','slug','publish_date','avatar')
                      ->where('status',1)
                      ->limit(3)
                      ->orderBy('view_count','DESC')
                      ->get();
        return $posts;
    }

    public function getDataPostById($id)
    {
        $data = Posts::select('posts.id','posts.status','posts.title','posts.sapo','posts.publish_date','posts.avatar','posts.slug','posts.categories_id','contents.content_web','categories.name as cate_name','admins.username')
                ->join('contents', 'contents.posts_id', '=', 'posts.id')
                ->join('categories', 'categories.id','=','posts.categories_id')
                ->join('admins','admins.id', '=', 'posts.user_id')
                ->where('posts.id',$id)
                ->where('posts.status',1)
                ->first();
        return $data;
    }

    public function getDataTagsByPostId($id)
    {
        $data = DB::table('tags as t')
                ->select('t.name as name_tag','t.id as tag_id','t.slug as slug_tag')
                ->join('post_tag as pt','pt.tags_id','=','t.id')
                ->where('pt.posts_id',$id)
                ->get();
        return $data;
    }

    public function getDataRelatedPost($id, $idCate)
    {
        $data = DB::table('posts as p')
                    ->select('p.id','p.title','p.slug','p.avatar','p.publish_date', 'c.name as name_cate', 'c.slug as cate_slug', 'c.id as cate_id')
                    ->join('categories as c','c.id','=','p.categories_id')
                    ->where('p.categories_id', $idCate)
                    ->where('p.id', '<>', $id)
                    ->limit(3)
                    ->get();
        return $data;
    }

    public function updateViewCount($id, $count)
    {   
        $count++;
        DB::table('posts')
            ->where('id',$id)
            ->update(['view_count' => $count]);
    }

    public function getDataPostByCateId($cateId)
    {
        $data = DB::table('posts as p')
                    ->select('p.id','p.title','p.slug','p.avatar','p.publish_date','c.name as name_category','a.username','a.id as id_author')
                    ->join('categories as c','c.id','=','p.categories_id')
                    ->join('admins as a', 'a.id', '=', 'p.user_id')
                    ->where('p.categories_id',$cateId)
                    ->where('p.status',1)
                    ->orderBy('p.publish_date','DESC')
                    ->paginate(2);
        return $data;
    }

    public function getDataPostByKeyword($keyword)
    {
        $data = DB::table('posts as p')
                    ->select('p.id','p.title','p.slug','p.avatar','p.publish_date','c.name as name_category','a.username','a.id as id_author')
                    ->join('categories as c','c.id','=','p.categories_id')
                    ->join('admins as a', 'a.id', '=', 'p.user_id')
                    ->where('p.title','like','%'.$keyword.'%')
                    ->where('p.status',1)
                    ->orderBy('p.publish_date','DESC')
                    ->paginate(2);
        return $data;
    }
}
