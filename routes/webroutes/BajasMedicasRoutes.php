<?php
use App\Http\Controllers\BajaMedicaController;

Route::get('bajasmedicas', [BajaMedicaController::class,'index'])->name('bajasmedicas.index')->middleware('sesion.iniciada');
Route::get('bajasmedicas/agregar', [BajaMedicaController::class,'agregar'])->name('bajasmedicas.agregar')->middleware('sesion.iniciada');
Route::get('bajasmedicas/{id}', [BajaMedicaController::class,'mostrar'])->name('bajasmedicas.mostrar')->middleware('sesion.iniciada');
Route::post('bajasmedicas', [BajaMedicaController::class,'insertar'])->name('bajasmedicas.insertar')->middleware('sesion.iniciada');
Route::get('bajasmedicas/{id}/modificar', [BajaMedicaController::class,'modificar'])->name('bajasmedicas.modificar')->middleware('sesion.iniciada');
Route::put('bajasmedicas/{bajamedica}', [BajaMedicaController::class,'actualizar'])->name('bajasmedicas.actualizar')->middleware('sesion.iniciada');
Route::delete('bajasmedicas/{bajamedica}', [BajaMedicaController::class,'eliminar'])->name('bajasmedicas.eliminar')->middleware('sesion.iniciada');
