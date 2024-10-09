<?php

use App\Http\Controllers\TeamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//team
Route::post('create-team', [TeamsController::class, 'createTeam']);
Route::get('read-teams', [TeamsController::class, 'readTeams']);
Route::get('read-team/{id}', [TeamsController::class, 'readTeamId']);
