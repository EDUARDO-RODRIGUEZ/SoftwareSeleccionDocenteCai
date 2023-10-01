<?php
use App\Http\Controllers\RepPlanillasController;

Route::get('rep_planillas', [RepPlanillasController::class,'index'])->name('rep_planillas.index')->middleware('sesion.iniciada');
Route::post('rep_planillas', [RepPlanillasController::class,'index'])->name('rep_planillas.index')->middleware('sesion.iniciada');
