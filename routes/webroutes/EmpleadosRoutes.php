<?php
use App\Http\Controllers\EmpleadoController;
Route::get('empleados', [EmpleadoController::class,'index'])->name('empleados.index')->middleware('sesion.iniciada');
Route::get('empleados/agregar', [EmpleadoController::class,'agregar'])->name('empleados.agregar')->middleware('sesion.iniciada');
Route::get('empleados/{id}', [EmpleadoController::class,'mostrar'])->name('empleados.mostrar')->middleware('sesion.iniciada');
Route::post('empleados', [EmpleadoController::class,'insertar'])->name('empleados.insertar')->middleware('sesion.iniciada');
Route::get('empleados/{id}/modificar', [EmpleadoController::class,'modificar'])->name('empleados.modificar')->middleware('sesion.iniciada');
Route::put('empleados/{empleado}', [EmpleadoController::class,'actualizar'])->name('empleados.actualizar')->middleware('sesion.iniciada');
Route::delete('empleados/{empleado}', [EmpleadoController::class,'eliminar'])->name('empleados.eliminar')->middleware('sesion.iniciada');
Route::get('empleados/personas-activas/buscar', [EmpleadoController::class,'personasActivas'])->name('empleados.personasActivas')->middleware('sesion.iniciada');
Route::get('empleados/empleados-activos/buscar', [EmpleadoController::class,'empleadosActivos'])->name('empleados.empleadosActivos')->middleware('sesion.iniciada');
