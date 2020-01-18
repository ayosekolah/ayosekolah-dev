<?php

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

// use App\ClasPersonal;

// Route::get('/', function () {
//     $q = ClasPersonal::with(['teacher', 'student'])->where('clas_id', 1)->get();

//     return $q;
// });

Route::get('/', 'HomeController@index');
Route::get('/it', 'HomeController@indexbyJoin');
Route::get('/detail_quiz/{id}', 'HomeController@detailQuiz');
Route::get('/detail/lesson/{id}', 'HomeController@detailLesson')->name('lesson.detail');
Route::get('/play_quiz/{id}', 'HomeController@playQuizGeneral');
Route::post('quiz/general/questionanswer/save/', 'HomeController@savequizClasGeneral');
Route::get('quiz/general/questionanswer/previewscore/{id}', 'HomeController@PreviewScoreGeneral');
Route::get('quiz/general/report/', 'QuizController@indexQuiz');
Route::get('quiz/general/report/{id}', 'QuizController@report');
Route::get('quiz/general/report_data/{id}', 'QuizController@reportData');

include "business.php";
include "personal.php";
