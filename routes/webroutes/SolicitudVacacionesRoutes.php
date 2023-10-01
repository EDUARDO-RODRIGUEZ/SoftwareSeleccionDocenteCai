<?php
use App\Http\Controllers\SolicitudVacacionController;

Route::get('solicitud_vacaciones', [SolicitudVacacionController::class,'index'])->name('solicitud_vacaciones.index')->middleware('sesion.iniciada');
Route::get('solicitud_vacaciones/agregar', [SolicitudVacacionController::class,'agregar'])->name('solicitud_vacaciones.agregar')->middleware('sesion.iniciada');
Route::get('solicitud_vacaciones/{id}', [SolicitudVacacionController::class,'mostrar'])->name('solicitud_vacaciones.mostrar')->middleware('sesion.iniciada');
Route::post('solicitud_vacaciones', [SolicitudVacacionController::class,'insertar'])->name('solicitud_vacaciones.insertar')->middleware('sesion.iniciada');
Route::get('solicitud_vacaciones/{id}/modificar', [SolicitudVacacionController::class,'modificar'])->name('solicitud_vacaciones.modificar')->middleware('sesion.iniciada');
Route::put('solicitud_vacaciones/{bono}', [SolicitudVacacionController::class,'actualizar'])->name('solicitud_vacaciones.actualizar')->middleware('sesion.iniciada');
Route::delete('solicitud_vacaciones/{bono}', [SolicitudVacacionController::class,'eliminar'])->name('solicitud_vacaciones.eliminar')->middleware('sesion.iniciada');

Route::get('solicitud_vacaciones/resolver/{solicitud_vacacion_id}/{resolucion}', [SolicitudVacacionController::class,'resolver'])->name('solicitud_vacaciones.resolver')->middleware('sesion.iniciada');