<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameLogController;
use App\Http\Controllers\GameScoreController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SubstitutionController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
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

        Route::prefix('games/{game}/teams/{team}/substitutions')->controller(SubstitutionController::class)->group(function () {
            Route::get('create', 'gameSubstitutionCreate')->name('games.substitution.create');
            Route::post('/', 'gameSubstitutionStore')->name('games.substitution.store');
        });

        Route::prefix('tournaments')->controller(TournamentController::class)->group(function () {
            Route::get('/', 'listTournament')->name('tournament.index');
            Route::get('/create', 'createTournament')->name('tournament.create');
            Route::post('/store', 'store')->name('tournament.store');
            Route::post('/update', 'updateTournament')->name('tournament.edit');
        });

        Route::group(['prefix' => 'games/{game}/', 'controller' => GameLogController::class], function () {
            Route::get('/score-logs', 'fetchScoreLogs')->name('games.scoreLogs');
            Route::patch('/score-log/{id}', 'updateScoreLog')->name('games.updateScoreLog');
            Route::get('/foul-logs', 'fetchFoulLogs')->name('games.foulLogs');
            Route::get('/substitution-logs', 'fetchSubstitutionLogs')->name('games.substitutionLogs');
            Route::delete('/score-log/{id}', 'deleteScoreLog')->name('games.deleteScoreLog');
            Route::patch('/foul-log/{id}', 'updateFoulLog')->name('games.updateFoulLog');
            Route::delete('/foul-log/{id}','deleteFoulLog')->name('games.deleteFoulLog');
            Route::delete('/sub-log/{id}', 'deleteSubstitutionLog')->name('games.deleteSubstitutionLog');
            Route::patch('/sub-log/{id}', 'updateSubstitutionLog')->name('games.updateSubstitutionLog');
        });
    });

});
