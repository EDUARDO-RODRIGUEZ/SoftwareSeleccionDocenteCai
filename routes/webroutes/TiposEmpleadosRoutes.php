<?php
use App\Http\Controllers\TipoEmpleadoController;

Route::get('tipos-empleados', [TipoEmpleadoController::class,'index'])->name('tipos_empleados.index')->middleware('sesion.iniciada');
Route::get('tipos-empleados/agregar', [TipoEmpleadoController::class,'agregar'])->name('tipos_empleados.agregar')->middleware('sesion.iniciada');
Route::get('tipos-empleados/{id}', [TipoEmpleadoController::class,'mostrar'])->name('tipos_empleados.mostrar')->middleware('sesion.iniciada');
Route::post('tipos-empleados', [TipoEmpleadoController::class,'insertar'])->name('tipos_empleados.insertar')->middleware('sesion.iniciada');
Route::get('tipos-empleados/{id}/modificar', [TipoEmpleadoController::class,'modificar'])->name('tipos_empleados.modificar')->middleware('sesion.iniciada');
Route::put('tipos-empleados/{tipo_empleado}', [TipoEmpleadoController::class,'actualizar'])->name('tipos_empleados.actualizar')->middleware('sesion.iniciada');
Route::delete('tipos-empleados/{tipo_empleado}', [TipoEmpleadoController::class,'eliminar'])->name('tipos_empleados.eliminar')->middleware('sesion.iniciada');
