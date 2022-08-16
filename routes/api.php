<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\DisplayController;

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


// Authentication
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout']);

// Agents 
Route::get('/agents', [AgentsController::class, 'GetAgents']);

// Cases
Route::post('/addcase', [CasesController::class, 'AddCase']);
Route::post('/getcase', [CasesController::class, 'GetCase']);
Route::post('/updstatus', [CasesController::class, 'UpdateCaseStatus']);
Route::post('/updclosed', [CasesController::class, 'UpdateClosed']);
Route::middleware('auth:sanctum')->get('/closedcases', [CasesController::class, 'ClosedCases']);

// Dashboard & Case Management
Route::middleware('auth:sanctum')->get('/dashboard', [DisplayController::class, 'GetDashboard']);
Route::middleware('auth:sanctum')->get('/casemanagement', [DisplayController::class, 'GetCaseManagement']);
Route::get('/accounts', [DisplayController::class, 'GetAccounts']);
