<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test',function(){
    return response([1,2,3,4],200);   
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


/*
 *  [ API v2 functions ]
 */

Route::group(['prefix' => 'v2','namespace'=>'api'], function() {

	// authentication
	Route::post('auth/login', ['uses' => 'LoginController@login']); // DONE
	Route::post('/forgotPassword', ['uses' => 'LoginController@forgotPassword']);

	// user - change entity selections
	Route::post('selected/member/change', ['uses' => 'UserController@changeSelectedMember']);

	// giftcards
	Route::post('giftcard/balance', ['as' => 'api.v2.giftcard.balance', 'uses' => 'ApiV2GiftcardController@checkBalance']);

	// exchange - directory
	//Route::get('directory/exchange', ['uses' => 'DirectoryController@exchange']);
	Route::get('directory/exchange', ['uses' => 'ApiV2DirectoryController@exchange']); // DONE

	// pos
	Route::get('pos/card/lookup', ['as' => 'api.v2.pos.card.lookup', 'uses' => 'ApiV2PosCardController@lookup']);

	Route::get('pos/member/cashiers', ['as' => 'api.v2.pos.member.cashiers', 'uses' => 'ApiV2PosMemberController@cashierList']);

	// Route::post('pos/member/card/sale', ['as' => 'api.v2.pos.member.card.sale', 'uses' => 'ApiV2PosMemberController@cardSale']);
	Route::post('pos/member/card/sale', ['as' => 'api.v2.pos.member.card.sale', 'uses' => 'ApiV2PosCardController@cardSale']);

	Route::get('pos/member/merchants', ['as' => 'api.v2.pos.member.merchants', 'uses' => 'ApiV2PosMemberController@merchantsList']);

	Route::post('pos/member/purchase', ['as' => 'api.v2.pos.member.purchase', 'uses' => 'ApiV2PosCardController@memberPurchase']);

	// member
	Route::get('member/dashboard/selected', ['uses' => 'ApiV2MemberController@getForDashboard']);
	Route::get('member/transactions/selected', ['uses' => 'ApiV2MemberTransactionController@allForSelected']);
	
	// Route::get('members', ['uses' => 'ApiV2MemberController@index']);
	// Route::get('member/{member_id}', ['uses' => 'ApiV2MemberController@show']);
	// Route::get('member/categories', ['uses' => 'ApiMemberController@categories']);

	// member billing
	Route::post('member/billing/load/new', ['as' => 'api.v2.member.billing.load.new', 'uses' => 'ApiV2MemberBillingController@loadNew']);
	Route::post('member/billing/load/profile', ['as' => 'api.v2.member.billing.load.profile', 'uses' => 'ApiV2MemberBillingController@loadProfile']);
	
	Route::get('member/billing/profiles', ['as' => 'api.v2.member.billing.profiles', 'uses' => 'ApiV2MemberBillingProfileController@getByMember']);
	Route::post('member/billing/profile/create', ['as' => 'api.v2.member.billing.profile.create', 'uses' => 'ApiV2MemberBillingProfileController@create']);

	// member referrals
	Route::post('member/referral/send', ['as' => 'api.v2.member.referral.send', 'uses' => 'ApiV2MemberReferralController@send']); // DONE
	
	// cash referrals
	Route::post('member/referralcash/get_directory', ['as' => 'api.v2.member.referralcash.getDirectory', 'uses' => 'ApiV2MemberReferralCashController@getDirectory']);
	Route::post('member/referralcash/send', ['as' => 'api.v2.member.referralcash.send', 'uses' => 'ApiV2MemberReferralCashController@send']); // DONE

	// exchange giftcards
	Route::post('exchange/giftcard/issue/member', ['as' => 'api.v2.exchange.giftcard.issue.member', 'uses' => 'ApiV2ExchangeGiftcardController@issueToMember']);

	// users
	// Route::post('member/image/load/new', ['as' => 'api.v2.member.billing.load.new', 'uses' => 'ApiV2MemberBillingController@loadNew']);

});
