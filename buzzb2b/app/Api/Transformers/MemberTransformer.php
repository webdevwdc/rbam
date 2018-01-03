<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Members\Member;

class MemberTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
        'exchange',
        'defaultAddress',
		'primaryContact',
		'primaryPhone'
    ];

    public function transform(Member $member)
    {
        return [
			'name'         => $member->name,
			'slug'         => $member->slug,
			'description'  => $member->description,
			'websiteUrl'   => $member->website_url,
			'onStandby'    => (bool) $member->standby,
			'logoFilePath' => $member->logoImage(true),
			'logoFilePathSm' => $member->logoImage(true, 'sm'),
			'logoFilePathXs' => $member->logoImage(true, 'xs')
        ];
    }

    public function includeExchange(Member $member)
    {
        return $this->item($member->exchange, new ExchangeTransformer);
    }

    public function includeDefaultAddress(Member $member)
	{
		$defaultAddress = ( ! empty($member['addresses'][0])) ? $member['addresses'][0] : false;

		return $this->item($defaultAddress, new AddressTransformer);
	}

	public function includePrimaryContact(Member $member)
	{
		$primaryContact = ( ! empty($member['users'][0])) ? $member['users'][0] : false;

		return ($primaryContact) ? $this->item($primaryContact, new UserTransformer) : null;
	}

	public function includePrimaryPhone(Member $member)
	{
		$primaryPhone = ( ! empty($member['phones'][0])) ? $member['phones'][0] : false;

		return $this->item($primaryPhone, new PhoneTransformer);
	}
}