<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameScoreController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

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

        Route::resource('games', GameController::class)->names([
            'index' => 'games.index',
            'create' => 'games.create',
            'store' => 'games.store',
            'show' => 'games.show',
        ]);

        Route::get('games/{game}/playing-xi', [GameController::class, 'gamePlayingXI'])->name('games.playingXI');
        Route::post('games/{game}/playing-xi', [GameController::class, 'updateGamePlayingXI'])->name('games.post.playingXI');
        Route::get('games/{game}/dashboard', [GameController::class, 'gameDashboardView'])->name('games.dashboard');

        Route::post('games/{game}/team/{team}/score', [GameScoreController::class, 'gameScoreAction'])->name('games.team.score');
        Route::post('games/{game}/team/{team}/foul/log', [GameController::class, 'gameCardLogAction'])->name('games.team.cardLog');
    });

});
