<?php
use App\Http\Controllers\VacacionController;
Route::get('vacaciones', [VacacionController::class,'index'])->name('vacaciones.index')->middleware('sesion.iniciada');
Route::get('vacaciones/agregar', [VacacionController::class,'agregar'])->name('vacaciones.agregar')->middleware('sesion.iniciada');
Route::get('vacaciones/{id}', [VacacionController::class,'mostrar'])->name('vacaciones.mostrar')->middleware('sesion.iniciada');
Route::post('vacaciones', [VacacionController::class,'insertar'])->name('vacaciones.insertar')->middleware('sesion.iniciada');
Route::get('vacaciones/{id}/modificar', [VacacionController::class,'modificar'])->name('vacaciones.modificar')->middleware('sesion.iniciada');
Route::put('vacaciones/{vacacion}', [VacacionController::class,'actualizar'])->name('vacaciones.actualizar')->middleware('sesion.iniciada');
Route::delete('vacaciones/{vacacion}', [VacacionController::class,'eliminar'])->name('vacaciones.eliminar')->middleware('sesion.iniciada');
