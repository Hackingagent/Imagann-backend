
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;

// routes/api.php

Route::get('/projects', [ProjectController::class, 'index'])->withoutMiddleware('verify.csrf.token');
Route::post('/projects', [ProjectController::class, 'store'])->withoutMiddleware('verify.csrf.token');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
// routes/api.php

Route::post('/api/projects/images', [ImageController::class, 'uploadImage'])->withoutMiddleware('verify.csrf.token');
Route::get('/api/projects/{projectId}/images', [ImageController::class, 'getProjectImages'])->withoutMiddleware('verify.csrf.token');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
