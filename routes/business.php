<?php

Route::prefix('business')->group(function () {
    Route::get('register', 'Business\AuthController@register')->name("business.register")->middleware('guest:busines');
    Route::post('register_proccess', 'Business\AuthController@registerProcess')->name("bussines.register.proccess");
    Route::get('confirm/{token}', 'Business\AuthController@confirmEmail')->name("business.register.confirm");
    Route::get('login', 'Business\AuthController@login')->name("business.login")->middleware('guest:busines');
    Route::post('login_proccess', 'Business\AuthController@loginProcess')->name("business.login.proccess");
    Route::get('logout', 'Business\AuthController@logout')->name('business.logout');
    Route::get("dashboard", "Business\DashboardController@index")->name("business.index");
    Route::get('edit', "Business\DashboardController@edit")->name('business.edit');
    Route::put('update', "Business\DashboardController@update")->name('business.update');
    Route::get("clas/get_data", "Business\ClassController@getData")->name('business.clas.get_data');
    Route::get("lesson_business/get_data", "Business\LessonBusinessController@getData")->name('business.lesson_business.get_data');
    Route::get('invite', 'Business\ClassController@invite')->name('busines.invite');
    Route::post('invite_proccess', 'Business\ClassController@inviteProccess')->name('busines.invite.proccess');
    Route::get('get_personal', 'Business\ClassController@getPersonal')->name('busines.personal');
    Route::get('clas/student/{clasID}', 'Business\ClassController@showPersonal')->name('busines.personala.all');
    Route::get('clas/lesson/{lessonID}', 'Business\LessonBusinessController@showLesson')->name('busines.lesson.all');
    Route::get("clas_personal/index/{type}", "Business\ClassPersonalController@index")->name('business.clas_personal.index');
    Route::get("clas_personal/get_data/{type}", "Business\ClassPersonalController@getData")->name('business.clas_personal.get_data');
    Route::get("clas_personal/is_aprroved/{id}", "Business\ClassPersonalController@is_approved");
    Route::post("clas_personal/is_aprroved/{id}", "Business\ClassPersonalController@proccessAprpove");
    Route::get("clas_personal/is_delete/{id}", "Business\ClassPersonalController@isDelete");
    Route::resource('clas', 'Business\ClassController', ['as' => 'business']);
    Route::resource('lesson_business', 'Business\LessonBusinessController', ['as' => 'business']);
});
