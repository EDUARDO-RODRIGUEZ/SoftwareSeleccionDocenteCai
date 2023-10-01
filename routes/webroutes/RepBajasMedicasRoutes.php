<?php
use App\Http\Controllers\RepBajasMedicasController;

Route::get('rep_bajas_medicas', [RepBajasMedicasController::class,'index'])->name('rep_bajas_medicas.index')->middleware('sesion.iniciada');
Route::post('rep_bajas_medicas', [RepBajasMedicasController::class,'index'])->name('rep_bajas_medicas.index')->middleware('sesion.iniciada');
