<?php
use App\Http\Controllers\DepartamentoController;

Route::get('departamentos', [DepartamentoController::class,'index'])->name('departamentos.index')->middleware('sesion.iniciada');
Route::get('departamentos/agregar', [DepartamentoController::class,'agregar'])->name('departamentos.agregar')->middleware('sesion.iniciada');
Route::get('departamentos/{id}', [DepartamentoController::class,'mostrar'])->name('departamentos.mostrar')->middleware('sesion.iniciada');
Route::post('departamentos', [DepartamentoController::class,'insertar'])->name('departamentos.insertar')->middleware('sesion.iniciada');
Route::get('departamentos/{id}/modificar', [DepartamentoController::class,'modificar'])->name('departamentos.modificar')->middleware('sesion.iniciada');
Route::put('departamentos/{departamento}', [DepartamentoController::class,'actualizar'])->name('departamentos.actualizar')->middleware('sesion.iniciada');
Route::delete('departamentos/{departamento}', [DepartamentoController::class,'eliminar'])->name('departamentos.eliminar')->middleware('sesion.iniciada');
