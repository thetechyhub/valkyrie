<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller{

	/**
	 * Entry Point For The Admin Dashboard
	 * 
	 * @return \Illuminate\View\View
	 */
	public function index(){
		return view("admin::index");
	}
}
