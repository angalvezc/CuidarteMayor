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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});
/**
 * USERS
 */
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    // web.php
    Route::get('/users/search-by-dni/{dni}', [UserController::class, 'searchByDni']);

});

/**
 * RESIDENTS
 */
Route::middleware('auth', 'role:enfermerx|admin|doctor')->group(function () {
    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');

    Route::get('/residents/search/{dni}', [App\Http\Controllers\ResidentController::class, 'searchByDni']);
    Route::get('/users/search-by-dni/{dni}', [UserController::class, 'searchByDni']);

});
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
    Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
    Route::get('/residents/{resident}', [ResidentController::class, 'show'])->name('residents.show');
    Route::get('/residents/{resident}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
    Route::put('/residents/{resident}', [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('/residents/{resident}', [ResidentController::class, 'destroy'])->name('residents.destroy');
});
/**
 * HEALTH RECORDS
 */
Route::middleware('auth', 'role:doctor|admin')->group(function () {
    // Verifica si el residente ya tiene historial
    Route::get('/health-records/check/{resident}', function ($resident) {
        $exists = \App\Models\HealthRecord::where('resident_id', $resident)->exists();
        return response()->json(['exists' => $exists]);
    });

    // Buscar residente por DNI
    Route::get('/residents/search/{dni}', function ($dni) {
    $resident = \App\Models\Resident::where('dni', $dni)->first();
    if ($resident) {
        return response()->json(['success' => true, 'resident' => $resident]);
    } else {
        return response()->json(['success' => false]);
    }
    });


    // Health Records
    Route::get('/health-records', [\App\Http\Controllers\HealthRecordController::class, 'index'])->name('health_records.index');
    Route::get('/health-records/create', [\App\Http\Controllers\HealthRecordController::class, 'create'])->name('health_records.create');
    Route::post('/health-records', [\App\Http\Controllers\HealthRecordController::class, 'store'])->name('health_records.store');
    Route::get('/health-records/{healthRecord}', [\App\Http\Controllers\HealthRecordController::class, 'show'])->name('health_records.show');
    Route::get('/health-records/{healthRecord}/edit', [\App\Http\Controllers\HealthRecordController::class, 'edit'])->name('health_records.edit');
    Route::put('/health-records/{healthRecord}', [\App\Http\Controllers\HealthRecordController::class, 'update'])->name('health_records.update');

});
Route::middleware('auth', 'role:admin')->group(function () {
    Route::delete('/health-records/{healthRecord}', [\App\Http\Controllers\HealthRecordController::class, 'destroy'])->name('health_records.destroy');
});
/**
 * MEDICATIONS
 */
Route::middleware('auth', 'role:enfermerx|doctor|admin')->group(function () {
    Route::resource('medications', MedicationController::class);
    // Mostrar todas las dosis de un registro de salud
    Route::get('medications/record/{healthRecord}', [MedicationController::class, 'showRecord'])->name('medications.record');

    // Actualizar dosis
    Route::put('medications/{medication}', [MedicationController::class, 'update'])->name('medications.update');
    Route::post('/medications/{healthRecord}/complete', [MedicationController::class, 'complete'])
        ->name('medications.complete')
        ->middleware(['auth']);
});







/**
 * VISITS
 */
Route::middleware('auth', 'role:admin|enfermerx')->group(function () {
    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
    Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
    Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
    Route::put('/visits/{visit}', [VisitController::class, 'update'])->name('visits.update');
    Route::delete('/visits/{visit}', [VisitController::class, 'destroy'])->name('visits.destroy');
    Route::post('/visits/find-resident', [VisitController::class, 'findResidentByDni'])->name('visits.findResident');
    Route::post('/visits/find-user', [VisitController::class, 'findUserByDni'])->name('visits.findUser');
});


/**
 * ROLES
 */
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
