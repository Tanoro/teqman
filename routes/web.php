<?php

use Illuminate\Support\Facades\Route;

# App controllers
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Activity;
use App\Http\Controllers\Projects;
use App\Http\Controllers\Jobs;
use App\Http\Controllers\Billing;
use App\Http\Controllers\Customers;
use App\Http\Controllers\Users;

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

/*
Route::get('/', function () {
    return view('index');
});
*/
Route::get('/', [IndexController::class, 'index']);
Route::get('/activity', [Activity::class, 'view']);
Route::get('/billing', [Billing::class, 'index']);

# Ajax requests
Route::get('ajax-request', [AjaxController::class, 'notfound']);
Route::post('/ajax/test', [AjaxController::class, 'test']);

# Projects views
Route::get('/projects', [Projects::class, 'list']);
Route::get('/projects/view/{id}', [Projects::class, 'view']);

# Jobs views
Route::get('/jobs', [Jobs::class, 'list']);
Route::get('/jobs/add', [Jobs::class, 'add']);
Route::get('/jobs/view/{id}', [Jobs::class, 'view']);

# Customers
Route::get('/customers', [Customers::class, 'view']);
Route::view('/customers/add', 'addcustomer');

# Users
Route::get('/users', [Users::class, 'view']);

# Testing
Route::view('/react', 'react');
