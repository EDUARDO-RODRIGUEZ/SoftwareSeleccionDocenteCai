<?php
use App\Http\Controllers\ContratoController;

Route::get('contratos', [ContratoController::class,'index'])->name('contratos.index')->middleware('sesion.iniciada');
Route::get('contratos/agregar', [ContratoController::class,'agregar'])->name('contratos.agregar')->middleware('sesion.iniciada');
Route::get('contratos/{id}', [ContratoController::class,'mostrar'])->name('contratos.mostrar')->middleware('sesion.iniciada');
Route::post('contratos', [ContratoController::class,'insertar'])->name('contratos.insertar')->middleware('sesion.iniciada');
Route::get('contratos/{id}/modificar', [ContratoController::class,'modificar'])->name('contratos.modificar')->middleware('sesion.iniciada');
Route::put('contratos/{contrato}', [ContratoController::class,'actualizar'])->name('contratos.actualizar')->middleware('sesion.iniciada');
Route::delete('contratos/{contrato}', [ContratoController::class,'eliminar'])->name('contratos.eliminar')->middleware('sesion.iniciada');
