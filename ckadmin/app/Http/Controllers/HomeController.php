<?php

namespace App\Http\Controllers;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$menu = ['dashboard'];
		return view('dashboard', compact('menu'));
	}

	// should be deleted after development
	public function pages($name = 'ui-elements_panels') {
		return view('pages.' . $name);
	}
}
