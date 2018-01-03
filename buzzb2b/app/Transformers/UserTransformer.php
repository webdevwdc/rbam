<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract {

	public function transform(User $user)
    {
        return [
			'firstname'         => $user->first_name,
			'lastname'          => $user->last_name,
			'fullname'          => $user->first_name.' '.$user->last_name,
			'email'             => $user->email,
			/*'avatarImagePath'   => $user->avatarImage(true),
			'avatarImagePathSm' => $user->avatarImage(true, 'sm'),
			'avatarImagePathXs' => $user->avatarImage(true, 'xs')*/
        ];
    }
}