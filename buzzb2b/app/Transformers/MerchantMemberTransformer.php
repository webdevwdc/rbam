<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Member;
//use Peos\Members\Member;

class MerchantMemberTransformer extends TransformerAbstract {

	public function transform(Member $member)
	{
		$getImage = (count($member->image) > 0) ? asset('uploads/members/' . $member->image->filename) : asset('images/blank.png'); 
		return [
			'name'         => $member->name,
			'slug'         => $member->slug,
			'logoFilePathSm' => $getImage,
		];
	}
}