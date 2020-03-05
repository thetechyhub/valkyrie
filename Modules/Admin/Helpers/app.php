<?php

use Illuminate\Support\Facades\Auth;

/**
 * Return current authenticated admin
 *
 * @return Admin
 */
function user(){
	return Auth::user();
}
