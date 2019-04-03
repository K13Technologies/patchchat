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

Route::get('/', ['as' => 'home', 'uses'=>'IndexController@welcome']);

Route::get('/home', ['as' => 'user.home', 'uses'=>'IndexController@home']);

Route::get('/about', ['as' => 'about', 'uses'=>function() {
    return view('about');
}]);
Route::get('/press', ['as' => 'press', 'uses'=>function() {
    return view('press');
}]);
Route::get('/contact', ['as' => 'contact', 'uses'=>'ContactController@contact']);
Route::post('/contact', ['as' => 'send', 'uses'=>'ContactController@send']);

Route::get('/terms', ['as' => 'terms', 'uses'=>function() {
    return view('terms');
}]);
Route::get('/privacy', ['as' => 'privacy', 'uses'=>function() {
    return view('privacy');
}]);
Route::get('/law-enforcement', ['as' => 'law-enforcement', 'uses'=>function() {
    return view('law-enforcement');
}]);

/* 
ADS 
*/
Route::get('/advertising', ['as' => 'advertising',  'uses'=>'ContactController@advertising']);
Route::post('/advertising', ['as' => 'send', 'uses'=>'ContactController@advertisingSend']);

Route::get('/advertising/guidelines', ['as' => 'advertising.guidelines', 'uses'=>function() {
    return view('advertising/guidelines');
}]);
Route::get('/advertising/political', ['as' => 'advertising.political', 'uses'=>function() {
    return view('advertising/political');
}]);


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@mypostLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/search', ['as' => 'search', 'uses'=>'SearchController@search']);

/*
* WIKI
*/
Route::get('/wiki', ['as' => 'wiki', 'uses'=>function() {
    return view('wiki/index');
}]);
Route::get('/wiki/guidelines', ['as' => 'wiki.guidelines', 'uses'=>function() {
    return view('wiki/guidelines');
}]);
Route::get('/wiki/add', ['as' => 'wiki.add', 'middleware' => 'auth', 'uses'=>function () {
    return view('wiki/add');
}]);

/*
* Community 
*/
Route::get('/community', ['as' => 'community', 'middleware' => 'auth', 'uses'=>function () {
    return view('community/index');
}]);
Route::get('/community/industries', ['as' => 'community.industries', 'middleware' => 'auth', 'uses'=>'IndexController@industryCommunities']);
Route::get('/community/camps', ['as' => 'community.camp', 'middleware' => 'auth', 'uses'=>function () {
    return view('community/camps');
}]);
Route::get('/map/community', ['as' => 'community.map', 'middleware' => 'auth', 'uses'=>function () {
    return view('/map/community');
}]);
Route::get('/wiki/community', ['as' => 'community.wiki', 'middleware' => 'auth', 'uses'=>function () {
    return view('wiki/community');
}]);
Route::get('/community/guidelines', ['as' => 'community.guidelines', 'uses'=>function () {
    return view('community/guidelines');
}]);

/*
*  MAP
*/
Route::post('map/search', 'MapController@search');
Route::get('map/search', 'MapController@search');
Route::get('map', ['as' => 'map', 'uses'=>'MapController@index']);

Route::get('review/{facility_id}/create/{rating}', ['as' => 'facility.review.create', 'uses'=>'ReviewController@create']);
Route::post('review/{facility_id}/create', ['as' => 'facility.review', 'uses'=>'ReviewController@store']);
   
/*
Industry landing pages
*/
Route::bind('industry', function($value, $route) {
	return App\Models\Industry::whereSlug($value)->first();
});
Route::get('/{industry}', ['as' => 'industry', 'uses'=>'IndexController@industry'])
    ->where('mining', 'energy', 'solar', 'hydro', 'wind', 'forestry');

Route::get('/{industry}/facilities', ['as' => 'industry.search', 'uses'=>'SearchController@search']);

Route::get('{industry}/wiki', ['as' => 'wiki.industry', 'middleware' => 'auth', 'uses'=>function () {
    return view('wiki/industry');
}]);


Route::get('{industry}/community', ['as' => 'community.industry', 'middleware' => 'auth', 'uses'=>'IndexController@community']);

Route::get('/{industry}/search', ['as' => 'search.industry', 'uses'=>'SearchController@search']);

Route::get('/{industry}/register', ['as' => 'industry.register', 'uses'=>'Auth\AuthController@getRegister']);
Route::post('/{industry}/register', 'Auth\AuthController@postRegister');

Route::get('/{industry}/camp/add', ['as' => 'camp.add', 'middleware' => 'auth',  'uses'=>function () {
    return view('camp/add');
}]);
Route::get('/facility/add', ['as' => 'facility.add', 'middleware' => 'auth',  'uses'=>function () {
    return view('facility/add');
}]);
Route::get('/{industry}/facility/add', ['as' => 'industry.facility.add', 'middleware' => 'auth',  'uses'=>function () {
    return view('facility/add');
}]);


Route::get('{country}/{state}/{facility}', ['as' => 'facility.show', 'uses'=>'FacilityController@show']);


