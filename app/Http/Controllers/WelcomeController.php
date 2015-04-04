<?php namespace App\Http\Controllers;

use App\Page;
use App\Services\Markdowner;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
	// 	$this->middleware('guest');
	// }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index($slug = '')
	{
		if(!empty($slug))
		{
			$page = Page::where('slug', '=', $slug)->firstOrFail();
			$md = new Markdowner;
			$page->body = $md->toHTML($page->body);
			return view('index', compact('page'));
		}
		return view('welcome');
	}

}
