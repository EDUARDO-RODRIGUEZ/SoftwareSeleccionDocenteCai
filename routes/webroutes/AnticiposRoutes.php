<?php
use App\Http\Controllers\AnticipoController;

Route::get('anticipos', [AnticipoController::class,'index'])->name('anticipos.index')->middleware('sesion.iniciada');
Route::get('anticipos/agregar', [AnticipoController::class,'agregar'])->name('anticipos.agregar')->middleware('sesion.iniciada');
Route::get('anticipos/{id}', [AnticipoController::class,'mostrar'])->name('anticipos.mostrar')->middleware('sesion.iniciada');
Route::post('anticipos', [AnticipoController::class,'insertar'])->name('anticipos.insertar')->middleware('sesion.iniciada');
Route::get('anticipos/{id}/modificar', [AnticipoController::class,'modificar'])->name('anticipos.modificar')->middleware('sesion.iniciada');
Route::put('anticipos/{anticipo}', [AnticipoController::class,'actualizar'])->name('anticipos.actualizar')->middleware('sesion.iniciada');
Route::delete('anticipos/{anticipo}', [AnticipoController::class,'eliminar'])->name('anticipos.eliminar')->middleware('sesion.iniciada');
