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

Auth::routes();

Route::get('home', function(){
  return redirect('/');
});

Route::get('member/{periode_id}/registration','MemberRegistrationController@index');
Route::post('member/{periode_id}/registration','MemberRegistrationController@store');
Route::get('member/{periode_id}/oldmember','MemberRegistrationController@oldmember');
Route::post('member/{periode_id}/oldmember','MemberRegistrationController@registerOldMember');

Route::get('images/{width}/{height}/{folder}/{image}',function($width,$height,$folder,$image){
  $url = \Storage::disk('public')->get($folder.'/'.$image);
  $stream = \Image::make($url)->resize($width,$height, function($const){
    $const->upSize();
  })->stream();
  return Response::make($stream, 200, array('Content-Type' => 'image/jpeg'));
});

Route::get('img/{folder}/{name}', function($folder,$name){
  return \Storage::disk('public')->get($folder.'/'.$name);
});

Route::get('/', function(){
  return redirect(Help::url());
});

Route::group(['middleware' => ['auth','root'], 'prefix' => 'root' ,'namespace' => 'Root'], function(){
  Route::get('/', function(){
    return redirect('root/home');
  });

  Route::get('home','HomeController@index');

  Route::get('user','UserController@index');
  Route::delete('user/{id}','UserController@destroy');
  Route::get('user/{id}/change','UserController@change');
  Route::post('user/{id}/reset','UserController@reset');
  Route::post('user','UserController@create');

  Route::resource('periode','PeriodeController');
});

Route::group(['middleware' => ['auth','admin:sekretaris'], 'prefix' => 'sekretaris', 'namespace' => 'Sekretaris'], function(){
  Route::get('/', function(){
    return redirect('sekretaris/home');
  });
  Route::get('/home','HomeController@index');

  Route::get('/anggota','MemberController@index');
  Route::get('/anggota/{id}/edit','MemberController@edit');
  Route::put('/anggota/{id}','MemberController@update');
  Route::delete('/anggota/{id}','MemberController@destroy');
  Route::get('/download/anggota','MemberController@download');

  Route::get('/absen','AbsentController@index');
  Route::post('/absen','AbsentController@create');
  Route::delete('/absen/{id}','AbsentController@destroy');
  Route::get('/absen/{id}/view','AbsentController@show');
  Route::put('/absen/{id}','AbsentController@update');
  Route::get('/absen/{id}/download/','AbsentController@download');
  Route::post('/absen/{id}/tambah','AbsentController@addmember');

  Route::get('/akun','AccountController@index');
  Route::post('/akun','AccountController@update');
  Route::post('/akun/password','AccountController@changePassword');
  Route::post('/akun/picture','AccountController@changePicture');
});

Route::group(['middleware' => ['auth','admin:bendahara'], 'prefix' => 'bendahara', 'namespace' => 'Bendahara'], function(){
  Route::get('/', function(){
    return redirect('bendahara/home');
  });
  Route::get('/home','HomeController@index');

  Route::get('/pembayaran-kas','PaymentController@index');
  Route::post('/pembayaran-kas','PaymentController@create');
  Route::get('/pembayaran-kas/{id}/view','PaymentController@show')->name('pembayaran');
  Route::put('/pembayaran-kas/{id}','PaymentController@update');
  Route::get('/pembayaran-kas/{id}/download','PaymentController@download');
  Route::delete('/pembayaran-kas/{id}','PaymentController@destroy');
  Route::post('/pembayaran-kas/{id}/tambah','PaymentController@addmember');

  Route::get('/kas-anggota','MemberPaymentController@index');
  Route::get('/kas-anggota/{id}/view','MemberPaymentController@show');
  Route::put('/kas-anggota/{id}/bayar/{pay_id}','MemberPaymentController@pay');

  Route::get('/akun','AccountController@index');
  Route::post('/akun','AccountController@update');
  Route::post('/akun/password','AccountController@changePassword');
  Route::post('/akun/picture','AccountController@changePicture');
});

Route::get('kill', function(){
  Auth::logout();
});
