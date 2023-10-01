<?php
use App\Http\Controllers\SucursalController;

Route::get('sucursales', [SucursalController::class,'index'])->name('sucursales.index')->middleware('sesion.iniciada');
Route::get('sucursales/agregar', [SucursalController::class,'agregar'])->name('sucursales.agregar')->middleware('sesion.iniciada');
Route::get('sucursales/{id}', [SucursalController::class,'mostrar'])->name('sucursales.mostrar')->middleware('sesion.iniciada');
Route::post('sucursales', [SucursalController::class,'insertar'])->name('sucursales.insertar')->middleware('sesion.iniciada');
Route::get('sucursales/{id}/modificar', [SucursalController::class,'modificar'])->name('sucursales.modificar')->middleware('sesion.iniciada');
Route::put('sucursales/{sucursal}', [SucursalController::class,'actualizar'])->name('sucursales.actualizar')->middleware('sesion.iniciada');
Route::delete('sucursales/{sucursal}', [SucursalController::class,'eliminar'])->name('sucursales.eliminar')->middleware('sesion.iniciada');
