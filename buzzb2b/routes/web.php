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

Route::group(array('prefix'=>'admin','namespace' => 'admin'), function (){

    Route::any('/',array('as' => 'admin_login','uses'=>'DashboardController@login' ));

    Route::get('/forgot-password',             array('as' => 'admin_forgot_password',          'uses'=>'DashboardController@admin_forgot_password' ));
    Route::post('/forgot-password-action',     array('as' => 'admin_forgot_password_action',   'uses'=>'DashboardController@admin_forgot_password_action' ));
});

Route::group(array('prefix'=>'admin','namespace' => 'admin','middleware' => 'admin'), function (){
    Route::any('/dashboard',['as' => 'admin_dashboard','uses'=>'DashboardController@index']);
    Route::any('/profilephoto',['as' => 'admin_profilephoto','uses'=>'DashboardController@profilepic']);
    Route::any('/logout',                       array('as' => 'admin_logout',           'uses'=>'DashboardController@logout'));
    
    Route::any('/edit-detail',['as' => 'admin_edit_detail','uses'=>'DashboardController@detail']);
    Route::any('/edit-detail-update',          array('as' => 'admin_detail_update',   'uses'=>'DashboardController@detail_update'));
    
    Route::any('/edit-password',               array('as' => 'admin_edit_password',     'uses'=>'DashboardController@password'));
    Route::any('/edit-password-update',        array('as' => 'admin_password_update',   'uses'=>'DashboardController@password_update'));
    
    Route::any('/manage-address',['as' => 'admin_manage_address','uses'=>'DashboardController@address']);
    Route::get('/address-create',['as' => 'admin_address_create','uses'=>'DashboardController@create_address']);
    Route::post('/address/store',              array('as' => 'admin_address_store',     'uses'=>'DashboardController@store_address'));
    Route::get('/address-edit/{id}',['as' => 'admin_address_edit','uses'=>'DashboardController@edit_address']);
    Route::any('/address-update-action/{id}',  array('as' => 'admin_address_update',    'uses'=>'DashboardController@update_address'));
    Route::any('/address/delete/{id}',['as' => 'admin_address_delete',    'uses'=>'DashboardController@delete_address']);
    Route::any('/address/make_default/{id}',   array('as' => 'admin_address_make_default',   'uses'=>'DashboardController@change_default_address'));
    Route::any('/manage-phone',                array('as' => 'admin_manage_phone',      'uses'=>'DashboardController@phone'));
    Route::get('/phone-create',['as' => 'admin_phone_create','uses'=>'DashboardController@create_phone']);
    Route::post('/phone/store',                array('as' => 'admin_phone_store',       'uses'=>'DashboardController@store_phone'));
    Route::get('/phone-edit/{id}',['as' => 'admin_phone_edit','uses'=>'DashboardController@edit_phone']);
    Route::any('/phone-update-action/{id}',['as' => 'admin_phone_update','uses'=>'DashboardController@update_phone']);
    Route::any('/phone/delete/{id}',['as' => 'admin_phone_delete','uses'=>'DashboardController@delete_phone']);
    Route::any('/phone/make_default/{id}',['as' => 'admin_phone_make_default','uses'=>'DashboardController@change_default_phone']);
    Route::any('/switch-exchange',             array('as' => 'admin_switch_exchange',   'uses'=>'DashboardController@switch_exchange'));
    Route::any('/select-exchange/{id}',        array('as' => 'admin_select_exchange',   'uses'=>'DashboardController@select_exchange'));
    Route::get('/profile-photo',               array('as' => 'admin_profile_photo',     'uses'=>'DashboardController@profile_photo'));
    Route::post('/profile-photo-update',       array('as' => 'admin_profile_photo_update',   'uses'=>'DashboardController@profile_photo_update'));    
    
    //Admin Exchange Master
    
    Route::any('/exchange',['as' => 'admin_exchange','uses'=>'ExchangeController@lists']);
    Route::get('/exchange-create',['as' => 'admin_exchange_create','uses'=>'ExchangeController@create']);
    Route::post('/exchange/store',['as' => 'admin_exchange_store','uses'=>'ExchangeController@store']);
    Route::get('/exchange-edit/{id}',['as' => 'admin_exchange_edit','uses'=>'ExchangeController@edit']);
    Route::post('/exchange/update-action/{id}',['as' => 'admin_exchange_update_action','uses'=>'ExchangeController@update' ]);
    Route::any('/exchange_change_status',['as' => 'admin_exchange_change_status','uses'=>'ExchangeController@change_status']);
    Route::get('/exchange/delete/{id}',array('as' => 'admin_exchange_delete','uses'=>'ExchangeController@delete'));
    
    //Admin Phone Type

    Route::any('/phone_type',['as' => 'admin_phone_type','uses'=>'PhoneTypeController@lists' ]);
    Route::get('/phone_type-create',['as' => 'admin_phone_type_create','uses'=>'PhoneTypeController@create']);
    Route::post('/phone_type/store',array('as' => 'admin_phone_type_store','uses'=>'PhoneTypeController@store'));
    Route::get('/phone_type-edit/{id}',array('as' => 'admin_phone_type_edit','uses'=>'PhoneTypeController@edit'));
    Route::post('/phone_type/update-action/{id}',array('as' => 'admin_phone_type_update_action','uses'=>'PhoneTypeController@update' ));
    Route::any('/phone_type_change_status',array('as' => 'admin_phone_type_change_status','uses'=>'PhoneTypeController@change_status' ));
    Route::get('/phone_type/delete/{id}',array('as' => 'admin_phone_type_delete','uses'=>'PhoneTypeController@delete'));
    
    //Admin Category

    Route::any('/category',['as' => 'admin_category','uses'=>'CategoryController@lists']);
    Route::get('/category-create',array('as' => 'admin_category_create','uses'=>'CategoryController@create'));
    Route::post('/category/store',array('as' => 'admin_category_store','uses'=>'CategoryController@store'));
    Route::get('/category-edit/{id}',array('as' => 'admin_category_edit','uses'=>'CategoryController@edit'));
    Route::post('/category/update-action/{id}',array('as' => 'admin_category_update_action','uses'=>'CategoryController@update' ));
    Route::any('/category_change_status',array('as' => 'admin_category_change_status','uses'=>'CategoryController@change_status' ));
    Route::get('/category/delete/{id}',  array('as' => 'admin_category_delete',  'uses'=>'CategoryController@delete'));
    
    //Admin Member
    Route::any('/members',['as' => 'admin_member','uses'=>'MemberController@lists']);
    Route::get('/member-create',['as' => 'admin_member_create','uses'=>'MemberController@create']);
    Route::post('/member/store',['as' => 'admin_member_store','uses'=>'MemberController@store']);
    Route::get('/member-edit/{id}',['as' => 'admin_member_edit','uses'=>'MemberController@edit']);
    Route::post('/member/update-action/{id}',['as' => 'admin_member_update_action','uses'=>'MemberController@update' ]);
    Route::any('/member-change-status', array('as' => 'admin_member_change_status',       'uses'=>'MemberController@change_status' ));
    
    Route::get('/member-detail/{id}/', array('as' => 'admin_member_details', 'uses' => 'MemberDetailsController@index'));
    Route::post('/member-update-detail/{id}/', array('as' => 'admin_member_update_details', 'uses' => 'MemberDetailsController@update_details'));
    
    Route::get('/member-address/{id}/',            array('as' => 'admin_member_address',                'uses' => 'MemberDetailsController@address'));
    Route::get('/member-address-create/{id}/',     array('as' => 'admin_member_address_create',         'uses' => 'MemberDetailsController@address_create'));
    Route::post('/member-address-store/{id}/',     array('as' => 'admin_member_address_store',          'uses' => 'MemberDetailsController@address_store'));
    Route::any('/member-address/make_default/{id}', array('as' => 'admin_member_address_make_default',   'uses'=>  'MemberDetailsController@change_default_address'));
    Route::get('/member/address/delete/{id}',               array('as' => 'admin_member_address_delete',         'uses'=>  'MemberDetailsController@delete_address'));
    
    /*phpone*/
    Route::get('/member-phone/{id}/',           array('as' => 'admin_member_phone',         'uses' => 'MemberDetailsController@phone'));
    Route::get('/member-phone-create/{id}/',    array('as' => 'admin_member_phone_create',  'uses' => 'MemberDetailsController@phone_create'));
    Route::post('/member-phone-store/{id}/',    array('as' => 'admin_member_phone_store',    'uses' => 'MemberDetailsController@phone_store'));
    Route::any('/member-phone/make_default/{id}', array('as' => 'admin_member_phone_make_default',       'uses'=>  'MemberDetailsController@change_default_phone'));
    Route::get('/member/phone/delete/{id}',      array('as' => 'admin_member_phone_delete',             'uses'=>  'MemberDetailsController@delete_phone'));
    Route::get('/member-user/{id}/',['as' => 'admin_member_user','uses' => 'MemberDetailsController@member_user']);
    Route::get('/member-user/{id}/edit',['as' => 'admin_member_user_edit','uses' => 'MemberDetailsController@member_user_edit']);
    Route::any('/member-user/{id}/update',               array('as' => 'admin_member_user_update',                    'uses' => 'MemberDetailsController@member_user_update'));
    Route::get('/member-user-add/{id}',array('as' => 'admin_member_user_create','uses' => 'MemberDetailsController@member_user_create'));
    Route::get('/member-user-delete/{id}',['as' => 'admin_member_user_delete','uses' => 'MemberDetailsController@member_user_delete']);
    Route::any('/member-user-store/{id}',              array('as' => 'admin_member_user_store',             'uses' => 'MemberDetailsController@member_user_store'));
    Route::any('/issue-bartercard',
                    ['as' =>'admin_issue_bartercard','uses' => 'MemberDetailsController@issue_bartercard']);    
    
    Route::any('/directory-profile/{id}/',
                    ['as' => 'admin_directory_profile','uses' => 'MemberDetailsController@directory_profile']);
    Route::any('/directory-profile-update/{id}/',      array('as' => 'admin_directory_profile_update',     'uses' => 'MemberDetailsController@admin_directory_profile_update'));
    
    Route::get('/member-settings/{id}/',['as' => 'admin_member_settings','uses' =>'MemberDetailsController@settings']);
    Route::get('/member-delete/{id}/',                   array('as' => 'admin_member_delete',                  'uses' => 'MemberDetailsController@delete_member'));
    
    Route::get('/member-directory-profile/{id}/', array('as' => 'admin_member_directory_profile', 'uses' => 'MemberDetailsController@directory_profile'));
    Route::post('/member-update-directory-profile/{id}/', array('as' => 'admin_member_update_directory_profile', 'uses' => 'MemberDetailsController@update_directory_profile'));
    
    
    //Admin User
    Route::any('/users',['as' => 'admin_user','uses'=>'UserController@lists']);
    Route::any('/users/create',['as' => 'admin_user_create','uses'=>'UserController@create']);
    Route::any('/users/store',['as' => 'admin_user_store','uses'=>'UserController@store']);
    Route::any('/users/edit/{id}',array('as' => 'admin_user_edit','uses'=>'UserController@edit'));
    Route::any('/users/profile_image/{id}',['as' => 'admin_user_image','uses'=>'UserController@uploadimage']);
    Route::get('/users/makeAdmin/{id}',['as' => 'admin.makeAdmin','uses'=>'UserController@makeAdmin']);
    Route::get('/member/makeAdmin/{id}',['as' => 'admin.makeMemberAdmin','uses'=>'UserController@memberAdmin']);
    
    Route::any('/users/member-associations/{id}',              array('as' => 'admin_user_member_associations_edit',        'uses'=>'UserController@edit_member_associations'));    
    Route::any('/users/exchange-associations/{id}',              array('as' => 'admin_user_exchange_associations_edit',        'uses'=>'UserController@edit_exchange_associations'));
    
    Route::any('/users/address_edit/{id}',              array('as' => 'admin_user_address_edit',        'uses'=>'UserController@edit_address'));
    Route::any('/users/address_update/{id}',            array('as' => 'admin_user_address_update',      'uses'=>'UserController@update_address'));
    Route::any('/users/address_delete/{id}/{adid}',     array('as' => 'admin_user_address_delete',      'uses'=>'UserController@delete_address'));
    Route::any('/users/address_default/{id}/{adid}',    array('as' => 'admin_user_address_default',     'uses'=>'UserController@default_address'));
    
   
    Route::any('/users/phone_edit/{id}',                array('as' => 'admin_user_phone_edit',          'uses'=>'UserController@edit_phone'));
    Route::any('/users/phone_update/{id}',['as' => 'admin_user_phone_update','uses'=>'UserController@update_phone']);
    Route::any('/users/phone_delete/{id}/{phid}',       array('as' => 'admin_user_phone_delete',        'uses'=>'UserController@delete_phone'));
    Route::any('/users/phone_default/{id}/{phid}',      array('as' => 'admin_user_phone_default',       'uses'=>'UserController@default_phone'));

    /*barter card section start from here*/
    Route::group(array('prefix'=>'bartercard'), function (){
     Route::get('/list',['as'=>'bartercard','uses'=>'BarterCardController@ViewBarterCards']);
     Route::get('/add',['as'=>'add-bartercard','uses'=>'BarterCardController@AddBarterCards']);
     Route::post('/save',['as'=>'save-bartercard','uses'=>'BarterCardController@SaveBarterCards']);
     Route::get('/edit/card/{id}',['as'=>'edit-bartercard','uses'=>'BarterCardController@EditBarterCard']);
    });
    /*transaction section start*/
    Route::any('/transaction',['as'=>'admin-search-transcation','uses'=>'TransactionController@SearchTranscation']);
    Route::any('/search/transcation',['as'=>'admin-date-search-transcation','uses'=>'TransactionController@DateRangeSearchTranscation']);
    
    
    //account details of user
    //barter credit and debit
    Route::any('/users/account_details/{id}',
          ['as'=>'admin_edit_user_account_details','uses'=>'MemberAccountDetailsController@ViewUserAccounts']);
    Route::post('/users/create-accounts/{id}',
          ['as'=>'create-user-barter-accounts','uses'=>'MemberAccountDetailsController@CreateUserBarterAccounts']);
    //cba credit and debit
    Route::post('/user/create-cba-accounts/{id}',
        ['as'=>'create-user-cba-accounts','uses'=>'MemberAccountDetailsController@CreateUserCbaAccount']);
    
    /*acccounts details search of user from admin panel*/
    Route::any('/users/search-account/{id}',
             ['as'=>'admin-search-user-account','uses'=>'MemberAccountDetailsController@SearchAccontsDetails']);
    /*delete transaction accounts details*/
    Route::get('/users/delete-transaction/{id}',
            ['as'=>'admin-delete-transaction','uses'=>'MemberAccountDetailsController@DeleteTransaction']);
    //financial details
    Route::get('/users/financial_details/{id}',
            ['as'=>'admin_user_edit_financial_details','uses'=>'MemberFinancialDetailsController@ViewUserFinance']);
    Route::post('/users/update_financial_details/{id}',
            ['as'=>'admin-user-update-financial-details','uses'=>'MemberFinancialDetailsController@UpdateFinanceDetails']);
    /*referal details*/
    Route::get('/users/referal-details',
            ['as'=>'admin-user-referral-details','uses'=>'ReferralController@ViewRefferal']);

    /*gift card details*/
    Route::get('/users/gift-card-details',
           ['as'=>'admin-user-gift-card-details','uses'=>'GiftCardController@ViewGIftCard']);
    Route::get('/gift-card/issue',['as'=>'issue-giftcacrd','uses'=>'GiftCardController@IssueGiftCard']);
    Route::post('/save-issue-gifts',['as'=>'save-giftcard','uses'=>'GiftCardController@SaveIssueGiftCard']);
    /*manage admin account*/
    Route::get('/manage-account',['as'=>'admin-manage-account','uses'=>'ManageAccountController@ManageAccount']);

    //Admin Settings
    Route::any('/setting/financial',['as' => 'admin_setting_finance','uses'=>'SiteController@financial']);
    Route::post('/setting/financial/store',['as' => 'admin_settings_store','uses'=>'SiteController@financial_store']);
    
    Route::any('/setting/address',['as' => 'admin_setting_address','uses'=>'SiteController@address']);
    Route::any('/setting/address/create',['as' => 'admin_exchange_address_create', 'uses'=>'SiteController@address_create']);
    Route::any('/setting/address/store',['as' =>'admin_exchange_address_store','uses'=>'SiteController@address_store']);
    
    Route::any('/setting/phone',             array('as' => 'admin_setting_phone',         'uses'=>'SiteController@phone'));
    Route::any('/setting/phone/create',['as' =>'admin_exchange_phone_create','uses'=>'SiteController@phone_create']);
    Route::any('/setting/phone/store',['as' =>'admin_exchange_phone_store','uses'=>'SiteController@phone_store']);
    
    Route::any('/setting/staffs',['as' => 'admin_setting_staffs','uses'=>'SiteController@staffs']);
    Route::any('/setting/staffs/create',['as' => 'admin_setting_staffs_create',         'uses'=>'SiteController@staff_create']);
    Route::post('/setting/staffs/store',['as' => 'admin_setting_staffs_store',         'uses'=>'SiteController@staff_store']);
    Route::any('/setting/staffs/edit/{id}',['as' => 'admin_setting_staffs_edit',         'uses'=>'SiteController@staff_edit']);
    Route::any('/setting/staffs/update/{id}',
                     ['as' => 'admin_setting_staffs_update','uses'=>'SiteController@staff_update']);
    Route::any('/setting/staff/delete/{id}',
                     ['as' => 'admin_staff_delete','uses'=>'SiteController@delete_staff']);
    
    Route::any('/set_tags',      array('as' => 'set_tags',    'uses' => 'MemberDetailsController@set_tags'));
    Route::any('/remove_tags',   array('as' => 'remove_tags',    'uses' => 'MemberDetailsController@remove_tags'));
    /*admin reports section start*/
    Route::get('reports',['as'=>'admin-reports','uses'=>'ReportsController@Reports']);
    Route::get('reports/top-traders',['as'=>'admin-reports-traders','uses'=>'ReportsController@TopTraders']);
    Route::post('reports/search-traders',['as'=>'admin-search-traders','uses'=>'ReportsController@ViewTraders']);
    Route::get('reports/member-on-standby',['as'=>'admin-member-standby','uses'=>'ReportsController@MemberOnStandby']);
    Route::post('reports/show-member-on-standby',['as'=>'admin-member-show-standby','uses'=>'ReportsController@ShowMemberOnStandby']);

    Route::get('reports/exchange-account-totals-by-member',['as'=>'admin-accounts-total-member','uses'=>'ReportsController@AccountsTotalbyMemeber']);
    Route::get('reports/inter-exchange-trading',['as'=>'admin-inter-exchange-trading','uses'=>'ReportsController@InterExchangeTrading']);
    Route::post('reports/show-exchange-trading',['as'=>'admin-search-exchange-traders','uses'=>'ReportsController@ShowExchangeTrading']);

    //Cash referral
    Route::any('/cash-referral',['as' => 'admin_cash_referral','uses'=>'CashRefarralController@lists']);
    Route::any('/cash-referral/{id}/details',['as' => 'admin_cash_referral_show','uses'=>'CashRefarralController@show']);


/*upload excel sheet to database bartercards number*/
/*Route::get('/upload/excel/view',['as'=>'upload_excel_view','uses'=>'MemberAccountDetailsController@ViewUploadExcel']);
Route::post('/upload/excel/',['as'=>'upload_excel','uses'=>'MemberAccountDetailsController@UploadExcel']);*/

});
/*member section*/
Route::group(['prefix'=>'member','namespace'=>'Member','middleware' => 'admin'],function(){
    
Route::get('/dashboard',['as'=>'member','uses'=>'MemberController@Member']);

Route::get('member-dashboard',['as'=>'admin_member_dashboard','uses'=>'SwitchMemberController@SwitchSelectMember']);

Route::get('/switch',['as'=>'switch-member','uses'=>'SwitchMemberController@SwitchMember']);

/*settings*/
Route::group(['prefix'=>'settings','namespace'=>'Setting','middleware' => 'admin'],function(){

     Route::get('/',['as'=>'member-setting','uses'=>'SettingController@MemebrSettings']);
     Route::post('/save-logo/{id}',['as'=>'save-logo','uses'=>'SettingController@SaveLogo']);
     Route::post('/update-member/{id}',['as'=>'update','uses'=>'SettingController@UpdateDirectorySetting']);
     /*users setting start*/
     Route::get('/users/{id}',['as'=>'users-setting','uses'=>'SettingController@UsersSettings']);
     Route::get('/user-create/{id}',['as'=>'users-create','uses'=>'SettingController@UsersCreate']);
      Route::get('/user-edit/{id}',['as'=>'users-edit','uses'=>'SettingController@UsersEdit']);
     Route::post('/user-save',['as'=>'users-save','uses'=>'SettingController@UsersSave']);

     Route::get('/addresses/{id}',['as'=>'users-address','uses'=>'SettingController@UsersAddress']);
     Route::get('/addresses-delete/{id}',['as'=>'users-delete-address','uses'=>'SettingController@DeleteAddress']);
     Route::get('/address/create/{id}',['as'=>'users-create-address','uses'=>'SettingController@CreateAddress']);
     Route::post('/address/save',['as'=>'users-save-address','uses'=>'SettingController@SaveAddress']);
     
     /*phone setting*/
     Route::get('/phone/{id}',['as'=>'users-phone','uses'=>'SettingController@UsersPhone']);
     Route::get('/phone/create/{id}',['as'=>'users-create-phone','uses'=>'SettingController@CreatePhone']);
     Route::post('/phone/save',['as'=>'users-save-phone','uses'=>'SettingController@SavePhone']);
     Route::get('/phone-delete/{id}',['as'=>'users-delete-phone','uses'=>'SettingController@DeletePhone']);

     /*cashier setting*/
     Route::get('/cashier/{id}',['as'=>'users-cashiers','uses'=>'SettingController@ListCashiers']);
     Route::get('/create/cashier/{id}',['as'=>'users-create-cashiers','uses'=>'SettingController@CreateCashiers']);
     Route::post('/save/cashier',['as'=>'users-save-cashiers','uses'=>'SettingController@SaveCashiers']);
     Route::any('/delete/cashier',['as'=>'delete-cashier','uses'=>'SettingController@DeleteCashier']);
     /*end section setting*/
});

    /*billing section start */
    Route::get('/billing',['as'=>'member-billing','uses'=>'BillingController@ViewBill']);
    Route::get('/billing/load-cba',['as'=>'member-load-cba','uses'=>'BillingController@LoadCba']);
    //Route::post('/billing/load-cba/insert',['as'=>'member-load-cba-insert','uses'=>'BillingController@LoadCbaInsert']);
    Route::get('/billing/payment-profile-add',['as'=>'member-payment-profile-add','uses'=>'BillingController@addPaymentProfile']);
    Route::post('/billing/payment-profile-store',['as'=>'member-payment-profile-store','uses'=>'BillingController@storePaymentProfile']);
    Route::get('/billing/payment-profile',['as'=>'member-payment-profile','uses'=>'BillingController@PaymentProfile']);
    Route::any('/billing/payment-profile-address-make-default/{id}',['as'=>'payment_profile_address_make_default','uses'=>'BillingController@ProfileAddressMakeDefault']);
    /*referrals*/
    Route::get('/referrals',['as'=>'referrals','uses'=>'ReferralController@Create']);
    Route::post('/referrals/store',['as'=>'referral_store','uses'=>'ReferralController@store']);
    
    Route::get('/transaction',['as'=>'transaction','uses'=>'TransactionController@index']);

    Route::any('/search/transcation',['as'=>'search-transcation','uses'=>'TransactionController@SearchTranscation']);
    Route::any('/search/member-transcation',['as'=>'admin-member-search-transcation','uses'=>'TransactionController@DateSearchTranscation']);
    
    /*directory section start*/
    Route::get('/directory',['as'=>'member-directory','uses'=>'DirectoryController@ViewDirectory']);
    
    Route::any('ajax/admin-member-directory',['as'=>'admin-member_directory_ajax','uses'=>'DirectoryController@ajaxMembers']);
    
    /*end section*/
    
});
/*end member section*/

