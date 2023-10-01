<?php
use App\Http\Controllers\BonoController;

Route::get('bonos', [BonoController::class,'index'])->name('bonos.index')->middleware('sesion.iniciada');
Route::get('bonos/agregar', [BonoController::class,'agregar'])->name('bonos.agregar')->middleware('sesion.iniciada');
Route::get('bonos/{id}', [BonoController::class,'mostrar'])->name('bonos.mostrar')->middleware('sesion.iniciada');
Route::post('bonos', [BonoController::class,'insertar'])->name('bonos.insertar')->middleware('sesion.iniciada');
Route::get('bonos/{id}/modificar', [BonoController::class,'modificar'])->name('bonos.modificar')->middleware('sesion.iniciada');
Route::put('bonos/{bono}', [BonoController::class,'actualizar'])->name('bonos.actualizar')->middleware('sesion.iniciada');
Route::delete('bonos/{bono}', [BonoController::class,'eliminar'])->name('bonos.eliminar')->middleware('sesion.iniciada');
