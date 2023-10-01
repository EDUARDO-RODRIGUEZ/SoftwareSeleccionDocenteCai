<?php
use App\Http\Controllers\DescuentoController;

Route::get('descuentos', [DescuentoController::class,'index'])->name('descuentos.index')->middleware('sesion.iniciada');
Route::get('descuentos/agregar', [DescuentoController::class,'agregar'])->name('descuentos.agregar')->middleware('sesion.iniciada');
Route::get('descuentos/{id}', [DescuentoController::class,'mostrar'])->name('descuentos.mostrar')->middleware('sesion.iniciada');
Route::post('descuentos', [DescuentoController::class,'insertar'])->name('descuentos.insertar')->middleware('sesion.iniciada');
Route::get('descuentos/{id}/modificar', [DescuentoController::class,'modificar'])->name('descuentos.modificar')->middleware('sesion.iniciada');
Route::put('descuentos/{descuento}', [DescuentoController::class,'actualizar'])->name('descuentos.actualizar')->middleware('sesion.iniciada');
Route::delete('descuentos/{descuento}', [DescuentoController::class,'eliminar'])->name('descuentos.eliminar')->middleware('sesion.iniciada');
