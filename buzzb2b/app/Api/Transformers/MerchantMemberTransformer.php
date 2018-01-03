<?php 
namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
// use Peos\Members\Member;

use App\Member;

class MerchantMemberTransformer extends TransformerAbstract {

	public function transform(Member $member)
    {
        /*return [
			'name'         => $member->name,
			'slug'         => $member->slug,
			'logoFilePathSm' => $member->logoImage(true, 'sm'),
        ];*/

        $getImage = (count($member->image) > 0) ? 'upload/members/' . $member->image->filename : 'images/blank.png';

		return [
			'name'         => $member->name,
			'slug'         => $member->slug,
			'logoFilePathSm' => $getImage,
		];
    }
}