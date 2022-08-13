<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/yo', function (Request $request) {
    return response('Hello');
});

// Get cases
Route::post('/getcase', [TestController::class, 'GetCase']);

// Mutate Cases
Route::post('/addcase', [TestController::class, 'AddCase']);
Route::post('/updstatus', [TestController::class, 'UpdateCaseStatus']);
Route::post('/updclosed', [TestController::class, 'UpdateClosed']);

// Authentication
Route::post('/register', [TestController::class, 'Register']);
Route::post('/login', [TestController::class, 'Login']);
Route::post('/logout', [TestController::class, 'Logout']);

// Dashboard // Case Management // Closed Cases
Route::middleware('auth:sanctum')->get('/dashboard', [TestController::class, 'GetDashboard']);
Route::middleware('auth:sanctum')->get('/casemanagement', [TestController::class, 'GetCaseManagement']);
Route::middleware('auth:sanctum')->get('/closedcases', [TestController::class, 'ClosedCases']);

Route::get('/agents', [TestController::class, 'GetAgents']);
