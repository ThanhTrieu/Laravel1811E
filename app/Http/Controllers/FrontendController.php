<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Helpers\Common\BuildTreeCate;

class FrontendController extends Controller
{
    public function __construct()
    {

    	$data = [];
    	$data['name'] = "TrieuNT's Blog";
    	$listCate = DB::table('categories')
    				->where('status',1)
    				->get();
    	$listCate = json_decode(json_encode($listCate),true);
    	$data['cates'] = BuildTreeCate::layoutTreeCategory($listCate);
    	
    	// share du lieu cho tat ca cac view co the dung chung
    	View::share('info',$data);
    }
}
