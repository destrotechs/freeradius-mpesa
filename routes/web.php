<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/credentials','defaultUserController@credentials')->name('user.credentials');
Route::post('/credentials','paymentController@postPayToGetCredentials')->name('user.post.credentials');
Route::get('/bundlebalance','defaultUserController@bundlebalance')->name('user.balance');
Route::post('/bundlebalance','defaultUserController@fetchBalance')->name('user.check.balance');
Route::get('/allplans','defaultUserController@getAllPlans')->name('user.allplans');

Route::group(['middleware'=>'guest'], function(){
	Route::post('/signup','defaultUserController@postSignup')->name('user.post.signup');
	Route::post('/signin','defaultUserController@postSignin')->name('user.post.signin');
	Route::get('/login','defaultUserController@signin')->name('login');
	Route::get('/signup','defaultUserController@signup')->name('user.signup');
	Route::get('/','defaultUserController@index')->name('user.index');
});
Route::group(['middleware'=>'auth'], function(){
	Route::get('/home','HomeController@getIndex')->name('home');
	Route::get('/logout','HomeController@getLogout')->name('customer.logout');
	Route::get('/changephone','HomeController@getChangePhone')->name('user.changephone');
	Route::post('/changephone','HomeController@postChangePhone')->name('user.post.changephone');
	});
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
