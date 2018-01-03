<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Role,App\Role_user, App\Exchange, App\Member, App\MemberUser, App\Address, App\Phone, App\State, App\PhoneType,App\Category;
use Hash;
use App\Helpers;

use App\Transformers\ExchangeDirectoryMemberTransformer;
use App\Transformers\ExchangeTransformer;
use App\Transformers\CategoryTransformer;

class ApiV2DirectoryController extends ApiV2Controller {

	public function __construct()
	{
		parent::__construct();
		
		// $this->user = \JWTAuth::parseToken()->authenticate();
	}

	/**
	 * @api {get} /directory/exchange Request exchange directory members
	 * @apiName GetExchange
	 * @apiGroup Directory
	 *
	 * @apiParam {string}  domain     (required)  Exchange domain
	 * @apiParam {string}  query      (optional)  A search string
	 * @apiParam {array}   category   (optional)  Member categories
	 * @apiParam {array}   exchanges  (optional)  Partner exchanges
	 *
	 * @apiSuccess {Collection} Members
	 */
	public function exchange(Request $request)
	{
                try
		{
			// get exchange data			
			$exchange= Exchange::where('domain', $request->domain)->first();
			
			if ( ! $exchange)
			{
				return $this->respondNotFound('Exchange domain not valid.');
			}
			// get selected domains
			$selectedDomains = ( ! empty($request->exchanges)) ? $request->exchanges : [];
			$relatedExchanges = $exchange->relatedExchanges();
			$directoryViewable = true;
			$includeParentExchange = true;
			$onlyVisibleMembers = true;
			//if ($directoryViewable)
			//{
			//	$relatedExchanges = $relatedExchanges->directoryViewable();
			//}
			//dd($relatedExchanges);
			$exchanges = $relatedExchanges->get();
	
			if ($includeParentExchange)
			{
				$exchanges->add($exchange);
			}
			$partnerExchanges = $exchanges;
			
			$categoryIds = [];

			$domains = $selectedDomains;
			$domains[] = $exchange->domain;
			
			foreach ($domains as $domain)
			{
				$exchange = Exchange::where('domain', $domain)->first();
	
				$members = $exchange->member();
				
	
				//if ($onlyVisibleMembers)
				//{
				//	$members = $members->visible();
				//}
	
				$exchangeMemberIds = $members->get()->pluck('id');
	
				$exchangeCategoryIds = \DB::table('member_categories')->whereIn('member_id', $exchangeMemberIds)->pluck('category_id')->toArray();				
	
				//$categoryIds = $categoryIds + $exchangeCategoryIds;
				$categoryIds = array_merge($categoryIds, $exchangeCategoryIds);
			}
			//dd($categoryIds);
			$selectedCategories = Category::whereIn('id', $categoryIds)->orderBy('name', 'asc')->groupBy('id')->get();
			
			$q = $request->query;
			$selectedCat = $request->category;
			if ( ! count($selectedDomains))
			{
				$members = false;
			}else{				
				$partnerDomains = $exchange->relatedExchanges()->get()->pluck('id', 'domain')->toArray();
				$array = array_only($partnerDomains, $selectedDomains);
				
				if (in_array($exchange->domain, $selectedDomains))
				{
					$array = array_add($array, $exchange->domain, $exchange->id);
				}
				list($keys, $partnerDomainIds) = array_divide($array);
				
				$imembers = Member::whereIn('exchange_id', $partnerDomainIds);
				//dd($q);
				//if ($q)
				//{
				//	$members = $members->search($q);
				//}
				$imembers = $imembers->visible()->with('categories', 'tags')
				->with(['addresses' => function($query)
				{
				    //$query->where('is_default', true);
				
				}])->with(['user' => function($query)
				{
				    $query->wherePrimary(true);
				
				}])->with(['phones' => function($query)
				{
				    //$query->whereIsPrimary(true);
				
				}])->orderBy('name', 'asc')->groupBy('id');
				
				if (count($selectedCategories))
				{
					$imembers = $imembers->whereHas('categories', function($query) use ($selectedCategories)
						{
							$query->whereIn('slug', $selectedCategories);
						});
				}
				//dd($imembers);
				$members = $imembers->get();
				
			}
			$members = ($members) ?: [];
			
			//dd($members);
			//list($keys, $partnerDomainIds) = array_divide($array);
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
                //dd($members);
		return $this->respond(['meta' => $meta] + ['members' => $this->makeCollection($members, new ExchangeDirectoryMemberTransformer)] + ['exchange' => $this->makeItem($exchange, new ExchangeTransformer)] + ['categories' => $this->makeCollection($selectedCategories, new CategoryTransformer)] + ['partnerExchanges' => $this->makeCollection($partnerExchanges, new ExchangeTransformer)]);
	}

}
