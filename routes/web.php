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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/department/create',[
    'uses'=>'DepartmentController@create'
])->name('department.create');
Route::get('/department/edit/{id}',[
    'uses'=>'DepartmentController@edit'
])->name('department.edit');

Route::get('/department/delete/{id}',[
    'uses'=>'DepartmentController@destroy'
])->name('department.delete');

Route::get('/departments',[
    'uses'=>'DepartmentController@all'
])->name('departments');
Route::post('/Department/update/{id}',[
    'uses'=>'departmentController@update'
])->name('department.update');


Route::post('/Department/save',[
   'uses'=>'departmentController@save'
])->name('department.save');




Route::get('/workers',[
    'uses'=>'adminController@all'
])->name('workers');
Route::get('/worker/delete/{id}',[
    'uses'=>'adminController@delete'
])->name('worker.delete');
Route::get('/worker/accept/{id}',[
    'uses'=>'adminController@accept'
])->name('worker.accept');
Route::get('/worker/papers/{id}',[
    'uses'=>'adminController@paper'
])->name('show.papers');


Route::get('/evaluations',[
    'uses'=>'AdminController@evaluation'
])->name('evaluations');
Route::get('/user/show/{id}/{id2}',[
    'uses'=>'AdminController@showUser'
])->name('user.show');
Route::get('/worker/show/{id}',[
    'uses'=>'AdminController@showWorker'
])->name('worker.show');
Route::get('/worker/ban/{id}',[
    'uses'=>'AdminController@banWorker'
])->name('worker.ban');
Route::get('/worker/unban/{id}',[
    'uses'=>'AdminController@unbanWorker'
])->name('worker.unban');




Route::get('/userComplaints',[
    'uses'=>'AdminController@showUserComplaints'
])->name('user.complaints');
Route::get('/userComplaints/details/{id}','AdminController@showComplaintsDetails')->name('details');


