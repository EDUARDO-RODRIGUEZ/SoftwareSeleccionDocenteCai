<?php
use App\Http\Controllers\ConvocatoriaController;
Route::get('convocatorias', [ConvocatoriaController::class,'index'])->name('convocatorias.index')->middleware('sesion.iniciada');
Route::get('convocatorias/agregar', [ConvocatoriaController::class,'agregar'])->name('convocatorias.agregar')->middleware('sesion.iniciada');
Route::get('convocatorias/{id}', [ConvocatoriaController::class,'mostrar'])->name('convocatorias.mostrar')->middleware('sesion.iniciada');
Route::post('convocatorias', [ConvocatoriaController::class,'insertar'])->name('convocatorias.insertar')->middleware('sesion.iniciada');
Route::get('convocatorias/{id}/modificar', [ConvocatoriaController::class,'modificar'])->name('convocatorias.modificar')->middleware('sesion.iniciada');
Route::put('convocatorias/{convocatoria}', [ConvocatoriaController::class,'actualizar'])->name('convocatorias.actualizar')->middleware('sesion.iniciada');
Route::delete('convocatorias/{convocatoria}', [ConvocatoriaController::class,'eliminar'])->name('convocatorias.eliminar')->middleware('sesion.iniciada');
