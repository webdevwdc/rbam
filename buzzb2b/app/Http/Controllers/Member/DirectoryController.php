<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,\Session;
use App\Member, App\MemberCategory, App\Exchange,  App\Address, App\Image, App\Phone;

class DirectoryController extends Controller
{
    public function ViewDirectory(){
    	//return "Controller";
    
	$memberID = Session::get('MEMBER_ID');
    	$exchangeID = Session::get('EXCHANGE_ID');
	
        $data['records'] = Member::where('id', $memberID)->get();
        $data['memberCategories'] = MemberCategory::where('member_id', $memberID)->get();
        $data['memberExchange'] = Exchange::where('id', $exchangeID)->first();
	
	return view('member.directory.dashboard', compact('exchangeID'));
    }
    
    public function ajaxMembers(Request $request)
    {
        $input      	= $request->all();

	$search_member	= trim($input['search_member']);
    
        if (!empty($input['category']))
	{
	    $category = $input['category'];
	    $category = substr($category, 0, strlen($category)-1);
        }
	else
	{
	    $category = '';
        }

        if (!empty($input['exchanges']))
	{
	    $exchanges = $input['exchanges'];
	    $exchanges = substr($exchanges, 0, strlen($exchanges)-1);
        }
	else
	{
	    $exchanges = '';
        }
    
	$directories = Member::select('members.id','members.*', 'users.email', 'users.image')->where('members.id', '!=', '');

	if($exchanges != '')
	{
	    if(count($exchanges) > 1)
	    {
		$directories->whereIn('members.exchange_id',$exchanges);
	    }
	    else
	    {
		$directories->where('members.exchange_id',$exchanges);
	    }
	}
    
	if($search_member !='')
	{
	    //$directories->where('members.name','LIKE', '%'.$search_member.'%');
	    //$directories->orwhere('members.business_1099_name','LIKE', '%'.$search_member.'%');
	    
	    $directories->where('tags.name','LIKE', '%'.$search_member.'%');
	}
    
	if($category != '')
	{
	    $directories->Join('member_categories','members.id','=','member_categories.member_id');
	    $directories->whereIn('member_categories.category_id',explode(',',$category));
	}
    
	$directories->Join('member_users','members.id','=','member_users.member_id');
	$directories->Join('users','member_users.user_id','=','users.id');
	$directories->Join('member_tags','members.id','=','member_tags.member_id');
	$directories->Join('tags','member_tags.tag_id','=','tags.id');
	$directories->groupBy('members.id');
	
	$result = $directories->get();
	
	$html = '<ul class="list-unstyled results-members-list">';
	
	if(count($result) > 0)
	{
	    $member_address1 = $member_address2 = $member_email_address = $member_website = '';
	    
	    foreach($result as $result_member)
	    {
		$image = '<img src="'.asset('images/blank.png') . '" width="100" height="100">';
		
		if(count($result_member))
		{
		    $member_id = $result_member->id;
		    $member_address = Address::select('address1', 'address2', 'city', 'zip')
				    ->where('addressable_id', $member_id)
				    ->where('addressable_type', 'Member')
				    ->where('is_default', 'Yes')
				    ->first();
				    
		    if(count($member_address) == 0)
		    {
			$member_address = Address::select('address1', 'address2', 'city', 'zip')
				    ->where('addressable_id', $member_id)
				    ->where('addressable_type', 'Member')
				    ->first();
		    }
		    
		    $member_phone_arr = Phone::select('number')
					->where('phoneable_id', $member_id)
					->where('phoneable_type', 'Member')
					->where('is_primary', 'Yes')
					->first();
				    
		    if(count($member_phone_arr) == 0)
		    {
			$member_phone_arr = Phone::select('number')
					    ->where('phoneable_id', $member_id)
					    ->where('phoneable_type', 'Member')
					    ->first();
		    }
		
		    $member_actual_phone = $member_phone_arr['number'];
		    $member_phone = '('.substr($member_phone_arr['number'], 0, 3).') '.substr($member_phone_arr['number'], 3, 3).'-'.substr($member_phone_arr['number'],6);		    
				    
		    $member_image = Image::select('filename')
				    ->where('imageable_id', $member_id)
				    ->where('image_type', 'MemberLogo')
				    ->first();
		
		    if(count($member_address) > 0)
		    {
			$member_address1 = $member_address['address1'].',';
			$member_address2 = $member_address['city'].', '.$member_address['zip'];
		    }
		    
		    $member_email_address = $result_member->email;
				
		    if($member_image['filename'] != '' && file_exists(public_path() . '/upload/members/thumb/' .'/'. $member_image['filename']))
		    {
			$image = '<img src="'.asset('upload/members/thumb/').'/'.$member_image['filename'].'" width="100" height="100">';
		    }
		    
		    if($result_member->website_url != '')
		    {
			$member_website = '<li><a href="'.$result_member->website_url.'" target="_new"><img src="'.asset('images/website_url.png').'"></a></li>';
		    }
		    
		    $icon_w = '<img src="'.asset('images/').'/icon-w.png">';
		    
		    $html .= '<li class="clearfix"><div class="row directory"><div class="col-xs-3 col-sm-2 member-image">'.$image.'</div><div class="col-xs-9 col-sm-10"><div class="col-xs-12 col-sm-8 col-md-7 col-lg-8 member-description"><h1 class="lead" style="margin-top: 10px; margin-bottom: 0px;"><strong>'.$result_member->name.'</strong></h1><p class="text-muted">'.$result_member->description.'</p></div><div class="col-xs-12 col-sm-4 col-md-5 col-lg-4 member-details"><div><div><p><strong>'.$result_member->name.'</strong></p><address class="add">'.$member_address1.' <br>'.$member_address2.'</address><p><a href="mailto:'.$member_email_address.'">'.$member_email_address.'</a><br><a href="tel:+1'.$member_actual_phone.'">'.$member_phone.'</a></p><ul class="list-inline" style="margin-top:14px;"><li><a href="http://www.1stophouston.com" target="_new">'.$icon_w.'</a></li></ul></div></div></div></div></div></li>';
		}
	    }
	}
	else
	{
	    $html .= '<li>No record found</li>';
	}
	$html .= '</ul>';
	
	echo $html;exit();    
    }
}
