<?php

namespace Modules\Identity\Repositories;

use Zttp\Zttp as Http;
use Modules\Core\Helpers\Response;
use Laravel\Passport\Passport;
use Laravel\Passport\RefreshTokenRepository;

class PassportRepository {

	/**
	 * Create access token from attributes.
	 *
	 * @param array $attributes
	 * @return \Illuminate\Http\Response
	 */
	public static function createAccessToken($attribute){

		self::revokeAccessTokensFor($attribute['user_id'], $attribute['client_id']);

		$response = Http::asFormParams()
			->withoutVerifying()
			->post(route('passport.token'), [
				'grant_type' => 'password',
				'client_id' => $attribute['client_id'],
				'client_secret' => $attribute['client_secret'],
				'username' => $attribute['email'],
				'password' => $attribute['password'],
				'scope' => '*',
			]);

		if (!$response->isOk()) {
			return Response::unauthorized([
				'message' => 'Email or password is incorrect',
				"description" => $response->json(),
			]);
		}
		return $response->json();
	}

	/**
	 * Revoke Other Access Tokens for the specified user
	 * 
	 * 
	 * @param int $clientId
	 * @param int $userId
	 * @return void
	 */
	public static function revokeAccessTokensFor($userId, $clientId){
		$token = Passport::token();
		
		$token = $token->where('client_id', $clientId)->where('user_id', $userId)->where('revoked', false);

		$token->get()->map(function($token){
			(new RefreshTokenRepository)->revokeRefreshTokensByAccessTokenId($token->id);
		});

		$token->update(['revoked' => true]);
	}


	/**
	 * Refresh the user access token.
	 *
	 * @param array $attributes
	 * @return \Illuminate\Http\Response
	 */
	public static function refreshAccessToken($attribute){

		$response = Http::asFormParams()
			->withoutVerifying()
			->post(route('passport.token'), [
				'grant_type' => 'refresh_token',
				'client_id' => $attribute['client_id'],
				'client_secret' => $attribute['client_secret'],
				'refresh_token' => $attribute['refresh_token'],
				'scope' => '*',
			]);


		if (!$response->isOk()) {
			return Response::unauthorized([
				'message' => 'Email or password is incorrect',
				"description" => $response->json(),
			]);
		}
		
		return $response->json();
	}

	/**
	 * Revoke User access.
	 *
	 * @param array $attribute
	 * @return void
	 */
	public static function revokeUserAccess($attribute){
		return self::revokeAccessTokensFor($attribute['user_id'], $attribute['client_id']);
	}

}