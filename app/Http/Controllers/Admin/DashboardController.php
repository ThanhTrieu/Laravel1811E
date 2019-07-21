<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Category\BuildCategory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

	public function __construct()
	{
        $listCat = DB::table('categories')->get();
        $listCat = BuildCategory::buidTreeCategoryData($listCat, 0);
        view()->share('listCat',$listCat);
	}

    public function index(Request $request)
    {
    	// $username = $request->session()->get('username');
    	// $email = $request->session()->get('email');
    	// echo $username . ' ---- ' . $email;
    	return view('admin.dashboard.index');
    }
}
