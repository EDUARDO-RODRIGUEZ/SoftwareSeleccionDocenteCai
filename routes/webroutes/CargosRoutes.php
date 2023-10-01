<?php
use App\Http\Controllers\CargoController;
Route::get('cargos', [CargoController::class,'index'])->name('cargos.index')->middleware('sesion.iniciada');
Route::get('cargos/agregar', [CargoController::class,'agregar'])->name('cargos.agregar')->middleware('sesion.iniciada');
Route::get('cargos/{id}', [CargoController::class,'mostrar'])->name('cargos.mostrar')->middleware('sesion.iniciada');
Route::post('cargos', [CargoController::class,'insertar'])->name('cargos.insertar')->middleware('sesion.iniciada');
Route::get('cargos/{id}/modificar', [CargoController::class,'modificar'])->name('cargos.modificar')->middleware('sesion.iniciada');
Route::put('cargos/{cargo}', [CargoController::class,'actualizar'])->name('cargos.actualizar')->middleware('sesion.iniciada');
Route::delete('cargos/{cargo}', [CargoController::class,'eliminar'])->name('cargos.eliminar')->middleware('sesion.iniciada');
