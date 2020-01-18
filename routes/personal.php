<?php

Route::prefix('personal')->group(function () {
    Route::get('register', 'Personal\AuthController@register')->name("personal.register")->middleware('guest:personal');
    Route::post('register_proccess', 'Personal\AuthController@registerProcess')->name("personal.register.proccess");
    Route::get('confirm/{token}', 'Personal\AuthController@confirmEmail')->name("personal.register.confirm");
    Route::get('login', 'Personal\AuthController@login')->name("personal.login")->middleware('guest:personal');
    Route::post('login_proccess', 'Personal\AuthController@loginProcess')->name("personal.login.proccess");
    Route::get('logout', 'Personal\AuthController@logout')->name('personal.logout');
    Route::get("dashboard", "Personal\DashboardController@index")->name("personal.index");
    Route::get('edit', "Personal\DashboardController@edit")->name('personal.edit');
    Route::put('update', "Personal\DashboardController@update")->name('personal.update');

    Route::get('join', 'Personal\ClassController@join')->name('personal.join');
    Route::get('join/{type}/now/{busines_id}', 'Personal\ClassController@joinRegister')->name('personal.join.register');
    Route::post('join/now/', 'Personal\ClassController@joinProccess')->name('personal.join.proccess');
    Route::get('teacher/get_classes', 'Personal\TeacherController@getDataClas')->name('personal.teacher.get_data.class');
    Route::get('teacher/classes', 'Personal\TeacherController@showClass')->name('personal.teacher.class');
    Route::get('teacher/class/get_student/{id}', 'Personal\TeacherController@getDataStudent')->name('personal.teacher.get_data.student');
    Route::get('teacher/class/student/{id}', 'Personal\TeacherController@showStudent')->name('personal.teacher.student');
    Route::get('teacher/quiz/class/all', 'Personal\QuizController@quizClas');
    Route::get('teacher/quiz/class/create', 'Personal\QuizController@createQuizClas');
    Route::get('teacher/quiz/class/{businesId}', 'Personal\QuizController@showClasLesson');
    Route::post('teacher/quiz/class/store', 'Personal\QuizController@storeQuizClas');
    Route::get('teacher/quiz/class/edit/{id}', 'Personal\QuizController@editQuizClas');
    Route::patch('teacher/quiz/class/update/{id}', 'Personal\QuizController@UpdateQuiz');
    Route::post('teacher/quiz/class/edit/question/{id}', 'Personal\QuizController@saveQuestionAnswer');
    Route::get('teacher/quiz/class/delete/question/{id}', 'Personal\QuizController@deleteQuestionAnswer');

    Route::get('teacher/quiz/{quiz_id}/question/edit/{question_id}', 'Personal\QuizController@editQuestionsClas')->name('personal.teacher.clas.question.edit');
    Route::put('teacher/quiz/{quiz_id}/question/update/{question_id}', 'Personal\QuizController@updateQuestionsClas')->name('personal.teacher.clas.question.update');

    Route::get('teacher/quiz/class/', 'Personal\QuizController@QuizClas');
    Route::get('student/quiz/class/all', 'Personal\StudentController@quizClas')->name('personal.student.class');
    Route::get('student/quiz/class/answer/{id}', 'Personal\QuizController@playQuizbyClass');
    Route::get('student/quiz/class/answer/get_data_play/{id}', 'Personal\QuizController@getDataPlayQuiz');
    Route::post('student/quiz/class/answer/get_data_play/', 'Personal\QuizController@saveQuizbyClass');
    Route::get('student/quiz/class/answer/previewscore/{pid}', 'Personal\QuizController@PreviewScore');
    Route::get('student/quiz/class/activity_score', 'Personal\QuizController@activityScorebyClas')->name('student.clas.score');

    Route::get('my_quiz/general/create', 'Personal\QuizController@createQuizGeneral')->name('personal.my_quiz.general.create');
    Route::post('my_quiz/general/store', 'Personal\QuizController@storeQuizGeneral')->name('personal.my_quiz.general.store');
    Route::get('my_quiz/edit/{id}', 'Personal\QuizController@editQuizGeneral')->name('personal.my_quiz.general.edit');
    Route::get('my_quiz/pub/{id}/{status}', 'Personal\QuizController@publishQuiz');
    Route::patch('my_quiz/general/question/create/{id}', 'Personal\QuizController@saveQuestionAnswerGeneral')->name('personal.my_quiz.general.question.create');
    Route::get('my_quiz/genetal/question/delete/{id}', 'Personal\QuizController@deleteQuestionAnswerGeneral');
    Route::get('my_quiz/general/{quiz_id}/question/edit/{question_id}', 'Personal\QuizController@editQuestions')->name('personal.my_quiz.general.question.edit');
    Route::put('my_quiz/general/{quiz_id}/question/update/{question_id}', 'Personal\QuizController@updateQuestions')->name('personal.my_quiz.general.question.update');
    Route::patch('my_quiz/general/update/{id}', 'Personal\QuizController@UpdateQuizGeneral');
    Route::patch('my_quiz/clas/update/{id}', 'Personal\QuizController@UpdateQuiz');
    Route::get('my_quiz/general/all', 'Personal\QuizController@quizClasGeneral');
    Route::get('quiz/general/clas/report/', 'Personal\QuizController@quizByclas')->name('personal.quiz.clas.report');
    Route::get('busines/detail/{id}/{clas_id?}', 'Personal\DashboardController@detailBusines')->name('busines.detail');
    Route::get('busines/personal/{busines_id}', 'Personal\DashboardController@getPersonalByBusines');
    Route::get('busines/quiz/{busines_id}', 'Personal\DashboardController@getQuizByBusines');
    Route::get('busines/quiz/student/{busines_id}/{clas_id}', 'Personal\DashboardController@quizStudent');
    Route::get('busines/quiz/student/clas/all/{busines_id}', 'Personal\DashboardController@ClasBusines');
    Route::get('curriculum', 'Personal\CurriculumController@index')->name('personal.curriculum.index');
    Route::get('curriculum/data', 'Personal\CurriculumController@getCurriculum')->name('personal.curriculum.data');
    Route::get('curriculum/create', 'Personal\CurriculumController@create')->name('personal.curriculum.create');
    Route::post('curriculum/store', 'Personal\CurriculumController@store')->name('personal.curriculum.store');
    Route::get('curriculum/edit/{id}', 'Personal\CurriculumController@edit')->name('personal.curriculum.edit');
    Route::get('curriculum/delete/{id}', 'Personal\CurriculumController@delete')->name('personal.curriculum.delete');
    Route::put('curriculum/update/{id}', 'Personal\CurriculumController@update')->name('personal.curriculum.update');
    Route::get('dashboard/curriculum/{busines_id}', 'Personal\DashboardController@getCurriculum')->name('personal.dashboard.student.curriculum');
});
