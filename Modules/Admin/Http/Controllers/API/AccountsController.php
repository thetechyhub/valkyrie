<?php

namespace Modules\Admin\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Services\AccountServices;

class AccountsController extends Controller{

	/**
	 * Get User Account Details
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function profile(){
		return AccountServices::profile();
	}
}