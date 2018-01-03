<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Users\User;

class UserTransformer extends TransformerAbstract {

	public function transform(User $user)
    {
        return [
			'firstname'         => $user->firstname,
			'lastname'          => $user->lastname,
			'fullname'          => $user->fullname,
			'email'             => $user->email,
			'avatarImagePath'   => $user->avatarImage(true),
			'avatarImagePathSm' => $user->avatarImage(true, 'sm'),
			'avatarImagePathXs' => $user->avatarImage(true, 'xs')
        ];
    }
}