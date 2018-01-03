<?php namespace App\Api\Commands\User;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Peos\Users\Authentication\Events\UserLoggedIn;

class AuthenticateUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	public function handle($command)
	{
		if ( \Auth::validate(['email' => $command->email, 'password' => $command->password]))
		{
			$user = \Auth::getProvider()->retrieveByCredentials(['email' => $command->email, 'password' => $command->password]);

			$user->forceSelectedMember();
			$user->forceSelectedExchange();

			$user->raise(new UserLoggedIn($user));

			$this->dispatchEventsFor($user);

			return $user;
		}
		else
		{
			return false;
		}
	}

}