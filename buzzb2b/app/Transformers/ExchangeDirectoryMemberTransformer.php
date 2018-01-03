<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Member;

class ExchangeDirectoryMemberTransformer extends TransformerAbstract {

	protected $defaultIncludes = [
		'defaultAddress',
		'primaryContact',
		'primaryPhone',
		'exchange',
		'categories'
	];

	public function transform(Member $member)
	{
		return [
			'id'           => $member->id,
			'name'         => $member->name,
			'description'  => $member->description,
			'websiteUrl'   => $member->website_url,
			'onStandby'    => (bool) $member->standby,
			'logoFilePath' => $member->logoImage(true),
			'logoFilePathSm' => $member->logoImage(true, 'sm'),
			'logoFilePathXs' => $member->logoImage(true, 'xs')
		];
	}

	public function includeDefaultAddress(Member $member)
	{
		//echo 'aaaaaaa';
		//dd($member);
		$defaultAddress = $member['addresses'][0];

		return $this->item($defaultAddress, new AddressTransformer);
	}

	public function includePrimaryContact(Member $member)
	{
		$primaryContact = $member['user'][0];

		return $this->item($primaryContact, new UserTransformer);
	}

	public function includePrimaryPhone(Member $member)
	{
		$primaryPhone = $member['phones'][0];

		return $this->item($primaryPhone, new PhoneTransformer);
	}

	public function includeExchange(Member $member)
	{
		return $this->item($member->exchange, new ExchangeTransformer);
	}

	public function includeCategories(Member $member)
	{
		return $this->collection($member['categories'], new CategoryTransformer);
	}
}