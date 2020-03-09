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

Route::post('login', 'AuthController@login')->name('login');
Route::post('refresh', 'AuthController@refresh')->name('refresh');


Route::middleware(['auth:api'])->group(function () {




	/**
	 * Logout authenticated user
	 * 
	 */
	Route::get('logout', 'AuthController@logout')->name('logout');


	/**
	 * Profile Route Resources
	 * 
	 */
	Route::get('profile', 'AccountsController@profile')->name('profile');
});
