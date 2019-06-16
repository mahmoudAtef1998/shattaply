<?php

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

Route::get('/login', function () {
    $client = new Client(); //GuzzleHttp\Client

    $result = $client->post('http://127.0.0.1:9999/api/signIn', [
        'form_params' => [
            'email' => 'sfas@saafa',
            'password'=> 'sfsfas'
        ]
    ]);
    $name = "atef";
    echo $result->getBody();
});
//Admin routes
Route::post('/storeAdmin',"AdminController@store");
Route::get('/showAdmins',"AdminController@index");
Route::get('/showAdminData',"AdminController@showAdminData");
Route::get('/showAdminPhoto',"AdminController@showAdminPhoto");
Route::put('/updateAdmin/{id}',"AdminController@update");
Route::delete('/deleteAdmin/{id}',"AdminController @destroy");
Route::post('/storeCity',"AdminController@storeCity");
Route::post('/storeRegion',"AdminController@storeRegion");


Route::post('/storeUserComplain',"ComplainController@storeUserComplain")->middleware('CheckBlockUser');
Route::post('/storeWorkerComplain',"ComplainController@storeWorkerComplain")->middleware('CheckBlockWorker');
Route::post('/storeAdminComplain',"ComplainController@store");

Route::get('/showComplain',"ComplainController@index");
Route::get('/showComplain',"ComplainController@show");
Route::put('/updateComplain/{id}',"ComplainController@update");
Route::delete('/deleteComplain/{id}',"ComplainController@destroy");


Route::post('/storeDepartment',"DepartmentController@store");
Route::get('/showDepartments',"DepartmentController@index");
Route::get('/showDepartment',"DepartmentController@show")->middleware('CheckBlockUser');
Route::put('/updateDepartment/{id}',"DepartmentController@update");
Route::delete('/deleteDepartment/{id}',"DepartmentController@destroy");


//Evaluation routes
Route::post('/storeEvaluation',"EvaluationController@store");
Route::get('/showEvaluations',"EvaluationController@index");
Route::get('/showEvaluation',"EvaluationController@show");
Route::put('/updateEvaluation/{id}',"EvaluationController@update");
Route::delete('/deleteEvaluation/{id}',"EvaluationController@destroy");


//Route::post('/storeJob',"JobController@store")->middleware('CheckBlockUser');
//Route::get('/showJob',"JobController@index");
//Route::get('/showJob',"JobController@show");
//Route::put('/updateJob/{id}',"JobController@update");
//Route::delete('/deleteJob/{id}',"JobController@destroy");



Route::post('/storePreviousWork',"PreviousWorkController@store")->middleware('CheckBlockWorker');
//Route::get('/showPreviousWork',"PreviousWorkController@index")->middleware('CheckBlockWorker');
Route::get('/showPreviousWork',"PreviousWorkController@show")->middleware('CheckBlockWorker');
Route::put('/updatePreviousWork/{id}',"PreviousWorkController@update");
Route::delete('/deletePreviousWork/{id}',"PreviousWorkController@destroy");


Route::post('/storeRequest',"JopRequestController@store")->middleware('CheckBlockUser');
Route::get('/showRequests',"JopRequestController@index");
Route::get('/showRequest',"JopRequestController@show");
Route::post('/showWorkerRequests',"JopRequestController@showWorkerRequests");
Route::post('/showUserRequests',"JopRequestController@showUserRequests");



Route::put('/acceptRequest/{id}',"JopRequestController@update");
Route::get('/WorkerdeleteRequest/{id1}/{id2}',"JopRequestController@workerdestroy");
Route::get('/WorkerdAcceptRequest/{id1}/{id2}',"JopRequestController@workerAccept");

Route::get('/UserdeleteRequest/{id1}/{id2}',"JopRequestController@userdestroy");



Route::post('/storeUser',"UserController@store");
Route::get('/showUsers',"UserController@index");
Route::post('/loginUsers',"UserController@loginUsers");

Route::get('/showUserPhoto',"UserController@showUserPhoto")->middleware('CheckBlockUser');
Route::get('/showUserData',"UserController@showUserData")->middleware('CheckBlockUser');
Route::post('/updateUser',"UserController@update");
//Route::put('/updateUserPhoto/{id}',"UserController@update");

Route::delete('/deleteUser/{id}',"UserController@destroy");
Route::get('/search','UserController@search');


Route::post('/loginWorkers',"WorkerController@loginWorkers");
Route::post('/storeWorker',"WorkerController@store");
Route::post('/specifyStatus',"WorkerController@specifyStatus")->middleware('CheckBlockWorker');
Route::get('/showWorkers',"WorkerController@index")->middleware('CheckBlockUser');
Route::get('/showSpecificWorkers',"WorkerController@showSpecificWorkers")->middleware('CheckBlockUser');
Route::get('/showWorkerData',"WorkerController@showWokerData")->middleware('CheckBlockUser');
Route::get('/showWorkerPhoto',"WorkerController@showWokerPhoto");

Route::put('/updateWorker/{id}',"WorkerController@update");
Route::delete('/deleteWorker/{id}',"WorkerController@destroy");


Route::post('/storePreviousWork',"PreviousWorkController@store")->middleware('CheckBlockWorker');
Route::get('/showPreviousWorkers',"PreviousWorkController@show");


Route::get('/getCities','CitiesController@getCities');



Route::post('/storeBase69',"WorkerController@storeBase69");

