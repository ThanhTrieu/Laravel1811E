<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Tag;
use App\Http\Requests\StorePosts as Posts;
use voku\helper\AntiXSS;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdatePosts;

class PostsController extends Controller
{
    public function index(Request $request, AntiXSS $xss)
    {
        $data = [];
        $keyword = $request->keyword;
        $keyword = $xss->xss_clean($keyword);

        $listPosts = DB::table('posts AS p')
                                ->select('p.id','p.title','p.slug','p.sapo','p.publish_date', 'c.name', 'c.id AS cate_id')
                                ->join('categories AS c', 'p.categories_id', '=', 'c.id')
                                ->where(function($query) use ($keyword){
                                    $query->where('p.title', 'LIKE', "%{$keyword}");
                                    $query->orWhere('p.sapo', 'LIKE', '%'.$keyword.'%');
                                    $query->orWhere('p.publish_date', 'LIKE', '%'.$keyword.'%');
                                })
                                ->where('p.status',1)
                                ->paginate(2);

        // paginate(2) : 2 san pham tren 1 trang
        // $listPosts : object sdt class php
        $mainData = json_decode(json_encode($listPosts),true);
        // convert to array

        $data['listPosts'] = $mainData['data'] ?? [];
        $data['keyword']   = $keyword;
        $data['paginate']  = $listPosts;

    	return view('admin.posts.list-post',$data);
    }

    public function createPost(Categories $cate, Tag $tag)
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
        $userId = $request->session()->get('id');

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
            'user_id' => $userId, 
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

    public function editPost($slug, $id, Request $request, Categories $cate, Tag $tag)
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

            $data['post_tag2'] = [];
            foreach($data['post_tag'] as $key => $val){
                $data['post_tag2'][] = $val['tags_id'];
            }

            // thong bao loi upload anh 
            $data['errUpload'] = $request->session()->get('errImg');

            return view('admin.posts.edit-post', $data);
        } else {
            // not found page
            abort(404);
        }
    }

    public function handleEdit($id, UpdatePosts $request)
    {
        $infoPost = DB::table('posts AS p')
                    ->select('p.*', 'c.content_web')
                    ->join('contents AS c', 'p.id' , '=', 'c.posts_id')
                    ->where('p.id', $id)
                    ->first();

        if($infoPost){           
            $title = $request->titlePost;
            $slug = Str::slug($title, '-');
            $sapoPost = $request->sapoPost;
            $contentPost = $request->contentPost;
            $language = $request->language;
            $categories = $request->categories;
            $tags = $request->tags;

            // thuc hien upload file(nguoi dung muon thay doi anh avatar)
            // anh cu - neu nguoi dung ko upload anh thi update lai dung la anh avatar cu
            $avatar = $infoPost->avatar;
            $arrAllowTypeImg = ['image/jpeg','image/png','image/jpg','image/gif','image/bmp'];

            // nguoi dung muon thay anh avatar
            if($request->hasFile('avatarPost')){
                 if($request->file('avatarPost')->isValid()){
                    // kiem tra dinh dang anh
                    // lay ra dinh dang anh
                    $file = $request->file('avatarPost');
                    $typeImg = $file->getClientMimeType();
                    if(in_array($typeImg, $arrAllowTypeImg)){
                        // cho upload
                        // gan lai ten anh moi
                        $avatar = $file->getClientOriginalName();
                        $file->move('upload/images', $avatar);
                    } else {
                        // khong cho upload
                        $request->session()->flash('errImg','Dinh danh anh khong dung');
                        // quay ve lai dung form edit
                        return redirect()->route('admin.editPost',[
                            'slug' => $infoPost->slug,
                            'id' => $id
                        ]);
                    }
                 }
            }

            $publish = $request->publishPost;
            $status = $infoPost->status;
            $publishDate = $infoPost->publish_date;

            if($publish !== 'on'){
                $status = 0;
                // khong cho sua ngay xuat ban bai viet
            }

            // tien hanh update du lieu vao bang posts
            DB::table('posts')
                ->where('id', $id)
                ->update([
                    'title' => $title,
                    'slug' => $slug,
                    'sapo' => $sapoPost,
                    'categories_id' => $categories,
                    'avatar' => $avatar,
                    'status' => $status,
                    'lang_id' => $language,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            // tien hanh update du lieu bang content
            DB::table('contents')
                ->where('posts_id', $id)
                ->update([
                    'content_web' => $contentPost,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            // tien hanh update tags
            if($tags && is_array($tags)){
                // update du lieu
                // xoa di du lieu da ton tai
                DB::table('post_tag')
                    ->where('posts_id', $id)
                    ->delete();

                // insert lai data
                foreach ($tags as $key => $val) {
                    DB::table('post_tag')->insert([
                        'posts_id' => $id,
                        'tags_id' => $val,
                        'primary' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => null
                    ]);
                }

            } else {
                // xoa du lieu
                DB::table('post_tag')
                    ->where('posts_id', $id)
                    ->delete();
            }

            // quay ve trang list posts
            return redirect()->route('admin.listPosts');

        } else {
            // ko thay bai viet
            return redirect()->route('admin.dashboard');
        }
        

    }
}
