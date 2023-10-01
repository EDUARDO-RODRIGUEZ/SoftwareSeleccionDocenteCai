<?php
use App\Http\Controllers\PostulacionController;

Route::get('postulaciones', [PostulacionController::class,'index'])->name('postulaciones.index')->middleware('sesion.iniciada');
Route::get('postulaciones/agregar', [PostulacionController::class,'agregar'])->name('postulaciones.agregar')->middleware('sesion.iniciada');
Route::post('postulaciones', [PostulacionController::class,'insertar'])->name('postulaciones.insertar')->middleware('sesion.iniciada');
Route::delete('postulaciones/{postulacion}', [PostulacionController::class,'eliminar'])->name('postulaciones.eliminar')->middleware('sesion.iniciada');


Route::get('postulaciones/procesar', [PostulacionController::class,'procesar'])->name('postulaciones.procesar')->middleware('sesion.iniciada');
Route::post('postulaciones/guardar-entrevistas', [PostulacionController::class,'guardarEntrevistas'])->name('postulaciones.guardarEntrevistas')->middleware('sesion.iniciada');