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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::prefix('admin')->group(function () {

	Route::prefix('images')->group(function () {
		Route::prefix('trash')->group(function () {
			Route::get('/', 'ImageController@trash');
			Route::put('/{id}/restore', 'ImageController@restore');
			Route::delete('/{id}/vanish', 'ImageController@vanish');
		});
	});

	Route::prefix('attachments')->group(function () {
		Route::get('/', 'AttachmentController@index');
		Route::post('/', 'AttachmentController@store');
		Route::delete('/', 'AttachmentController@remove');
		Route::put('/{id}/attach', 'AttachmentController@attach');
	});

    Route::prefix('documents')->group(function () {
		Route::get('/', 'DocumentController@index');
        Route::get('/{user}', 'DocumentController@show');
        Route::post('/{user}', 'DocumentController@store');
        Route::put('/{user}/reject', 'DocumentController@reject');
        Route::put('/{user}/accept', 'DocumentController@accept');
        Route::put('/{user}/message', 'DocumentController@message');
        Route::put('/{user}/{document}', 'DocumentController@update');
        Route::delete('/{user}/{document}', 'DocumentController@destroy');
	});

	Route::delete('schedules', 'ScheduleController@multipledestroy');
	Route::delete('schedules/clean', 'ScheduleController@clean');

	Route::post('reports/upload', 'ReportController@upload')->name('upload');
	Route::delete('reports/attachment_delete/{reportAttachment}', 'ReportController@delete');
    Route::put('reports/{report}/attachment_add', 'ReportController@add');


	Route::get('/', 'HomeController@admin');
	Route::resource('cp', 'CpSectionController');
	Route::resource('schedules', 'ScheduleController');
	Route::resource('images', 'ImageController');
	Route::resource('infos', 'SiteInfoController');
	Route::resource('users', 'UserController');
	Route::resource('reports', 'ReportController');

    Route::prefix('user/{user}/')->group(function () {
    	Route::resource('contacts', 'ContactController');
    });

    Route::post('/cp/{cp}/up', 'CpSectionController@up');
    Route::post('/cp/{cp}/down', 'CpSectionController@down');
});

Route::post('/', 'HomeController@send');
Route::get('dokumen-pendukung', 'AttachmentController@home');
Route::get('kalender', 'ScheduleController@home');

Route::get('profil', 'UserController@profile');
Route::put('profil', 'UserController@homeUpdate');
Route::post('profil/doc', 'DocumentController@store');
Route::put('profil/doc/{document}', 'DocumentController@update');
Route::delete('profil/doc/{document}', 'DocumentController@destroy');
Route::post('profil/contact', 'ContactController@store');
Route::put('profil/contact/{contact}', 'ContactController@update');
Route::delete('profil/contact/{contact}', 'ContactController@destroy');


Route::get('forgot', 'Auth\ForgotPasswordController@index');
Route::post('forgot', 'Auth\ForgotPasswordController@sendEmail');
Route::put('forgot', 'Auth\ForgotPasswordController@resetPassword');

Route::resource('testimoni', 'TestimonialController');
