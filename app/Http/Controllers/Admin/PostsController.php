<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePosts as Posts;
use voku\helper\AntiXSS;

class PostsController extends Controller
{
    public function index()
    {
    	return view('admin.posts.list-post');
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
    	$sapoPost = $request->sapoPost;
    	$contentPost = $request->contentPost;
    	$language = $request->language;
    	$categories = $request->categories;
    	$tags = $request->tags;

    	// anh dai dien
    	$avatar = $request->avatarPost;
    }
}
