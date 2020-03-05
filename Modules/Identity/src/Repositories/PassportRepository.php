<?php

namespace Modules\Identity\Repositories;

use Zttp\Zttp as Http;
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

		self::revokeOtherAccessTokensFor($attribute['user_id'], $attribute['client_id']);

		$response = Http::asFormParams()
			->post(route('passport.token'), [
				'grant_type' => 'password',
				'client_id' => $attribute['client_id'],
				'client_secret' => $attribute['client_secret'],
				'username' => $attribute['email'],
				'password' => $attribute['password'],
				'scope' => '*',
			]);


		if (!$response->isOk()) {
			return unauthorized_request([
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
	public static function revokeOtherAccessTokensFor($userId, $clientId){
		$token = Passport::token();
		
		$token = $token->where('client_id', $clientId)->where('user_id', $userId)->where('revoked', false);

		$token->get()->map(function($token){
			(new RefreshTokenRepository)->revokeRefreshTokensByAccessTokenId($token->id);
		});

		$token->update(['revoked' => true]);
	}


	/**
	 * Revoke access all tokens for the specified user.
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function revokeAccessTokensFor($userId){
		$token = Passport::token();

		$token = $token->where('user_id', $userId)->where('revoked', false);

		$token->get()->map(function ($token) {
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
			->post(route('passport.token'), [
				'grant_type' => 'refresh_token',
				'client_id' => $attribute['client_id'],
				'client_secret' => $attribute['client_secret'],
				'refresh_token' => $attribute['refresh_token'],
				'scope' => '*',
			]);


		if (!$response->isOk()) {
			return unauthorized_request([
				'message' => 'Invalid Request.',
				"description" => $response->json(),
			]);
		}

		return $response->json();
	}

}