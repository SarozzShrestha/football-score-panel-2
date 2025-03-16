<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::resource('players', PlayerController::class)->names(
        [
            'index' => 'admin.players.index',
            'create' => 'admin.players.create',
            'show' => 'admin.players.show',
            'store' => 'admin.players.store',
            'edit' => 'admin.players.edit',
            'update' => 'admin.players.update',
            'destroy' => 'admin.players.destroy',
        ]
    );
});
