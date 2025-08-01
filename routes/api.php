<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::prefix('categories')->as('categories:')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});
Route::prefix('products')->as('products:')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/export/all', [ProductController::class, 'export']);
});

Route::get('/download/export/{file}', function ($file) {
    $disk = Storage::disk('local');
    $path = 'exports/' . $file;

    if (!$disk->exists($path)) {
        return response()->json([
            'error' => 'File not ready yet',
            'status_check' => route('export.status', ['file' => $file])
        ], 404);
    }

    return $disk->download($path);
})->name('export.download')->where('file', '[A-Za-z0-9_\-\.]+');

Route::get('/export/status/{file}', function ($file) {
    $disk = Storage::disk('local');
    $path = 'exports/' . $file;

    return response()->json([
        'exists' => $disk->exists($path),
        'url' => $disk->exists($path) ? route('export.download', ['file' => $file]) : null
    ]);
})->name('export.status')->where('file', '[A-Za-z0-9_\-\.]+');
