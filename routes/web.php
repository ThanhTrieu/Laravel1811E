<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/home', function() {
	// ::get() method cua routes - phuong thuc truy cap vao routes day
	return "Hello word - home";
});
// Cac phuong thuc lam viec trong routes
// 1- method get
Route::get('/demo/laravel', function () {
	return "This is method GET";
});

// 2- post
Route::post('/demo-post', function() {
	return "This is method post";
});

//3 - put
Route::put('demo-put', function() {
	return "this is method put";
});

//4 - match
// cho phep 1 request co the lam viec voi nhieu cac phuong thuc truy vao routes
Route::match(['get','post','put'],'demo-method', function() {
	return "This is match method";
});

// 5- any
// cho phep lam viec voi tat cac cac phuong thuc truy cap vao routes
Route::any('demo-method-any', function () {
	return "This is method any";
});

// truyen tham vao routes
Route::get('sam-sung/{nameProduct}/{idPd}', function($name, $id){
	// {nameProduct} : tham so bat buoc truyen vao tu url trinh duyet
	// $name : bien dai dien cho tham so trong routes
	return "Samsung - {$name} / ID - {$id}";
});
Route::get('iphone/{id}/{namePd?}', function($idPd,$name = null) {
	// {namePd?} : tham so khong bat buoc
	return "Iphone - {$name} / ID - {$idPd}";
});

// Routes view : Routes se tra ve 1 view html
Route::view('/demo-view','demo');
// demo : name file view

// dieu huong - chuyen huong routes
Route::get('xem-phim', function() {
	return redirect('demo-view');
	// header("Location:demo-view")
});

Route::redirect('/home','/');
// khi vao /home se bi chuyen ve '/'

// Regular Expression Constraints
// kiem tra  - valiadte tham so cua routes
Route::get('phim-hay/tap/{number}', function ($number) {
	return "Ban dang xem phim-hay tap {$number}";
})->where('number','\d+');

Route::get('/phim/{nameFlim}/tap/{number}', function($name, $number) {
	return "Ban dang xem phim {$name} - tap {$number}";
})->where(['nameFlim' => '[A-Za-z0-9]+','number' => '\d+']);

Route::get('/product/{id}', function($id) {
	return "product - id {$id}";
})->where('id','\d+')->name('product');

Route::get('/music-lpop/{id}', function($id) {
	return "music - id {$id}";
})->where('id','\d+')->name('music');

Route::get('nghe-nhac', function() {
	return redirect()->route('music',['id' => 200]);
});
// get info url from routes
Route::get('info-url', function(){

	$url = route('music',['id' => 100]);
	// tao ra duong link url
	echo "<pre>";
	print_r($url);
});

// neu ma gap route loi thi mac dinh da ve 404 nhung muon ve trang khac thi khai bao cai nay
Route::fallback(function () {
    return redirect('/');
});

Route::get('xem-phim-kinh-di/{age}', function () {
	return "ban da du tuoi xem phim";
})->middleware('myCheckAge');

Route::get('kiem-tra-so-chan-le/{number}', function($number){
	return "{$number} la so chan";
	// :admin tham so cua middleware
})->middleware('myCheckNumberOddEven:admin');

Route::get('test-number', function(){
	return "Test";
});

/* du dung routes va controller */
Route::get('test-controller/{name}','TestController@demo')->name('testController');
Route::get('test-demo','TestController@testDemo')->name('testDemo');
Route::get('test-demo-2','TestController@index')->name('testDemo2');
Route::get('profile/{name}/{id}', 'TestController@profile')->name('profile');
Route::get('detail-profile/{id}','TestController@detailProfile')->name('detailProfile');

Route::get('demo-login','TestController@login')->name('frmLogin');

Route::post('handle-login','TestController@handleLogin')->name('handleLogin');


Route::get('template-blade','TestController@template')->name('template');
Route::get('test-home', 'TestController@testHome')->name('testHome');
Route::get('test-about', 'TestController@testAbout')->name('testAbout');

Route::group([
	'prefix' => 'query',
	'namespace' => 'Test',
],function(){
	Route::get('select','QueryController@select')->name('select');
	Route::get('orm','QueryController@demoOrm')->name('orm');
});

/*************** Routes blog Frontend **********************/
Route::group([
	'namespace' => 'Frontend',
	'as' => 'fr.'
],function(){
	Route::get('/','HomeController@index')->name('home');
	Route::get('{slug}~{id}','DetailController@index')->name('detail');
	Route::get('lg/{id}','DetailController@updateView')->name('viewCount');
	Route::get('category/{slug}~{id}','CategoryController@index')->name('category');
	Route::get('search','SearchController@index')->name('search');
});

/******************* Routes blog admin *********************/
// Routes group - namespace - Prefixes of routes
// Routes group : gom nhom cac routes thanh 1 nhom
Route::group([
	'prefix' => 'admin',
	'namespace' => 'Admin',
	'as' => 'admin.'
], function(){
	Route::get('/login','AccountController@viewLogin')->name('viewLogin')->middleware('isAdminLogined');
	
	Route::post('/handle-login', 'AccountController@handleLogin')->name('handleLogin');
	Route::post('/logout','AccountController@logout')->name('logout');
});

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Admin',
	'as' => 'admin.',
	'middleware' => ['web','adminLogined']
], function(){
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/list-posts', 'PostsController@index')->name('listPosts');
	Route::get('/create-post', 'PostsController@createPost')->name('createPost');
	Route::post('/handle-create-post','PostsController@handleCreatePost')->name('handlePost');
	Route::post('/delete-post','PostsController@deletePost')->name('deletePost');
	Route::get('{slug}/{id}','PostsController@editPost')->name('editPost');
	Route::post('handle-edit/{id}','PostsController@handleEdit')->name('handleEdit');
});

