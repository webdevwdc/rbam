<?php

namespace App;

use  App\MemberUser;
use App\LedgerDetails;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use SearchableTrait;
    
    /**
    * Searchable rules.
    *
    * @var array
    */
    protected $searchable = [
	    'columns' => [
		    'members.name' => 10,
		    'categories.name' => 4,
		    'tags.name' => 3,
	    ],
	    'joins' => [
		    'member_categories' => ['members.id','member_categories.member_id'],
		    'categories' => ['member_categories.category_id','categories.id'],
		    'member_tags' => ['members.id','member_tags.member_id'],
		    'tags' => ['member_tags.tag_id','tags.id'],
	    ],
    ];
    
    public function scopeVisible($query)
    {
	    return $query->where('view_on_dir', '1');
    }
    
    public function ledger()
    {
	return $this->hasMany('App\LedgerDetails', 'member_id');
    }
    
    public function exchange()
    {
        return $this->belongsTo('App\Exchange', 'exchange_id');
    }
    
    public function memberuser(){
        return $this->hasOne('App\MemberUser','member_id');
    }

    public function user(){
       return $this->belongsToMany('App\User','member_users')->withPivot('id','primary','admin','can_access_billing','can_pos_sell','can_pos_purchase','monthly_trade_limit');
    }      
    
    public function image(){
       return $this->hasOne('App\Image','imageable_id');
    }      
    
    public function category(){
       return $this->belongsToMany('App\Category','member_categories');
    }
    public function tag(){
       return $this->belongsToMany('App\Tag','member_tags');
    }
    
    public function address(){
	return $this->hasMany('App\Address', 'addresses')->where('addressable_type', 'Member');
    }
    
    public function phones()
    {
	return $this->hasMany('App\Phone', 'phoneable_id')->orderBy('is_primary', 'desc');
    }
    
    public function setSelectedMember($member_id,$user_id)
    {       
	// deselect all of user's members
	\DB::table('member_users')->where('user_id', $user_id)->update(['selected' => false]);

	// mark select requested member in db
	\DB::table('member_users')->where('user_id', $user_id)->where('member_id', $member_id)->update(['selected' => true]);

	return true;
    }
    
    public function categories()
    {
	return $this->belongsToMany('App\Category', 'member_categories')->orderBy('name', 'asc');
    }

    public function tags()
    {
	return $this->belongsToMany('App\Tag', 'member_tags')->orderBy('name', 'asc');
    }
    
    public function addresses()
    {
	//return $this->morphMany('App\Address', 'addressable')->orderBy('is_default', 'desc');
	return $this->hasMany('App\Address', 'addressable_id')->orderBy('is_default', 'desc');
    }
    
    public function addresses2()
    {
	return $this->hasMany('App\Address', 'addressable_id')->orderBy('is_default', 'desc');
    }
    
    public static function delete_member($member_id)
    {
        /*** Update into Member Table ***/
        
        $member                   = Member::find($member_id);
        $member->deleted_at       = date('Y-m-d H:i:s');
        $member->save();
        
        /*** Update into User Table ***/
        $member_user = MemberUser::select('user_id')->where('member_id', $member_id)->first();
        $user_id     = $member_user->user_id;
        
        $user                   = User::find($user_id);
        $user->deleted_at       = date('Y-m-d H:i:s');
        $user->save();
    }
    
    public function logoImage($returnPath = false, $pathSizeTag = false)
    {	
	
    if($img){
	    if (\File::exists(asset('upload/members/thumb/' . $img->filename)))
            {
		  return 'upload/members/thumb/' . $img->filename;
	    }else
        {
		  return 'images/blank.png';
	    }	    
	}
    else
    {
	    return 'images/blank.png';
	}
    

	//if ( ! $returnPath)
	//    return $img;
	//
	//if ($img)
	//{
	//    return 'img/bin/' . $img->filenameWithSizeTag($pathSizeTag);
	//}
	//
	//$sizeTagString = ($pathSizeTag) ? '_' . $pathSizeTag : '';
	//return 'img/icon/member-logo-default' . $sizeTagString . '.png';
    }

   
    
    /**
    * Retrieve a member's cba balance
    * 
    * @return int PeosDecimal
    */
   public function cbaBalance($date = false)
   {
    $query = LedgerDetails::
                    whereIn('account_code', ['3010', '3020', '4030', '4040', '4070', '4090', '7010', '7020', '7030', '7040', '7070', '7090'])
                    ->where('member_id', $this->id);

            if ($date)
                    $query = $query->where('created_at', '<=', $date->addSeconds(5));
            
            return (int) $query->sum('amount');
	//return LedgerDetails::getMemberCbaBalance($this->id, $date);
   }
   
   /**
    * Retrieve a member's barter balace on a specified date, defaults to now
    * 
    * @param  string  $date
    * @return int     PeosDecimal
    */
    public function barterBalance($date = false)
    {
	$query = LedgerDetails::
			whereIn('account_code', ['4010', '4020', '4050', '4080', '6010'])
			->where('member_id', $this->id);

		if ($date)
			$query = $query->where('created_at', '<=', $date->addSeconds(5));
		
		return (int) $query->sum('amount');
	//return $ledgerRepo->getMemberBarterBalance($this->id, $date);
    }

    protected $table = 'members';
    public $fillable = [ 'exchange_id',
                        'name',
                        'slug',
                        'business_1099_name',
                        'tax_id_number',
                        'ex_purchase_comm_rate',
                        'ex_sale_comm_rate',
                        'website_url',
                        'giftcard_comm_rate',
                        'credit_limit',
                        'accept_giftcards',
                        'prospect',
                        'is_active_salesperson',
                        'is_active_salesperson',
                        'description',
                        'view_on_dir',
                        'ref_member_id',
                        'ref_purchase_comm_rate',
                        'ref_sale_comm_rate',
                        'salesperson_member_id',
                        'sales_purchase_comm_rate',
                        'sales_sale_comm_rate'
                        ];

    
}