/*
pos section start from here
*/
Route::group(['prefix'=>'pos','namespace'=>'admin\Pos','middleware' => 'admin'],function(){
    Route::get('/',['as'=>'pos','uses'=>'PosController@View']);
    Route::get('/sale',['as'=>'pos-sale','uses'=>'SaleController@View']);
    Route::post('/save_sale',['as'=>'save-sale','uses'=>'SaleController@SaveSaleBarterCard']);


    Route::get('/purchase',['as'=>'pos-purchase','uses'=>'PurchaseController@View']);
    Route::post('save-purchase',['as'=>'save-pos-purchase','uses'=>'PurchaseController@SavePurchase']);
    /*check sale barter available*/
    Route::post('/search/bartercard',['as'=>'search-bartercard-sale','uses'=>'SaleController@SearchBartercard']);
});
/*end pos section*/

/*
directory section start
*/
/*Route::get('/worldpay', function () {
    return view('admin/worldpay/add');
});*/
Route::group(['prefix'=>'directory','namespace'=>'admin\Directory','middleware' => 'admin'],function(){
    Route::any('/',['as'=>'directory','uses'=>'DirectoryController@View']);
    Route::post('/directory-ajax',['as'=>'directory-ajax','uses'=>'DirectoryController@ajaxMembers']);
});
/*end directory section*/

Route::group(['prefix'=>'member','namespace'=>'Member'],function(){
    Route::get('/billing/load-cba/redirect',['as'=>'member-load-cba-redirect','uses'=>'BillingController@LoadCbaRedirect']);
    Route::post('/billing/load-cba/insert',['as'=>'member-load-cba-insert','uses'=>'BillingController@LoadCbaInsert']);
});







