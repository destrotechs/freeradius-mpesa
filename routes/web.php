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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/allcustomers','HomeController@getAllCustomers')->name('allcustomers');
Route::get('/home/newcustomers','HomeController@getNewCustomer')->name('newcustomer');
Route::get('/home/editcustomer','HomeController@fetchCustomer')->name('editcustomer');
Route::get('/home/manage','HomeController@getCleanStale')->name('get.cleanstale');
Route::get('/home/listnas','HomeController@getNasList')->name('listnas');
Route::get('/home/newnas','HomeController@getNewNas')->name('newnas');
Route::get('/home/editnas/{id}','HomeController@getEditNas')->name('editnas');
Route::get('/home/newnas','HomeController@getNewNas')->name('newnas');
Route::get('/home/newlimitattribute','HomeController@getNewLimitAttr')->name('newlimitattr');
Route::get('/home/userlimitgroups','HomeController@getUserlimitGroups')->name('userlimitgroups');
Route::get('/home/editcustomer/{username}','HomeController@getSpecificCustomer')->name('specificcustomer');
Route::get('/home/allpayments','HomeController@getAllPayments')->name('allpayments');
Route::get('/home/editcustomer','HomeController@fetchCustomer')->name('geteditcustomer');
Route::get('/home/initiatepayment','HomeController@getInitializePayment')->name('initiatepayment');
Route::get('/home/lastconnection-attempts','HomeController@getLastConnectionAtt')->name('lastconnatt');
Route::get('/home/userconnectivity','HomeController@getUserConnectivity')->name('customerconnectivity');
Route::get('/home/payments/graphs','HomeController@paymentGraphs')->name('paymentgraphs');
Route::get('/home/Onlinecustomers','HomeController@getOnlineusers')->name('onlineusers');
Route::get('/home/useraccounting','HomeController@getUserAccounting')->name('useraccounting');
Route::get('/home/ipaccounting','HomeController@getIpAccounting')->name('ipaccounting');
Route::get('/home/nasaccounting','HomeController@getNasAccounting')->name('nasaccounting');
Route::get('/home/plans','HomeController@getPlans')->name('plans');
Route::get('/markAsRead', function(){

	auth()->user()->unreadNotifications->markAsRead();

	return redirect()->back();

})->name('mark');
Route::get('/home/deleteacctrec','HomeController@getDeleteRec')->name('deleteacctrec');
Route::get('/home/operators','HomeController@getOperators')->name('operators');
Route::get('/home/operator/{id}','HomeController@editOperator')->name('editoperator');
Route::get('/home/operator/delete/{id}','HomeController@deleteOperator')->name('deleteop');
Route::get('/home/editplan/{id}','HomeController@getPlanEdit')->name('editplan');
Route::get('/home/deleteplan/{id}','HomeController@deletePlan')->name('deleteplan');
Route::get('/home/servicestatus','HomeController@getServiceStatus')->name('servicestatus');
Route::get('/home/userlimits','HomeController@getUserLimits')->name('userlimits');
Route::get('/home/deletecustomer/{id?}','HomeController@removeuser')->name('removeuser');
Route::get('/home/deletenas/{id}','HomeController@deleteNas')->name('deletenas');
Route::get('/home/topuser','HomeController@getTopUser')->name('topuser');
Route::get('/home/vouchers','HomeController@getVouchers')->name('vouchers');
Route::get('/home/sendsms','HomeController@getSendsms')->name('sendsms');
Route::get('/home/allvouchers','HomeController@getAllVouchers')->name('allvouchers');
Route::get('/home/sellvoucher/{id}','HomeController@getSellVoucher')->name('sellvoucher');
Route::get('/home/bundlebalance','HomeController@bundlebalance')->name('bundlebalance');
Route::get('/home/editgroup/{groupname}','HomeController@getEditgroup')->name('editgroup');
Route::get('/home/deletegroup/{groupname}','HomeController@getDeletegroup')->name('deletegroup');
Route::get('/home/deletechecklimitfromgroup/{id}','HomeController@postDeleteCheckLimit')->name('deletechecklimit');
Route::get('/home/deletereplylimitfromgroup/{id}','HomeController@postDeleteReplyLimit')->name('deletereplylimit');
Route::get('/home/deletecheckuserlimitfromgroup/{id}','HomeController@postDeleteCheckUserLimit')->name('deletecheckuserlimit');
Route::get('/home/deletereplyuserlimitfromgroup/{id}','HomeController@postDeleteReplyUserLimit')->name('deletereplyuserlimit');
Route::get('/home/disconnect/customer','HomeController@disconnectUser')->name('disconnectcustomer');
Route::get('/home/messages/new','messagesController@getNewMessage')->name('messagenew');
Route::get('/home/messages/inbox','messagesController@getInbox')->name('messageinbox');
Route::get('/home/messages/sent','messagesController@getSent')->name('messagesent');
Route::get('/home/messages/delete/{id}','messagesController@deleteMessage')->name('deletemessage');
Route::get('/home/customer/new/auto','HomeController@getAutomatedCustomer')->name('auto.customer');
Route::get('/home/restart/freeradius','HomeController@restartFreeradius')->name('restartradius');
Route::get('/home/restart/apache','HomeController@restartApache')->name('restartapache');
Route::get('/home/restart/mysql','HomeController@restartMysql')->name('restartmysql');
//post routes
Route::post('/home/newcustomer','HomeController@postNewCustomer')->name('post.newcustomer');
Route::post('/home/fetchcustomer','HomeController@postFetchCustomer')->name('fetchcustomertoedit');
Route::post('/home/newnas','HomeController@postNewNas')->name('savenewnas');
Route::post('/home/posteditednas','HomeController@postEditedNas')->name('saveeditednas');
Route::post('/home/newlimit','HomeController@postNewLimit')->name('postnewlimit');
Route::post('/home/newgrouplimit','HomeController@postNewLimitGroup')->name('postnewgrouplimit');
Route::post('/initiatepayment','paymentController@postPayToGetCredentials')->name('user.post.credentials');
Route::post('/home/useraccounting','HomeController@userAccounting')->name('fetchcustomeraccounting');
Route::post('/home/ipaccounting','HomeController@ipAccounting')->name('fetchipaccounting');
Route::post('/home/nasaccounting','HomeController@nasAccounting')->name('fetchnasaccounting');
Route::post('/home/plans','HomeController@postPlan')->name('admin.post.plan');
Route::post('/home/deleteacctrec','HomeController@postDeleteAcctRec')->name('deletecustomeracctrec');
Route::post('/home/operators','HomeController@postOperator')->name('postoperator');
Route::post('/home/editoperator','HomeController@postEditOperator')->name('posteditoperator');
Route::post('/home/editplan','HomeController@postEditPlan')->name('posteditplan');
Route::post('/home/editedcustomer','HomeController@saveCustomerChanges')->name('saveeditedcustomer');
Route::post('/home/cleanstaleconn','HomeController@cleanStaleConn')->name('post.cleanstale');
Route::post('/home/testconn','HomeController@postTestConn')->name('testconn');
Route::post('/home/removeuser','HomeController@postRemoveUser')->name('post.delete.user');
Route::post('/home/savevouchers','HomeController@saveVouchers')->name('postvouchers');
Route::post('/home/markvoucherpaid','HomeController@markVoucherPaid')->name('markvouchersold');
Route::post('/home/bundlebalance','HomeController@fetchBalance')->name('user.check.balance');
Route::post('/home/editedgroup','HomeController@postEditedGroup')->name('post.edited.group');
Route::post('/home/autocomplete','HomeController@searchUser')->name('autocomplete');
Route::post('/home/message/new','messagesController@sendMessage')->name('sendmessage');
Route::post('/home/customer/new/auto','HomeController@automatedUser')->name('autocustomer.post');