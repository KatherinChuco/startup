<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Rutas para CRUD de departamentos
Route::resource('departments', DepartmentController::class);

// Ruta para listar los subdepartamentos de un departamento específico
Route::get('departments/{id}/subdepartments', [DepartmentController::class, 'subdepartments']);