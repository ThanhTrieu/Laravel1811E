<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use voku\helper\AntiXSS;
use App\Models\Posts;

class SearchController extends FrontendController
{
    public function index(
    	Request $request,
    	AntiXSS $xss,
    	Posts $post
    ) {
    	$keyword = $request->q;
    	$keyword = $xss->xss_clean($keyword);
    	$listPosts = $post->getDataPostByKeyword($keyword);
    	$mainData = json_decode(json_encode($listPosts),true);

    	$data['lstSearch'] = $mainData['data'] ?? [];
    	$data['keyword'] = $keyword;
    	$data['paginate'] = $listPosts;

    	return view('frontend.search.index',$data);

    }
}
