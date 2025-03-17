<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeamController;
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

    Route::resource('staffs', StaffController::class)->names(
        [
            'index' => 'admin.staffs.index',
            'create' => 'admin.staffs.create',
            'show' => 'admin.staffs.show',
            'store' => 'admin.staffs.store',
            'edit' => 'admin.staffs.edit',
            'update' => 'admin.staffs.update',
            'destroy' => 'admin.staffs.destroy',
        ]
    );

    Route::resource('teams', TeamController::class)->names(
        [
            'index' => 'admin.teams.index',
            'create' => 'admin.teams.create',
            'show' => 'admin.teams.show',
            'store' => 'admin.teams.store',
            'edit' => 'admin.teams.edit',
            'update' => 'admin.teams.update',
            'destroy' => 'admin.teams.destroy',
        ]
    );
});
