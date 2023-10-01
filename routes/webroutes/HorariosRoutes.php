<?php
use App\Http\Controllers\HorarioController;
Route::get('horarios', [HorarioController::class,'index'])->name('horarios.index')->middleware('sesion.iniciada');
Route::get('horarios/agregar', [HorarioController::class,'agregar'])->name('horarios.agregar')->middleware('sesion.iniciada');
Route::get('horarios/{id}', [HorarioController::class,'mostrar'])->name('horarios.mostrar')->middleware('sesion.iniciada');
Route::post('horarios', [HorarioController::class,'insertar'])->name('horarios.insertar')->middleware('sesion.iniciada');
Route::get('horarios/{id}/modificar', [HorarioController::class,'modificar'])->name('horarios.modificar')->middleware('sesion.iniciada');
Route::put('horarios/{horario}', [HorarioController::class,'actualizar'])->name('horarios.actualizar')->middleware('sesion.iniciada');
Route::delete('horarios/{horario}', [HorarioController::class,'eliminar'])->name('horarios.eliminar')->middleware('sesion.iniciada');
