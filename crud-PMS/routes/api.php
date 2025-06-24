<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::get('test',function(){
    return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully.'
        ], 200);
});
