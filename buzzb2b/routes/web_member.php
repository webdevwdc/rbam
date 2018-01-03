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

/*member section start*/
Route::get('/',['as' => 'landing_page','uses'=> 'LoginController@HomeIndex']);
Route::get('/giftcard/balance',['as' => 'giftcard_balance','uses'=> 'LoginController@ViewGiftCard']);
Route::post('/giftcard/balance-check',['as' => 'giftcard_balance_check','uses'=> 'LoginController@CheckBalanceGiftCard']);


/*login start from here*/
Route::any('/login',['as' => 'login_dashboard','uses'=> 'LoginController@Index']);
/*end*/
Route::group(['namespace'=>'User_Member\Member','middleware'=>'member'],function(){
	
	Route::get('dashboard',['as'=>'member_dashboard','uses'=>'DashboardController@ViewDashBoard']);
	
	Route::get('/my-account',['as'=>'my-account','uses'=>'MyAccountController@ViewAccount']);
	Route::any('/profile-photo',['as'=>'my-photo','uses'=>'MyAccountController@ProfilePhoto']);
	Route::any('/profile-edit',['as'=>'edit-profile','uses'=>'MyAccountController@EditProfile']);
    
    /*setting section start*/
	Route::group(['prefix'=>'setting'],function(){
	Route::get('/directory',['as'=>'member_setting','uses'=>'SettingController@ViewSetting']);
	Route::post('save-logo-setting',['as'=>'save_logo','uses'=>'SettingController@SaveLogo']);
	Route::post('save-url-setting',['as'=>'save_url','uses'=>'SettingController@SaveUrl']);

	Route::get('users',['as'=>'users_setting','uses'=>'SettingController@ViewUsers']);
	Route::get('users/create',['as'=>'users_create','uses'=>'SettingController@CreateUser']);
	Route::post('users/create/save',['as'=>'save_users_create','uses'=>'SettingController@SaveCreateUser']);
        
    Route::get('users/delete/{id}',['as'=>'users_delete','uses'=>'SettingController@DeleteUser']);

	/*address*/
	Route::get('addresses',['as'=>'address_setting','uses'=>'SettingController@ViewAddress']);
	Route::get('address/create',['as'=>'address_create','uses'=>'SettingController@CreateAddress']);
	Route::post('address/save',['as'=>'address_save','uses'=>'SettingController@SaveAddress']);
	Route::get('/delete/{id}',['as'=>'address_delete','uses'=>'SettingController@AddressDelete']);

	/*phone*/
	Route::get('phone',['as'=>'phone_setting','uses'=>'SettingController@ViewPhone']);
	Route::get('phone/create',['as'=>'phone_create','uses'=>'SettingController@CreatePhone']);
	Route::post('phone/save',['as'=>'phone_save','uses'=>'SettingController@SavePhone']);
	Route::get('phone/delete/{id}',['as'=>'member_phone_delete','uses'=>'SettingController@PhoneDelete']);

	/*cashier*/
	Route::get('cashier',['as'=>'cashier_setting','uses'=>'SettingController@ViewCashier']);
	Route::get('cashier/create',['as'=>'create_cashier_setting','uses'=>'SettingController@CreateCashier']);
	Route::post('cashier/save',['as'=>'cashier_save','uses'=>'SettingController@SaveCashier']);
	Route::post('cashier/delete',['as'=>'member_cashier_delete','uses'=>'SettingController@DeleteCashier']);
    });
    //setting section end

    /*billing section start*/
    Route::group(['prefix'=>'billing'],function(){
     Route::get('/',['as'=>'billing','uses'=>'BillingController@ViewBill']);
     Route::get('/load-cba',['as'=>'load-cba','uses'=>'BillingController@LoadCba']);
     Route::get('/payment-profile',['as'=>'payment-profile','uses'=>'BillingController@PaymentProfile']);
     Route::get('/add-payment-profile',['as'=>'payment-profile-add','uses'=>'BillingController@AddPaymentProfile']);
     Route::post('/save-payment-profile',['as'=>'payment-profile-store','uses'=>'BillingController@storePaymentProfile']);
     Route::any('/member-load-cba-insert',['as'=>'load-cba-insert-data','uses'=>'BillingController@LoadCbaInsert']);
     Route::get('/member-load-cba-redirect',['as'=>'load-cba-redirect','uses'=>'BillingController@LoadCbaRedirect']);
     });

    /*transaction section start*/
    Route::any('/transaction',['as'=>'member_transaction','uses'=>'TransactionController@ViewTransaction']);
    /*end transaction*/

    /*referral*/
	Route::get('/member/referral',['as'=>'member_referrals','uses'=>'ReferralController@Create']);
	Route::post('/referral/save',['as'=>'save_referrals','uses'=>'ReferralController@SaveReferral']);
    
    /*member switch*/
    Route::get('/switch',['as'=>'switch_member','uses'=>'SwitchMemberController@SwitchMember']);

    /*directory section start*/
    Route::get('/member-directory',['as'=>'member_directory','uses'=>'MemberController@MemberDirectory']);
    Route::any('/member-search-directory',['as'=>'member_directory_ajax','uses'=>'MemberController@ajaxMembers']);
    /*end directory*/

    /*pos section start*/
     Route::get('/member/pos',['as'=>'pos-view','uses'=>'PosController@ViewPos']);
     Route::get('/member/pos/sale',['as'=>'sale-pos','uses'=>'PosSaleController@ViewPosSale']);
     Route::get('/member/purchase/view',['as'=>'purchase-view','uses'=>'PosPurchaseController@ViewPurchase']);
     Route::post('/member/search/bartercard',['as'=>'search-member-bartercard','uses'=>'PosSaleController@BarterCardSearch']);
     Route::post('/member/save/bartercard',['as'=>'save-member-bartercard','uses'=>'PosSaleController@SaleSaveBarterCard']);
     Route::post('/member/save/purchase',['as'=>'purchase-save','uses'=>'PosPurchaseController@SaveMemberPurchase']);

      Route::any('/sale-receipt/{id}',['as'=>'show_sale_receipt','uses'=>'PosSaleController@show_sale_receipt']);

    /*end pos section*/

    /*password change section start*/
     Route::get('change/password',['as'=>'change-profile-password','uses'=>'MyAccountController@ChangePassword']);
     Route::post('save-change-password',['as'=>'change-profile-password-post','uses'=>'MyAccountController@UpdatePassword']);
    /*end password section*/

    Route::get('logout',['as'=>'member_logout','uses'=>'DashboardController@Logout']);
});
/*member section end*/