<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
	public function __construct()
	{
		//trieu goi middleware o day
		//$this->middleware('testMiddlewareController');
		//$this->middleware('testMiddlewareController')->only(['demo','testDemo']);
		// :29 tham so truyen vao middleware
		//$this->middleware('testMiddlewareController:29')->except(['demo','testDemo']);
	}

    public function demo()
    {
    	return "This is " . __FUNCTION__;
    }

    public function testDemo(){
    	return "This is " . __CLASS__;
    }

    public function index()
    {
    	return "This is index";
    }

    public function profile($nameProduct, $idPd) 
    {
    	// lam the nao de phuong thuc profile nhan dc gia tri cua tham so ma tu routes gui len
    	return "name product - {$nameProduct} / id - {$idPd}";
    }

    public function detailProfile(Request $request)
    {
    	// $request = new Request;
    	// ten cua param ben routes viet ntn nao thi request tro vao dung nhu the
    	$id = $request->id;
    	$page = $request->page;
    	$key  = $request->key;
    	$age = $request->input('age',30);

    	return "This is id : {$id} - page : {$page} - key : {$key} - age : {$age}";
    }

    public function login()
    {
    	// goi view - nap view vao method controller.
    	return view('login.index');
    }

    public function handleLogin(Request $request)
    {
    	// nhan cac du lieu tu form gui len thong qua doi tuong Request
    	//$data = $request->all();
    	//dd($data);
    	$user = $request->input('user');
    	// $user = $request->user;
    	$pass = $request->pass;
    	dd($user, $pass);
    }

    public function template()
    {
    	//return view('test-layout');
        $data = [];
    	$data['lstInfoStudent'] = [
            [
                'msv' => 113,
        		'name' => 'abc',
        		'age' => 29,
        		'phone' => '9021423',
                'money' => 1213232,
                'gender' => 0
            ],
            [
                'msv' => 114,
                'name' => 'efwef',
                'age' => 20,
                'phone' => '9021423',
                'money' => 2122,
                'gender' => 1
            ],
            [
                'msv' => 115,
                'name' => 'efddasdwef',
                'age' => 22,
                'phone' => '9021423',
                'money' => 2122323,
                'gender' => 0
            ]
    	];

    	return view('home.index',$data);
    }

    public function testAbout()
    {
    	$age = 29;
    	return view('about.index')->with('myage',$age);
    }
}
