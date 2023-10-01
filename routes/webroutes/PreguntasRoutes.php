<?php
use App\Http\Controllers\PreguntaController;

Route::get('preguntas', [PreguntaController::class,'index'])->name('preguntas.index')->middleware('sesion.iniciada');
Route::get('preguntas/agregar', [PreguntaController::class,'agregar'])->name('preguntas.agregar')->middleware('sesion.iniciada');
Route::get('preguntas/{id}', [PreguntaController::class,'mostrar'])->name('preguntas.mostrar')->middleware('sesion.iniciada');
Route::post('preguntas', [PreguntaController::class,'insertar'])->name('preguntas.insertar')->middleware('sesion.iniciada');
Route::get('preguntas/{id}/modificar', [PreguntaController::class,'modificar'])->name('preguntas.modificar')->middleware('sesion.iniciada');
Route::put('preguntas/{pregunta}', [PreguntaController::class,'actualizar'])->name('preguntas.actualizar')->middleware('sesion.iniciada');
Route::delete('preguntas/{pregunta}', [PreguntaController::class,'eliminar'])->name('preguntas.eliminar')->middleware('sesion.iniciada');
