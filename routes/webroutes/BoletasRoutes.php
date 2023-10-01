<?php
use App\Http\Controllers\BoletaController;

Route::get('boletas', [BoletaController::class,'index'])->name('boletas.index')->middleware('sesion.iniciada');
Route::delete('boletas/{boleta}', [BoletaController::class,'eliminar'])->name('boletas.eliminar')->middleware('sesion.iniciada');
Route::get('boletas/generar', [BoletaController::class,'generar'])->name('boletas.generar')->middleware('sesion.iniciada');
Route::post('boletas/guardar-boletas', [BoletaController::class,'guardarBoletas'])->name('boletas.guardarBoletas')->middleware('sesion.iniciada');

Route::get('boletas/pagar/{boleta}', [BoletaController::class,'pagar'])->name('boletas.pagar')->middleware('sesion.iniciada');
Route::get('boletas/recibo/{boleta}', [BoletaController::class,'recibo'])->name('boletas.recibo')->middleware('sesion.iniciada');
Route::post('boletas/guardar-pago', [BoletaController::class,'guardarPago'])->name('boletas.guardarPago')->middleware('sesion.iniciada');