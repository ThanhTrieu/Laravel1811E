<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AccountController extends Controller
{
    public function viewLogin()
    {
    	return view('admin.account.login');
    }

    public function handleLogin(Request $request, Admin $admin)
    {
    	$user = $request->email;
    	$pass = $request->password;

    	if($user && $pass){
    		// xu ly dang nhap
    		$data = $admin->loginAdmin($user, $pass);
    		if($data){
    			// luu thong tin co ban vao session
    			// cho di vao trang dashboard
    			$request->session()->put('username', $data['username']);
    			// $_SESSION['username'] = $data['username']
    			$request->session()->put('email', $data['email']);
    			$request->session()->put('id', $data['id']);

    			return redirect()->route('admin.dashboard');
    		} else {
    			// quay ve lai dung form login
    			return redirect()->route('admin.viewLogin',['state'=>'fail']);
    		}

    	} else {
    		// nguoi dung ko nhap du lieu
    		// quay ve lai dung form login
    		return redirect()->route('admin.viewLogin',['state'=>'fail']);
    	}
    }

    public function logout(Request $request)
    {
    	// xoa het toan bo session dc tao ra o form login
    	// cho quay ve form login
    	$request->session()->forget('username');
    	$request->session()->forget('email');
    	$request->session()->forget('id');
    	return redirect()->route('admin.viewLogin');
    }
}
