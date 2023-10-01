<?php
use App\Http\Controllers\TareaController;

Route::get('tareas', [TareaController::class,'index'])->name('tareas.index')->middleware('sesion.iniciada');
Route::get('tareas/agregar', [TareaController::class,'agregar'])->name('tareas.agregar')->middleware('sesion.iniciada');
Route::get('tareas/{id}', [TareaController::class,'mostrar'])->name('tareas.mostrar')->middleware('sesion.iniciada');
Route::post('tareas', [TareaController::class,'insertar'])->name('tareas.insertar')->middleware('sesion.iniciada');
Route::get('tareas/{id}/modificar', [TareaController::class,'modificar'])->name('tareas.modificar')->middleware('sesion.iniciada');
Route::put('tareas/{tarea}', [TareaController::class,'actualizar'])->name('tareas.actualizar')->middleware('sesion.iniciada');
Route::delete('tareas/{tarea}', [TareaController::class,'eliminar'])->name('tareas.eliminar')->middleware('sesion.iniciada');
