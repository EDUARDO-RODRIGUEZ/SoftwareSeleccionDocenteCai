<?php
use App\Http\Controllers\PlantillaController;
Route::get('plantillas', [PlantillaController::class,'index'])->name('plantillas.index')->middleware('sesion.iniciada');
Route::get('plantillas/agregar', [PlantillaController::class,'agregar'])->name('plantillas.agregar')->middleware('sesion.iniciada');
Route::get('plantillas/{id}', [PlantillaController::class,'mostrar'])->name('plantillas.mostrar')->middleware('sesion.iniciada');
Route::post('plantillas', [PlantillaController::class,'insertar'])->name('plantillas.insertar')->middleware('sesion.iniciada');
Route::get('plantillas/{id}/modificar', [PlantillaController::class,'modificar'])->name('plantillas.modificar')->middleware('sesion.iniciada');
Route::put('plantillas/{plantilla}', [PlantillaController::class,'actualizar'])->name('plantillas.actualizar')->middleware('sesion.iniciada');
Route::delete('plantillas/{plantilla}', [PlantillaController::class,'eliminar'])->name('plantillas.eliminar')->middleware('sesion.iniciada');
