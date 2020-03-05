<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');


Route::middleware(['auth:api'])->group(function () {




	/**
	 * Logout authenticated user
	 * 
	 */
	Route::get('logout', 'AuthController@logout');


	/**
	 * Profile Route Resources
	 * 
	 */
	Route::get('profile', 'AccountsController@profile');
});
