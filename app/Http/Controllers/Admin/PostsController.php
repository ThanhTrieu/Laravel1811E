<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePosts as Posts;
use voku\helper\AntiXSS;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function index()
    {
        $data = [];
        $listPosts = DB::table('posts AS p')
                                ->select('p.id','p.title','p.slug','p.sapo','p.publish_date', 'c.name', 'c.id AS cate_id')
                                ->join('categories AS c', 'p.categories_id', '=', 'c.id')
                                ->where('p.status',1)
                                ->get();

        $data['listPosts'] = json_decode($listPosts, true);

    	return view('admin.posts.list-post',$data);
    }

    public function createPost(Category $cate, Tag $tag)
    {
    	// lay all data tu bang category do ra view
    	$data = [];
    	$data['cate'] = $cate->getAllDataCategories();
    	$data['tags'] = $tag->getAllDataTags();

    	return view('admin.posts.create-post',$data);
    }

    public function handleCreatePost(Posts $request, AntiXSS $xss)
    {
    	//dd($request->all());
    	$title = $request->titlePost;
        $slug = Str::slug($title, '-');
    	$sapoPost = $request->sapoPost;
    	$contentPost = $request->contentPost;
    	$language = $request->language;
    	$categories = $request->categories;
    	$tags = $request->tags;

    	// anh dai dien
    	// $avatar = $request->avatarPost;
        // kiem tra xem nguoi co upload file ko
        $nameFile = null;
        if($request->hasFile('avatarPost')){
            // kiem tra xem file co loi ko thi upload
            if($request->file('avatarPost')->isValid()){
                // chuan bi cong viec upload
                $file = $request->file('avatarPost');
                $nameFile = $file->getClientOriginalName();
                if($nameFile){
                    $upload = $file->move('upload/images', $nameFile);
                }
            }
        } 
        // het upload file
        
        $publish = $request->publishPost;
        $status = 0;
        $publishDate = null;
        if($publish === 'on'){
            $status = 1;
            $publishDate = date('Y-m-d H:i:s');
        }

        // tien hanh insert data vao bang posts
        $dataInsert = [
            'title' => $title,
            'slug' => $slug,
            'sapo' => $sapoPost,
            'categories_id' => $categories,
            'avatar' => $nameFile,
            'status' => $status,
            'publish_date' => $publishDate,
            'lang_id' => $language,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ];

        DB::table('posts')->insert($dataInsert);
        // lay ra id vua insert vao bang posts
        $idPost = DB::getPdo()->lastInsertId();

        // tien insert du lieu vao bang contents
        $dataContents = [
            'posts_id' => $idPost,
            'content_web' => $contentPost,
            'content_mobile' => null,
            'content_amp' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ];
        DB::table('contents')->insert($dataContents);

        // tien hanh insert vao bang posts_tag
        if($tags && is_array($tags)){
            // nguoi dung co chon tags
            // tien hanh insert
            foreach ($tags as $key => $val) {
                DB::table('post_tag')->insert([
                    'posts_id' => $idPost,
                    'tags_id' => $val,
                    'primary' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => null
                ]);
            }
        }
        // quay ve giao dien list posts
        return redirect()->route('admin.listPosts');
    }

    public function deletePost(Request $request)
    {
        // kiem tra xem day co phai la phuong gui du lieu bang ajax hay ko?
        if($request->ajax()){
            $idPost = $request->id;
            $idPost = is_numeric($idPost) && $idPost > 0 ? $idPost : 0;

            if($idPost > 0){
                $up = DB::table('posts')
                        ->where('id', $idPost)
                        ->update(['status' => 0]);
                if($up){
                    echo "OK";
                } else {
                    echo "FAIL";
                }
            } else {
                echo "ERR";
            }
        }
    }

    public function editPost($slug, $id, Request $request, Category $cate, Tag $tag)
    {
        $id = is_numeric($id) && $id > 0 ? $id : 0;
        // lay du lieu theo id cua bai viet
        $post = DB::table('posts AS p')
                    ->select('p.*', 'c.content_web')
                    ->join('contents AS c', 'p.id' , '=', 'c.posts_id')
                    ->where('p.id', $id)
                    ->first();
        if($post){
            $data = [];
            $data['post'] = $post;
            $data['cate'] = $cate->getAllDataCategories();
            $data['tags'] = $tag->getAllDataTags();

            $post_tag = DB::table('post_tag')
                                    ->select('tags_id')
                                    ->where('posts_id', $id)
                                    ->get();

            $data['post_tag'] = json_decode($post_tag,true);

            foreach($data['post_tag'] as $key => $val){
                $data['post_tag2'][] = $val['tags_id'];
            }
            return view('admin.posts.edit-post', $data);
        } else {
            // not found page
            abort(404);
        }
    }
}
