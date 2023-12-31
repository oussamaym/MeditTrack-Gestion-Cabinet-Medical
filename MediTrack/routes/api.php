<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->post('/ajouterDM', 'App\Http\Controllers\Admin\DossierMedicalCrudController@createdossier');
Route::post('/login', 'App\Http\Controllers\Admin\PatientCrudController@login');
Route::middleware('auth:sanctum')->get('/medecins', 'App\Http\Controllers\Admin\MedecinCrudController@getMedecins');
Route::middleware('auth:sanctum')->get('/dossier/{id}', 'App\Http\Controllers\Admin\DossierMedicalCrudController@getDossierMedicalByPatientId');
Route::post('/ajouterRDV', 'App\Http\Controllers\Admin\RendezVousCrudController@store');

//Route::get('/medecins', 'App\Http\Controllers\Admin\MedecinCrudController@getMedecins')->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
