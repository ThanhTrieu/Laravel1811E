<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    	// $username = $request->session()->get('username');
    	// $email = $request->session()->get('email');
    	// echo $username . ' ---- ' . $email;
    	
    	return view('admin.dashboard.index');
    }
}
