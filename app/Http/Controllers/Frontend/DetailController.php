<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use App\Models\Posts;

class DetailController extends FrontendController
{
    public function index($slug, $id, Request $request, Posts $posts)
    {
    	$id = is_numeric($id) ? $id : 0;
    	$slug = strip_tags($slug);

    	$info = $posts->getDataPostById($id);
    	$info = ($info) ? $info->toArray() : [];
    	//dd($info);

    	if($info){
    		$data = [];
    		$data['detail'] = $info;

    		$tags = $posts->getDataTagsByPostId($id);
    		$tags = json_decode(json_encode($tags),true);
    		$data['tags'] = $tags;

    		$relatedPosts = $posts->getDataRelatedPost($id, $info['categories_id']);
    		$relatedPosts = json_decode(json_encode($relatedPosts),true);
    		$data['relatedPosts'] = $relatedPosts;

    		return view('frontend.detail.index',$data);
    	} else {
    		// chuyen sang trong 404
    	}
    }

    public function updateView($id, Request $request, Posts $posts)
    {
    	// tien hanh update vao db
    	$id = is_numeric($id) ? $id : 0;
    	$detail = Posts::find($id);

    	if($detail){
	    	$count = $detail->view_count;
	    	$posts->updateViewCount($id, $count
	    	);
	    }
    }
}
