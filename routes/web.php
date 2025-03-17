<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
   return view('dashboard');
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

    Route::name('admin.')->group(function () {
        Route::resource('teams', TeamController::class)->names([
            'index' => 'teams.index',
            'create' => 'teams.create',
            'show' => 'teams.show',
            'store' => 'teams.store',
            'edit' => 'teams.edit',
            'update' => 'teams.update',
            'destroy' => 'teams.destroy',
        ]);

        Route::get('teams/{team}/players', [TeamController::class, 'viewTeamPlayers'])->name('teams.teamPlayers');
        Route::post('teams/{team}/players', [TeamController::class, 'updateTeamPlayers'])->name('teams.teamPlayers.update');
    });

});
