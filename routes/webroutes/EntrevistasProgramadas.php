<?php
use App\Http\Controllers\EntrevistaProgramadaController;

Route::get('entrevistas_programadas', [EntrevistaProgramadaController::class,'index'])->name('entrevistas_programadas.index')->middleware('sesion.iniciada');
Route::get('entrevistas_programadas/agregar', [EntrevistaProgramadaController::class,'agregar'])->name('entrevistas_programadas.agregar')->middleware('sesion.iniciada');
Route::post('entrevistas_programadas', [EntrevistaProgramadaController::class,'insertar'])->name('entrevistas_programadas.insertar')->middleware('sesion.iniciada');
Route::get('entrevistas_programadas/{id}/modificar', [EntrevistaProgramadaController::class,'modificar'])->name('entrevistas_programadas.modificar')->middleware('sesion.iniciada');
Route::put('entrevistas_programadas/{entrevista_programada}', [EntrevistaProgramadaController::class,'actualizar'])->name('entrevistas_programadas.actualizar')->middleware('sesion.iniciada');
Route::delete('entrevistas_programadas/{entrevista_programada}', [EntrevistaProgramadaController::class,'eliminar'])->name('entrevistas_programadas.eliminar')->middleware('sesion.iniciada');

Route::get('entrevistas_programadas/{id}/entrevistar', [EntrevistaProgramadaController::class,'entrevista'])->name('entrevistas_programadas.entrevista')->middleware('sesion.iniciada');
Route::post('entrevistas_programadas/guardar-entrevista', [EntrevistaProgramadaController::class,'guardarEntrevistaRealizada'])->name('entrevistas_programadas.guardarEntrevistaRealizada')->middleware('sesion.iniciada');

Route::get('entrevistas_programadas/procesar', [EntrevistaProgramadaController::class,'procesar'])->name('entrevistas_programadas.procesar')->middleware('sesion.iniciada');
