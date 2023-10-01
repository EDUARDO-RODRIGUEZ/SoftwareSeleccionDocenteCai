<?php
use App\Http\Controllers\RepEntrevistasRealizadasController;

Route::get('rep_entrevistas_realizadas', [RepEntrevistasRealizadasController::class,'index'])->name('rep_entrevistas_realizadas.index')->middleware('sesion.iniciada');
Route::post('rep_entrevistas_realizadas', [RepEntrevistasRealizadasController::class,'index'])->name('rep_entrevistas_realizadas.index')->middleware('sesion.iniciada');
