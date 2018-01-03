<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category;
use Hash;
use App\Helpers;
use App\Transformers\MemberTransformer;
use App\Transformers\ExchangeDirectoryMemberTransformer;
use App\Transformers\ExchangeTransformer;
use App\Transformers\CategoryTransformer;

class DirectoryController extends ApiV2Controller
{  
    protected $user;
    protected $id;

    public function __construct()
    {
	parent::__construct();
    }
    
    public function exchange(Request $request)
    { 
	try
	{       
	    $exchange = Exchange::where('domain', $request->domain)->first();

	    if ( ! $exchange)
	    {
		return $this->respondNotFound('Exchange domain not valid.');
	    }

	    // get selected domains
	    $selectedDomains = ( ! empty($request->exchanges)) ? $request->exchanges : [];
	   
	    // get partner exchanges for this exchange
	    //$partnerExchanges = $this->exchangeRepo->getPartnerExchangesByExchange($exchange);
	     
	    // get category summary for the resulting members
	    ///$selectedCategories = $this->categoryRepo->getByExchangeDomains($exchange, $selectedDomains, true);
		
	    $categoryIds = [];
    
	    $domains = $selectedDomains;
	    $domains[] = $exchange->domain;

	    foreach ($domains as $domain)
	    {
		$exchange = Exchange::where('domain',$domain)->first();
		$members = $exchange->member();
		$members = $members->where('view_on_dir',true);
		$exchangeMemberIds = $members->get()->pluck('id');
		$exchangeCategoryIds = \DB::table('member_categories')->whereIn('member_id', $exchangeMemberIds)->pluck('category_id');		
		$categoryIds[] = $exchangeCategoryIds;
	    }
	
	    $selectedCategories = Category::whereIn('id', $categoryIds)->orderBy('name', 'asc')->groupBy('id')->get();
		
	    //get directory member results based on criteria
	    //$members = $this->memberRepo->getByDirectorySearch($exchange, \Input::get('query'), \Input::get('category'), $selectedDomains);
	    //$members = ($members) ?: [];
	    $members = [];
	}
	catch (FormValidationException $e)
	{
	    return $this->respondValidationFailed($e);
	}

	$meta = [
	    'query' => $request->query,
	    'selectedCategories' => $selectedCategories,
	    'selectedExchanges' => $selectedDomains,
	];
	
	return $this->respond(['meta' => $meta] + ['members' => $this->makeCollection($members, new ExchangeDirectoryMemberTransformer)] + ['exchange' => $this->makeItem($exchange, new ExchangeTransformer)] + ['categories' => $this->makeCollection($selectedCategories, new CategoryTransformer)] + ['partnerExchanges' => ['data'=>[]]]);
    }
}