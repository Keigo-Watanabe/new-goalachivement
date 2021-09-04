<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleCategoryController;

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
    return Inertia::render('Top', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('contact', function() {
  return Inertia::render('ContactForm');
});

Route::get('thanks', function() {
  return Inertia::render('Thanks');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('home', GoalController::class)->middleware('auth');

Route::get('home/{id}/chart', [GoalController::class, 'chart'])->middleware('auth');

Route::resource('task', TaskController::class)->middleware('auth');

Route::get('matrix', [TaskController::class, 'matrix'])->middleware('auth');

Route::put('complete/{id}', [TaskController::class, 'complete'])->middleware('auth');

Route::resource('category', CategoryController::class)->middleware('auth');

Route::resource('calendar', ScheduleController::class)->middleware('auth');

Route::resource('schedule_category', ScheduleCategoryController::class)->middleware('auth');

Route::group(['prefix' => 'use'], function () {
  Route::get('1', function () { return Inertia::render('Use/UseHome/GoalAdd'); });
  Route::get('2', function () { return Inertia::render('Use/UseHome/GoalTaskAdd'); });
  Route::get('3', function () { return Inertia::render('Use/UseHome/GoalDetailLook'); });
  Route::get('4', function () { return Inertia::render('Use/UseHome/GoalEdit'); });
  Route::get('5', function () { return Inertia::render('Use/UseHome/GoalDelete'); });
  Route::get('6', function () { return Inertia::render('Use/UseHome/GoalTaskSort'); });
  Route::get('7', function () { return Inertia::render('Use/UseHome/GoalGantchart'); });
  Route::get('8', function () { return Inertia::render('Use/UseHome/GoalSort'); });
  Route::get('9', function () { return Inertia::render('Use/UseHome/TaskNarrow'); });
  Route::get('10', function () { return Inertia::render('Use/UseHome/TaskSort'); });
  Route::get('11', function () { return Inertia::render('Use/UseHome/TaskEdit'); });
  Route::get('12', function () { return Inertia::render('Use/UseHome/TaskDelete'); });
  Route::get('13', function () { return Inertia::render('Use/UseHome/Matrix'); });
  Route::get('14', function () { return Inertia::render('Use/UseHome/ScheduleAdd'); });
  Route::get('15', function () { return Inertia::render('Use/UseHome/ScheduleEdit'); });
  Route::get('16', function () { return Inertia::render('Use/UseHome/ScheduleDelete'); });
});
