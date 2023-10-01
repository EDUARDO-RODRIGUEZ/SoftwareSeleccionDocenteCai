<?php
use App\Http\Controllers\GestionController;

Route::get('gestiones', [GestionController::class,'index'])->name('gestiones.index')->middleware('sesion.iniciada');
Route::get('gestiones/agregar', [GestionController::class,'agregar'])->name('gestiones.agregar')->middleware('sesion.iniciada');
Route::get('gestiones/{id}', [GestionController::class,'mostrar'])->name('gestiones.mostrar')->middleware('sesion.iniciada');
Route::post('gestiones', [GestionController::class,'insertar'])->name('gestiones.insertar')->middleware('sesion.iniciada');
Route::get('gestiones/{id}/modificar', [GestionController::class,'modificar'])->name('gestiones.modificar')->middleware('sesion.iniciada');
Route::put('gestiones/{gestion}', [GestionController::class,'actualizar'])->name('gestiones.actualizar')->middleware('sesion.iniciada');
Route::delete('gestiones/{gestion}', [GestionController::class,'eliminar'])->name('gestiones.eliminar')->middleware('sesion.iniciada');
