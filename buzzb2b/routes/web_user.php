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

Route::get('/', function () {
    return view('welcome');
});
*/
//route for user login start from here
Route::group(['prefix'=>'user','namespace'=>'User_Member\User'],function(){
  Route::any('/dashboard',['as'=>'user_dashboard','uses'=>'DashboardController@ViewDashboard']);

  /*Route::any('user-directory',['as'=>'user_directory','uses'=>'DashboardController@ViewDashBoard']);*/

  Route::any('ajax/user-directory',['as'=>'user_directory_ajax','uses'=>'DashboardController@ajaxMembers']);


  Route::get('/setting/my-account',['as'=>'user-account','uses'=>'MyAccountController@ViewAccount']);
  Route::post('/save-image',['as'=>'user-image','uses'=>'MyAccountController@ProfileImage']);
  /*user setting start from here*/
  Route::group(['prefix'=>'setting'],function(){
  	Route::get('/edit/details',['as'=>'user_details','uses'=>'MyAccountController@EditDetails']);
  	Route::post('/update/details',['as'=>'update_details','uses'=>'MyAccountController@UpdateDetails']);
  	/*password*/
  	Route::get('/password',['as'=>'change-password','uses'=>'MyAccountController@ChangePassword']);
  	Route::post('/update/password',['as'=>'update-password','uses'=>'MyAccountController@UpdatePassword']);
  	/*address*/
  	Route::get('/address/list',['as'=>'user-address','uses'=>'MyAccountController@AddressList']);
  	Route::get('/address/default/{id}',['as'=>'default-address','uses'=>'MyAccountController@DefaultAddress']);
  	Route::get('/address/add',['as'=>'user-add-address','uses'=>'MyAccountController@AddAddress']);
  	Route::post('/address/save',['as'=>'user-save-address','uses'=>'MyAccountController@SaveAddress']);
  	Route::get('/address/delete/{id}',['as'=>'user-address-delete','uses'=>'MyAccountController@DeleteAddress']);
  	/*phone setting */
  	Route::get('/phone/list',['as'=>'user-phone','uses'=>'MyAccountController@PhoneList']);
    Route::get('/phone/add',['as'=>'user-add-phone','uses'=>'MyAccountController@AddPhone']);
    Route::post('/phone/save',['as'=>'user-save-phone','uses'=>'MyAccountController@SavePhone']);
    Route::get('/phone/default/{id}',['as'=>'default-phone','uses'=>'MyAccountController@DefaultPhone']);
    Route::get('/phone/delete/{id}',['as'=>'delete-phone','uses'=>'MyAccountController@DeletePhone']);
	});
});