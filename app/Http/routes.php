<?php

//Frond end route
Route::get('/', array('as' => 'Home', 'uses' => '\App\Http\Controllers\FrontendController@index'));
Route::get('/tro-giup', array('as' => 'Trợ giúp', 'uses' => '\App\Http\Controllers\FrontendController@trogiup'));
Route::get('/dang-ky-di-lam', array('as' => 'Đăng ký đi làm', 'uses' => '\App\Http\Controllers\FrontendController@dangkydilam'));
Route::get('/confirmemail/{token}', array('as' => 'Xác thực tài khoản', 'uses' => '\App\Http\Controllers\FrontendController@confirmemail'));











Route::get('auth/login', array('as' => 'Login', 'uses' => '\App\Http\Controllers\AuthController@login'));
Route::get('auth/logout', array('as' => 'Login', 'uses' => '\App\Http\Controllers\AuthController@logout'));
Route::post('auth/postLogin', array('as' => 'Login', 'uses' => '\App\Http\Controllers\AuthController@postLogin'));
//Webservice route
Route::any('service/{page?}/{action?}', array('as' => 'WebService', 'uses' => '\App\Controllers\WebServiceController@getAction'))
        ->where(array('page' => '[a-zA-Z0-9-_]+', 'action' => '[a-zA-Z0-9-_]+'));

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'secret', 'middleware' => 'auth'], function()
{
    Route::get('/', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\DashBoardController@index'));
    Route::get('bookings/motlan', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\BookingsController@giupviecmotlan'));
    Route::get('bookings/thuongxuyen', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\BookingsController@giupviecthuongxuyen'));
    Route::get('customers', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\CustomersController@customers'));
    Route::any('laborers/{id?}', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\CustomersController@laborers'));
    Route::get('usersblocked', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\CustomersController@usersblocked'));
    Route::post('active', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\CustomersController@activeUser'));
    Route::post('onoffgvthuongxuyen', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\CustomersController@onOffGvThuongxuyen'));
    Route::post('updateluonggv1lan', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\SystemController@updateLuonggv1lan'));
    Route::post('updateluonggvthuongxuyen', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\SystemController@updateluonggvthuongxuyen'));
    Route::post('updatethongtinchuyenkhoan', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\SystemController@updatethongtinchuyenkhoan'));
    Route::get('configs', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\DashBoardController@systemConfig'));
    Route::get('cashoutrequest', array('as' => 'Administrator', 'uses' => '\App\Http\Controllers\DashBoardController@index'));
});





