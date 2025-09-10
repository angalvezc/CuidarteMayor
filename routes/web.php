<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\RoleController;

/**
 * USERS
 */
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

/**
 * RESIDENTS
 */
Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
Route::get('/residents/{resident}', [ResidentController::class, 'show'])->name('residents.show');
Route::get('/residents/{resident}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
Route::put('/residents/{resident}', [ResidentController::class, 'update'])->name('residents.update');
Route::delete('/residents/{resident}', [ResidentController::class, 'destroy'])->name('residents.destroy');

/**
 * HEALTH RECORDS
 */
Route::get('/health-records', [HealthRecordController::class, 'index'])->name('health_records.index');
Route::get('/health-records/create', [HealthRecordController::class, 'create'])->name('health_records.create');
Route::post('/health-records', [HealthRecordController::class, 'store'])->name('health_records.store');
Route::get('/health-records/{healthRecord}', [HealthRecordController::class, 'show'])->name('health_records.show');
Route::get('/health-records/{healthRecord}/edit', [HealthRecordController::class, 'edit'])->name('health_records.edit');
Route::put('/health-records/{healthRecord}', [HealthRecordController::class, 'update'])->name('health_records.update');
Route::delete('/health-records/{healthRecord}', [HealthRecordController::class, 'destroy'])->name('health_records.destroy');

/**
 * MEDICATIONS
 */
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
Route::get('/medications/create', [MedicationController::class, 'create'])->name('medications.create');
Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
Route::get('/medications/{medication}', [MedicationController::class, 'show'])->name('medications.show');
Route::get('/medications/{medication}/edit', [MedicationController::class, 'edit'])->name('medications.edit');
Route::put('/medications/{medication}', [MedicationController::class, 'update'])->name('medications.update');
Route::delete('/medications/{medication}', [MedicationController::class, 'destroy'])->name('medications.destroy');

/**
 * ACTIVITIES
 */
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

/**
 * VISITS
 */
Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
Route::put('/visits/{visit}', [VisitController::class, 'update'])->name('visits.update');
Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');

/**
 * ROLES
 */
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
