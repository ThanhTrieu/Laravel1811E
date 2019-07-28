<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use App\Models\Posts;
use Illuminate\Support\Facades\Crypt;

class HomeController extends FrontendController
{
    public function index(Posts $post)
    {
    	$data = [];
    	$data['topPosts'] = $post->getTopPostdFocus();

    	$arrIdTopPost = array_column($data['topPosts'], 'id');

    	$lastestPosts = $post->getLastestPostByPage($arrIdTopPost);
    	$mainData = json_decode(json_encode($lastestPosts),true);

    	$data['lastestPosts'] = $mainData['data'] ?? [];
    	$data['paginate'] = $lastestPosts;

    	return view('frontend.home.index', $data);
    }
}
