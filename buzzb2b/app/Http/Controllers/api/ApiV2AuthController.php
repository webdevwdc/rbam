<?php
namespace App\Http\Controllers\api;
use App\Api\Validation\User\LoginForm;
use Laracasts\Validation\FormValidationException;
// use Peos\Api\Validation\InputValidationException;
use Peos\Users\Authentication\PeosAuthenticationException;
use Peos\Api\Transformers\UserTransformer;
use Peos\Api\Transformers\UserMemberAssociationTransformer;
use Laracasts\Commander\Events\DispatchableTrait;
use Peos\Users\Authentication\Events\UserLoggedIn;

class ApiV2AuthController extends ApiV2Controller {

	use DispatchableTrait;
	
	protected $userLoginForm;

	public function __construct(LoginForm $userLoginForm)
	{
		parent::__construct();

		$this->userLoginForm = $userLoginForm;
	}

	/**
	 * @api {post} /api/v2/auth/login
	 * @apiName Login
	 * @apiGroup Authentication
	 * @apiVersion 2
	 * @apiDescription Validates a users credentials and returns a token
	 *
	 * @apiParam {String} email Users email
	 * @apiParam {String} password Users password
	 *
	 * @apiSuccess {String} token A JWT token
	 */
	public function login()
	{
		//die('aaa');
		try
		{
			$this->userLoginForm->validate(\Input::all());

			\Auth::validate(['email' => \Input::get('email'), 'password' => \Input::get('password')]);

			$user = \Auth::getProvider()->retrieveByCredentials(['email' => \Input::get('email'), 'password' => \Input::get('password')]);
                        
                        
			$user->forceSelectedMember();
			$user->forceSelectedExchange();

			$user->raise(new UserLoggedIn($user));

			$this->dispatchEventsFor($user);

			// create json web token
			$token = \JWTAuth::fromUser($user);

			//return $this->respondWithData(['token' => $token] + ['user' => $this->makeItem($user, new UserTransformer)] + ['memberAssociations' => $this->makeCollection($user->members, new UserMemberAssociationTransformer)]);
		
			return $this->respondWithData(['token' => $token] + ['user' => $this->makeItem($user, new UserTransformer)] + ['memberAssociations' => $this->makeCollection($user->members, new UserMemberAssociationTransformer)] + ['lat' => '22.5726'] + ['long' => '88.3639']);
		
		}
		catch (FormValidationException $e)
		{
			return $this->respondValidationFailed($e);
		}
		catch (PeosAuthenticationException $e)
		{
			return $this->respondAuthenticationFailed($e->getMessage());
		}
		catch (\Exception $e)
		{
			return $this->respondGeneralException($e->getMessage());
		}
	}

	

}