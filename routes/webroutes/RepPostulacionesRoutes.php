<?php
use App\Http\Controllers\RepPostulacionesController;

Route::get('rep_postulaciones', [RepPostulacionesController::class,'index'])->name('rep_postulaciones.index')->middleware('sesion.iniciada');
Route::post('rep_postulaciones', [RepPostulacionesController::class,'index'])->name('rep_postulaciones.index')->middleware('sesion.iniciada');
