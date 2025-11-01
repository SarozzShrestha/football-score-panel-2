<div>
    <h5>Foul Log</h5>
    <table class="table table-bordered" id="foulLogTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team</th>
                <th>Player</th>
                <th>Is Yellow Card</th>
                <th>Is Red Card</th>
                <th>Fouled At</th>
                <th>Action</th> {{-- 🗑️ Added for delete --}}
            </tr>
        </thead>
        <tbody>
            @foreach($foulLogs as $log)
            <tr data-id="{{ $log->id }}" data-team="{{ $log->team_id }}">
                <td>{{ $log->id }}</td>
                <td>{{ $log->team }}</td>

                {{-- Player --}}
                <td class="editable" data-field="player" data-value="{{ $log->player }}">
                    {{ $log->player_name }}
                </td>

                {{-- Is Yellow Card --}}
                <td class="editable" data-field="is_yellow_card" data-value="{{ $log->is_yellow_card }}">
                    {{ $log->is_yellow_card == '1' ? 'Yes' : 'No' }}
                </td>

                {{-- Is Red Card --}}
                <td class="editable" data-field="is_red_card" data-value="{{ $log->is_red_card }}">
                    {{ $log->is_red_card == '1' ? 'Yes' : 'No' }}
                </td>

                {{-- Fouled At --}}
                <td class="editable" data-field="fouled_at">{{ $log->fouled_at }}</td>

                {{-- Delete --}}
                <td>
                    <button class="btn btn-sm btn-danger delete-foul">Delete</button>
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
        $('#foulLogTable').on('click', '.editable', function() {
            const $cell = $(this);
            const field = $cell.data('field');
            const $row = $cell.closest('tr');
            const id = $row.data('id');
            const teamId = $row.data('team');
            const currentValue = $cell.data('value');

            if ($cell.find('input, select').length > 0) return;

            let input;

            // 🎯 Player dropdown (by team)
            if (field === 'player') {
                input = $('<select class="form-control form-control-sm"></select>');
                const players = teamPlayers[teamId] || [];

                players.forEach(p => {
                    const option = $('<option></option>')
                        .val(p.id)
                        .text(p.player_name);
                    if (p.id == currentValue) option.prop('selected', true);
                    input.append(option);
                });

                if (players.length === 0)
                    input.append('<option value="">No players</option>');
            }

            // ⚙️ Boolean dropdowns
            else if (field === 'is_yellow_card' || field === 'is_red_card') {
                input = $('<select class="form-control form-control-sm">' +
                    '<option value="0">No</option>' +
                    '<option value="1">Yes</option>' +
                    '</select>');
                input.val(currentValue);
            }

            // ✏️ Text input for fouled_at or others
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

                    // AJAX update
                    $.ajax({
                        url: 'foul-log/' + id,
                        method: 'PATCH',
                        data: {
                            _token: '{{ csrf_token() }}',
                            [field]: newValue
                        },
                        success: function(res) {
                            console.log('✅ Foul log updated', res);
                        },
                        error: function() {
                            alert('❌ Error updating foul log');
                            $cell.text(currentValue);
                        }
                    });
                }
            });
        });

        // ========= Delete Handler =========
        $('#foulLogTable').on('click', '.delete-foul', function() {
            const $row = $(this).closest('tr');
            const id = $row.data('id');

            if (!confirm('Are you sure you want to delete this foul log?')) return;

            $.ajax({
                url: 'foul-log/' + id,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                    console.log('🗑️ Foul log deleted successfully', res);
                },
                error: function() {
                    alert('❌ Failed to delete foul log');
                }
            });
        });
    });
</script>