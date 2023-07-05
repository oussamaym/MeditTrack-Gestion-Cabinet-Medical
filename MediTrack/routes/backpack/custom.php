<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('medecin', 'MedecinCrudController');
    Route::crud('patient', 'PatientCrudController');
    Route::crud('secretaire', 'SecretaireCrudController');
    Route::crud('traitement', 'TraitementCrudController');
    Route::crud('planning', 'PlanningCrudController');
    Route::crud('rendez-vous', 'RendezVousCrudController');
    Route::crud('consultation', 'ConsultationCrudController');
    Route::crud('dossier-medical', 'DossierMedicalCrudController');
    Route::get('patient/{id}/dossier', 'PatientCrudController@dossier');
}); // this should be the absolute last line of this fil