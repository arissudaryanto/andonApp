<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\HomeController@index'
  ]);

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LocalizationController@switchLang']);

Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('lockscreen', ['uses' => 'App\Http\Controllers\Auth\LoginController@lockscreen', 'as' => 'lockscreen']);
Route::post('unlock', ['uses' => 'App\Http\Controllers\Auth\LoginController@unlock', 'as' => 'lockscreen.store']);

Route::group(['middleware'=>['auth']], function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('maintenance', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@index', 'as' => 'maintenance.index'] );
    Route::get('maintenance_create/{id?}', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@create', 'as' => 'maintenance.add'] );
    Route::post('maintenance_store', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@store', 'as' => 'maintenance.store'] );
    Route::get('maintenance_datatables', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@datatables', 'as' => 'maintenance.datatables'] );
    Route::post('maintenance_status/{id?}', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@status', 'as' => 'maintenance.status'] );
    Route::get('maintenance_show/{id?}', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@show', 'as' => 'maintenance.show'] );
    Route::get('maintenance_export', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@export', 'as' => 'maintenance.export'] );
    Route::get('maintenance_recap', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@recap', 'as' => 'maintenance.recap'] );

    Route::get('maintenance_log/{id?}', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@log', 'as' => 'maintenance.log'] );
    Route::get('maintenance_log_datatables/{line?}', ['uses' => 'App\Http\Controllers\Module\MaintenanceController@log_datatables', 'as' => 'maintenance.log.datatables'] );

});

// SETTING
Route::group(['prefix' => 'setting', 'as' => 'setting'. '.', 'middleware'=>['auth']], function () {
   
    Route::resource('permissions', 'App\Http\Controllers\Setting\PermissionsController');
    Route::get('permission_datatables', ['uses' => 'App\Http\Controllers\Setting\PermissionsController@datatables', 'as' => 'permissions.datatables'] );
    Route::post('permission_delete', ['uses' => 'App\Http\Controllers\Setting\PermissionsController@delete', 'as' => 'permissions.delete']);
   
    Route::resource('roles', 'App\Http\Controllers\Setting\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'App\Http\Controllers\Setting\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    
    Route::resource('users', 'App\Http\Controllers\Setting\UsersController');
    Route::post('users_delete', ['uses' => 'App\Http\Controllers\Setting\UsersController@delete', 'as' => 'users.delete']);
    Route::get('users_datatables', ['uses' => 'App\Http\Controllers\Setting\UsersController@datatables', 'as' => 'users.datatables'] );
    Route::get('users_password/{id}', ['uses' => 'App\Http\Controllers\Setting\UsersController@password', 'as' => 'users.password'] );
    Route::post('users_password_store/{id}', ['uses' => 'App\Http\Controllers\Setting\UsersController@update_password', 'as' => 'users.password.store'] );
    Route::get('users_get', ['uses' => 'App\Http\Controllers\Setting\UsersController@get', 'as' => 'users.get'] );

    Route::get('profile', ['uses'  => 'App\Http\Controllers\Setting\ProfileController@index', 'as' => 'profile'] );
    Route::match(['get', 'post'], 'profile/change_profile', ['uses' => 'App\Http\Controllers\Setting\ProfileController@changeProfile', 'as' => 'profile.change_profile']);
    Route::match(['get', 'post'], 'profile/change_password', ['uses' => 'App\Http\Controllers\Setting\ProfileController@changePassword', 'as' => 'profile.change_password']);
});



Route::group(['prefix' => 'master', 'as' => 'master.', 'middleware'=>['auth']], function () {

    Route::resource('category', 'App\Http\Controllers\Master\CategoryController');
    Route::get('category_datatables', ['uses' => 'App\Http\Controllers\Master\CategoryController@datatables', 'as' => 'category.datatables'] );

    Route::resource('hardware', 'App\Http\Controllers\Master\HardwareController');
    Route::get('hardware_datatables', ['uses' => 'App\Http\Controllers\Master\HardwareController@datatables', 'as' => 'hardware.datatables'] );
    Route::get('hardware_export', ['uses' => 'App\Http\Controllers\Master\HardwareController@export', 'as' => 'hardware.export'] );
    Route::match(['get', 'post'], 'hardware_import', ['uses' => 'App\Http\Controllers\Master\HardwareController@import', 'as' => 'hardware.import'] );
    Route::match(['get', 'post'], 'hardware_setting/{id}', ['uses' => 'App\Http\Controllers\Master\HardwareController@setting', 'as' => 'hardware.setting'] );

});


