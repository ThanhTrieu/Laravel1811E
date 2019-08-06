<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use App\Models\Posts;
use App\Models\Categories;

class CategoryController extends FrontendController
{
    public function index(
    	$slug,
    	$id,
    	Request $request,
    	Posts $post,
    	Categories $cate
    ) {
    	$id = is_numeric($id) ? $id : 0;
    	$paginate = $post->getDataPostByCateId($id);
    	$mainData = json_decode(json_encode($paginate),true);
    	$infoCate = $cate->getDataCategoriesById($id);

    	$data = [];
    	$data['listCate'] = $mainData['data'] ?? [];
    	$data['paginate'] = $paginate;
    	$data['infoCate'] = $infoCate;
    	$data['slugCate'] = $slug;

    	return view('frontend.category.index',$data);
    }
}
