<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('test', function()
{
	$pages = App\Page::all()->toArray();
	echo build_page_list(get_pages_array($pages));
});

function get_pages_array($arr, $parent = 0)
{
    $pages = Array();
    foreach($arr as $page)
    {
        if($page['parent_id'] == $parent)
        {
            $page['sub'] = isset($page['sub']) ? $page['sub'] : get_pages_array($arr, $page['id']);
            $pages[] = $page;
        }
    }
    return $pages;
}

function build_page_list($pages, $out = '')
{
	$out .= '<ul>';
	foreach($pages as $page)
	{
		$out .= '<li>';
		$out .= '<a href="/' . $page['slug'] . '">' . $page['title'] . ' (' . $page['id'] . ')</a>';
		$out .= build_page_list($page['sub']);
		$out .= '</li>';
	}
	$out .= '</ul>';
	return $out;
}

Route::get('home', 'HomeController@index');

Route::get('admin', 'AdminController@index');

Route::resource('pages', 'PagesController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);

Route::get('{slug?}', 'WelcomeController@index')->where('slug', '.+');