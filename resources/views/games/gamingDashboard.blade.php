<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Score</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">
        {{ $game->team_a }} ({{ $game->team_a_abb }}) - <b>{{ $game->team_a_score }}</b> vs <b>{{ $game->team_b_score }}</b> - {{ $game->team_b }} ({{ $game->team_b_abb }})
    </h2>

    <div class="d-flex justify-content-center mt-3">
        <!-- Team A Score Button with Modal Trigger -->
        <button class="btn btn-primary mr-3" data-toggle="modal" data-target="#teamAModal">Team A Score ({{ $game->team_a_abb }})</button>

        <!-- Team B Score Button with Modal Trigger -->
        <button class="btn btn-success" data-toggle="modal" data-target="#teamBModal">Team B Score ({{ $game->team_b_abb }})</button>
    </div>
</div>

<!-- Modal for Team A Score -->
<div class="modal fade" id="teamAModal" tabindex="-1" role="dialog" aria-labelledby="teamAModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.games.team.score', ['game' => $game, 'team' => $game->teamA]) }}">
                @csrf
                <div class="modal-header">
                <h5 class="modal-title" id="teamAModalLabel">Team A Score</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">
                    <!-- Form for Team A Score -->
                        <div class="form-group">
                            <label for="scoredByB">Scored By</label>
                            <select class="form-control" id="scoredBy" name="scored_by">
                                <option value="">-- Select Scorer --</option>
                                @foreach($game->teamA->players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->pivot->jersey_no }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="assistByB">Assist By</label>
                            <select class="form-control" id="assistBy" name="assist_by">
                                <option value="">-- Select Assist By --</option>
                                @foreach($game->teamA->players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}({{ $player->pivot->jersey_no }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="scoredTimeA">Scored Time</label>
                            <input type="text" class="form-control" id="scoredTimeA" name="scored_time" placeholder="Enter time (e.g., 45')">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_penalty" id="isPenalty">
                            <label class="form-check-label" for="isPenalty">Is Penalty</label>
                        </div>
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" name="is_own_goal" id="isOwnGoal">
                            <label class="form-check-label" for="isOwnGoal">Is Own Goal</label>
                        </div>
                        <div class="form-group">
                            <label for="ownGoal">Own Goal By</label>
                            <select class="form-control" id="scoredBy" name="own_goal">
                                <option value="">-- Select Scorer --</option>
                                @foreach($game->teamB->players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->pivot->jersey_no }})</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Team B Score -->
<div class="modal fade" id="teamBModal" tabindex="-1" role="dialog" aria-labelledby="teamBModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.games.team.score', ['game' => $game, 'team' => $game->teamB]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="teamAModalLabel">Team A Score</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Form for Team A Score -->
                    <div class="form-group">
                        <label for="scoredByB">Scored By</label>
                        <select class="form-control" id="scoredBy" name="scored_by">
                            <option value="">-- Select Scorer --</option>
                            @foreach($game->teamB->players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->pivot->jersey_no }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assistByB">Assist By</label>
                        <select class="form-control" id="assistBy" name="assist_by">
                            <option value="">-- Select Assist By --</option>
                            @foreach($game->teamB->players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }}({{ $player->pivot->jersey_no }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scoredTimeA">Scored Time</label>
                        <input type="text" class="form-control" id="scoredTimeA" name="scored_time" placeholder="Enter time (e.g., 45')">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_penalty" id="isPenalty">
                        <label class="form-check-label" for="isPenalty">Is Penalty</label>
                    </div>
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" name="is_own_goal" id="isOwnGoal">
                        <label class="form-check-label" for="isOwnGoal">Is Own Goal</label>
                    </div>
                    <div class="form-group">
                        <label for="ownGoal">Own Goal By</label>
                        <select class="form-control" id="scoredBy" name="own_goal">
                            <option value="">-- Select Scorer --</option>
                            @foreach($game->teamA->players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }} ({{ $player->pivot->jersey_no }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

</script>

</body>
</html>
