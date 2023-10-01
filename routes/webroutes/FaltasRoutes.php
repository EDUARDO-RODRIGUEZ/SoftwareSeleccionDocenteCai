<?php
use App\Http\Controllers\FaltaController;
Route::get('faltas', [FaltaController::class,'index'])->name('faltas.index')->middleware('sesion.iniciada');
Route::get('faltas/agregar', [FaltaController::class,'agregar'])->name('faltas.agregar')->middleware('sesion.iniciada');
Route::get('faltas/{id}', [FaltaController::class,'mostrar'])->name('faltas.mostrar')->middleware('sesion.iniciada');
Route::post('faltas', [FaltaController::class,'insertar'])->name('faltas.insertar')->middleware('sesion.iniciada');
Route::get('faltas/{id}/modificar', [FaltaController::class,'modificar'])->name('faltas.modificar')->middleware('sesion.iniciada');
Route::put('faltas/{falta}', [FaltaController::class,'actualizar'])->name('faltas.actualizar')->middleware('sesion.iniciada');
Route::delete('faltas/{falta}', [FaltaController::class,'eliminar'])->name('faltas.eliminar')->middleware('sesion.iniciada');
