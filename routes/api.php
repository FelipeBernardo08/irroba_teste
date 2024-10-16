<?php

use App\Http\Controllers\ChampionController;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\SubscribeChampionshipController;
use App\Http\Controllers\TeamsController;
use App\Models\Teams;
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
Route::post('create-teams', [TeamsController::class, 'createTeams']);
Route::get('read-teams', [TeamsController::class, 'readTeams']);
Route::get('read-team/{id}', [TeamsController::class, 'readTeamId']);

//championship
Route::post('create-championship', [ChampionshipController::class, 'createChampionship']);
Route::get('read-championships', [ChampionshipController::class, 'readChampionships']);
Route::get('read-championship/{id}', [ChampionshipController::class, 'readChampionshipId']);

//subscribeChampionship
Route::post('create-subscribe-championship', [SubscribeChampionshipController::class, 'createSubscribe']);

//initializeChampionship
Route::get('initialize-championship/{id}', [ChampionshipController::class, 'initializeChampionship']);
