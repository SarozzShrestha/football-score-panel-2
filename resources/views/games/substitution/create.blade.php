<form method="POST" action="{{ route('admin.games.substitution.store', ['game' => $game, 'team' => $team]) }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="teamAModalLabel">{{ $team->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="playerOut" class="form-label">Player Out</label>
                <select class="form-control" id="playerOut" name="subbed_for" required>
                    <option disabled>-- Select Player --</option>
                    @foreach($subOutEligiblePlayers as $player)
                    <!-- 1 = in game -->
                    <option value="{{ $player->player_id }}">{{ $player->player_name }} ({{ $player->jersey_no }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="playerIn" class="form-label">Player In</label>

                <select class="form-control" id="playerIn" name="subbed_by" required>
                    <option disabled>-- Select Player --</option>
                    @foreach($subInEligiblePlayers as $player)
                    <!-- 2 = on bench -->
                    <option value="{{ $player->player_id }}">{{ $player->player_name }} ({{ $player->jersey_no }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="substitutionTime" class="form-label">Substitution Time (Minute)</label>
                <input type="number" class="form-control" id="substitutionTime" name="subbed_at" placeholder="e.g. 65"
                    required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="reason" class="form-label">Reason</label>
                <select class="form-control" id="reason" name="reason" required>
                    <option disabled>-- Select Reason --</option>
                    @foreach(\App\Constants\AppConstants::SUBSTITUTION_REASONS as $key => $reason)
                    <option value="{{ $key }}">{{ $reason }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="isExtraTime" name="is_extra_time">
            <label class="form-check-label" for="isExtraTime">Substitution in Extra Time?</label>
        </div>

        <div class="row" id="extraTimeRow" style="display: none;">
            <div class="col-md-6 mb-3">
                <label for="extraMinute" class="form-label">Extra Minute</label>
                <input type="number" class="form-control" id="extraMinute" name="extra_minutes" placeholder="e.g. 2">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary w-100">Submit Substitution</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('#isExtraTime').on('change', function () {
            $('#extraTimeRow').toggle(this.checked);
        });
    });
</script>