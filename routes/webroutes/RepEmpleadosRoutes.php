<?php
use App\Http\Controllers\RepEmpleadosController;

Route::get('rep_empleados', [RepEmpleadosController::class,'index'])->name('rep_empleados.index')->middleware('sesion.iniciada');
Route::post('rep_empleados', [RepEmpleadosController::class,'index'])->name('rep_empleados.index')->middleware('sesion.iniciada');
