<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});*/

Route::prefix('order')->group(function () {
    // Order-related routes
    Route::get('/get/{order_id}', [OrderController::class, 'show']);
    Route::post('/search', [OrderController::class, 'search']);
    Route::post('/create', [OrderController::class, 'create']);
    Route::delete('/delete', [OrderController::class, 'delete']);

    Route::get('/date', [OrderController::class, 'getOrderByDateRange']);
});

    // Product-related routes
    //Route::get('/products', [ProductController::class, 'index']);
    //Route::post('/create-product', [ProductController::class, 'create']);


Route::get('/db-test', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();

        // Return success response if database is connected
        return response()->json([
            'message' => 'Database connection successful!',
            'status' => 'success'
        ], 200);
    } catch (\Exception $e) {
        // Return error if database connection fails
        return response()->json([
            'message' => 'Database connection failed: ' . $e->getMessage(),
            'status' => 'error'
        ], 500);
    }
});


