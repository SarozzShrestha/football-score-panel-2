<div>
    <h5>Score Log</h5>
    <table class="table table-bordered" id="scoreLogTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team</th>
                <th>Scorer</th>
                <th>Assist</th>
                <th>Is Penalty</th>
                <th>Is Own Goal</th>
                <th>Scored At</th>
                <th>Action</th> {{-- 👈 Added for Delete button --}}
            </tr>
        </thead>
        <tbody>
            @foreach($scoreLogs as $log)
            <tr data-id="{{ $log->id }}" data-team="{{ $log->team_id }}">
                <td>{{ $log->id }}</td>
                <td>{{ $log->team }}</td>

                {{-- Scorer --}}
                <td class="editable" data-field="scored_by" data-value="{{ $log->scored_by }}">
                    {{ $log->scorer_name }}
                </td>

                {{-- Assist --}}
                <td class="editable" data-field="assist_by" data-value="{{ $log->assist_by }}">
                    {{ $log->assist_name }}
                </td>

                {{-- Is Penalty --}}
                <td class="editable" data-field="is_penalty" data-value="{{ $log->is_penalty }}">
                    {{ $log->is_penalty == '1' ? 'Yes' : 'No' }}
                </td>

                {{-- Is Own Goal --}}
                <td class="editable" data-field="is_own_goal" data-value="{{ $log->is_own_goal }}">
                    {{ $log->is_own_goal == '1' ? 'Yes' : 'No' }}
                </td>

                <td>{{ $log->scored_at }}</td>

                {{-- 🗑️ Delete button --}}
                <td>
                    <button class="btn btn-sm btn-danger delete-log">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    var teamPlayers = @json($players); // { team_id: [{id, player_name}, ...] }

    $(document).ready(function() {
        // ========= Inline Edit Handler =========
        $('#scoreLogTable').on('click', '.editable', function() {
            const $cell = $(this);
            const field = $cell.data('field');
            const $row = $cell.closest('tr');
            const id = $row.data('id');
            const teamId = $row.data('team');
            const currentValue = $cell.data('value');

            if ($cell.find('input, select').length > 0) return;

            let input;

            // 🎯 Player dropdowns
            if (field === 'scored_by' || field === 'assist_by') {
                input = $('<select class="form-control form-control-sm"></select>');
                const players = teamPlayers[teamId] || [];

                players.forEach(p => {
                    const option = $('<option></option>')
                        .val(p.id)
                        .text(p.player_name);
                    if (p.id == currentValue) option.prop('selected', true);
                    input.append(option);
                });

                if (players.length === 0) input.append('<option value="">No players</option>');
            }

            // ⚙️ Boolean dropdowns
            else if (field === 'is_penalty' || field === 'is_own_goal') {
                input = $('<select class="form-control form-control-sm">' +
                    '<option value="0">No</option>' +
                    '<option value="1">Yes</option>' +
                    '</select>');
                input.val(currentValue);
            }

            // ✏️ Fallback input
            else {
                input = $('<input type="text" class="form-control form-control-sm">').val($cell.text());
            }

            $cell.html(input);
            input.focus();

            input.on('blur change keypress', function(e) {
                if (e.type === 'blur' || e.type === 'change' || (e.type === 'keypress' && e.which === 13)) {
                    const newValue = input.val();
                    const newText = input.find('option:selected').text() || newValue;

                    $cell.text(newText).data('value', newValue);

                    $.ajax({
                        url: 'score-log/' + id,
                        method: 'PATCH',
                        data: {
                            _token: '{{ csrf_token() }}',
                            [field]: newValue
                        },
                        success: function(res) {
                            console.log('✅ Updated successfully', res);
                        },
                        error: function(err) {
                            alert('❌ Error updating field');
                            $cell.text(currentValue);
                        }
                    });
                }
            });
        });

        // ========= Delete Log Handler =========
        $('#scoreLogTable').on('click', '.delete-log', function() {
            const $row = $(this).closest('tr');
            const id = $row.data('id');

            if (!confirm('Are you sure you want to delete this log?')) return;

            $.ajax({
                url: 'score-log/' + id,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                    console.log('🗑️ Log deleted successfully', res);
                },
                error: function(err) {
                    alert('❌ Failed to delete log');
                }
            });
        });
    });
</script>