<?php

use App\Events\PostCreated;
use App\Events\StatusChanged;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*class Post{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}*/

Route::get('/', function () {
     /*PostCreated::dispatch(new Post(2));*/
    return view('welcome');
});
Route::get('/about-us',function(){
    return view('about');
});
Route::get('/services',function(){
    return view ('services');
});
Route::get('/contacts',function(){
    return view('contact');
});
Route::get('/demo',function(){
    PostCreated::dispatch();
});
Route::get('/fire',function(){
    event (new StatusChanged);
});
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/private', 'HomeController@private')->name('private')->middleware('verified');;
Route::get('/users', 'HomeController@users')->name('users');
Route::get('/shop','HomeController@shop')->name('shop');
Route::get('messages', 'MessageController@fetchMessages');
Route::post('messages', 'MessageController@sendMessage');
Route::get('/private-messages/{user}', 'MessageController@privateMessages')->name('privateMessages');
Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage')->name('privateMessages.store');
Route::get('/googlemap',function(){
    return view('map');
});
Route::get('/{path}',"HomeController@index")->where( 'path', '.*' );

