<?php
use App\Http\Controllers\PostulanteController;

Route::get('postulantes', [PostulanteController::class,'index'])->name('postulantes.index')->middleware('sesion.iniciada');
Route::get('postulantes/agregar', [PostulanteController::class,'agregar'])->name('postulantes.agregar')->middleware('sesion.iniciada');
Route::get('postulantes/{id}', [PostulanteController::class,'mostrar'])->name('postulantes.mostrar')->middleware('sesion.iniciada');
Route::post('postulantes', [PostulanteController::class,'insertar'])->name('postulantes.insertar');
Route::get('postulantes/{id}/modificar', [PostulanteController::class,'modificar'])->name('postulantes.modificar')->middleware('sesion.iniciada');
Route::put('postulantes/{persona}', [PostulanteController::class,'actualizar'])->name('postulantes.actualizar')->middleware('sesion.iniciada');
Route::delete('postulantes/{persona}', [PostulanteController::class,'eliminar'])->name('postulantes.eliminar')->middleware('sesion.iniciada');

Route::post('postulantes/guardar-postulacion', [PostulanteController::class,'guardarPostulacion'])->name('postulantes.guardarPostulacion');
Route::get('postulantes/postulacion-empleo/{codigoConvocatoria}', [PostulanteController::class,'postulacion'])->name('postulantes.postulacion');

