<?php
use App\Http\Controllers\RepVacacionesController;

Route::get('rep_vacaciones', [RepVacacionesController::class,'index'])->name('rep_vacaciones.index')->middleware('sesion.iniciada');
Route::post('rep_vacaciones', [RepVacacionesController::class,'index'])->name('rep_vacaciones.index')->middleware('sesion.iniciada');
