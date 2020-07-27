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
Route::get('/err','defaultUserController@Error')->name('user.error');
Route::post('/credentials','paymentController@postPayToGetCredentials')->name('user.post.credentials');
Route::get('/bundlebalance','defaultUserController@bundlebalance')->name('user.balance');
Route::post('/bundlebalance','defaultUserController@fetchBalance')->name('user.check.balance');
Route::get('/allplans','defaultUserController@getAllPlans')->name('user.allplans');

Route::get('/buybundle/{plan}','defaultUserController@buyBundlePlan')->name('user.buybundleplan');
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
	Route::get('/transactions','HomeController@getTransactions')->name('user.transactions');
	});
//admin routes

Route::get('/admin/destro','adminController@getIndex')->name('admin.index');
Route::get('/admin/destro/plans','adminController@getPlans')->name('admin.plans');
Route::get('/admin/destro/customers','adminController@getCustomers')->name('admin.customers');
Route::get('/admin/destro/payments','adminController@getPayments')->name('admin.payments');
Route::get('/admin/destro/groups&attributes','adminController@getGroupsAndAttr')->name('admin.groupsandattributes');
Route::post('/admin/destro/customer','adminController@postCustomer')->name('admin.post.customer');
Route::post('/admin/destro/plans','adminController@postPlan')->name('admin.post.plan');
Route::post('/admin/destro/searchuser','adminController@postSearchUser')->name('admin.search.user');
Route::post('admin/destro/assignattrs','adminController@postGroupsAndAttr')->name('admin.post.groupandattribute');