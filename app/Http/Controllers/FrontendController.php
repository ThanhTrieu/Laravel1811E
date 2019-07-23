<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Helpers\Common\BuildTreeCate;
use Illuminate\Support\Facades\Route;
use App\Models\Categories;
use App\Models\Tag;

class FrontendController extends Controller
{
    public function __construct(Categories $cate, Tag $tag)
    {

    	$data = [];
    	$data['name'] = "TrieuNT's Blog";
    	$listCate = DB::table('categories')
    				->where('status',1)
    				->get();
    	$listCate = json_decode(json_encode($listCate),true);
    	$data['cates'] = BuildTreeCate::layoutTreeCategory($listCate);

        $data['listCate'] = $cate->countPostCategory();

        $data['listTag'] = $tag->getAllDataTags();
    	
    	// share du lieu cho tat ca cac view co the dung chung
        // kiem tra neu la trang chu (homepage moi hien thi slider anh)
        $data['homePage'] = Route::currentRouteName();
        //dd($data['homePage']); 

    	View::share('info',$data);
    }
}
