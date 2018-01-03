<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Member;
use App\Address;
use App\Phone;

class MemberTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
        'exchange',
        'defaultAddress',
         'primaryPhone',   
	'primaryContact', 	
    ];

    public function transform(Member $member)
    {
        return [
			'name'         => $member->name,
			'slug'         => $member->slug,
			'description'  => $member->description,
			'websiteUrl'   => $member->website_url,
			'onStandby'    => (bool) $member->standby,
                        /*'logoFilePath' => $member->logoImage(true),
			'logoFilePathSm' => $member->logoImage(true, 'sm'),
			'logoFilePathXs' => $member->logoImage(true, 'xs')*/
			
        ];
    }

    public function includeExchange(Member $member)
    {
        return $this->item($member->exchange, new ExchangeTransformer);
    }

    public function includeDefaultAddress(Member $member)
	{
		//$defaultAddress = ( ! empty($member['addresses'][0])) ? $member['addresses'][0] : false;
                $default_address = Address::select('*','address1 as full')->where('addressable_id',$member->id)->where('addressable_type','Member')->first();
                return $this->item($default_address, new AddressTransformer);
	}

	public function includePrimaryContact(Member $member)
	{
		$primaryContact = ( ! empty($member['user'][0])) ? $member['user'][0] : false;
                return ($primaryContact) ? $this->item($primaryContact, new UserTransformer) : null;
	}

	public function includePrimaryPhone(Member $member)
	{
		//$primaryPhone = ( ! empty($member['phones'][0])) ? $member['phones'][0] : false;
                $primaryPhone = Phone::select('*')->where('phoneable_id',$member->id)->where('phoneable_type','Member')->first();
		return $this->item($primaryPhone, new PhoneTransformer);
	}
}