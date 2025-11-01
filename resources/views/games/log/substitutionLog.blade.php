@php
use App\Constants\AppConstants;
$reasons = AppConstants::SUBSTITUTION_REASONS;
@endphp

<div>
    <h5>Substitution Log</h5>
    <table class="table table-bordered" id="substitutionLogTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team</th>
                <th>Subbed By</th>
                <th>Subbed For</th>
                <th>Reason</th>
                <th>Subbed At</th>
                <th>Extra Minutes</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($substitutionLogs as $log)
            <tr data-id="{{ $log->id }}" data-team="{{ $log->team_id }}">
                <td>{{ $log->id }}</td>
                <td>{{ $log->team }}</td>

                {{-- Subbed By --}}
                <td class="editable" data-field="subbed_by" data-value="{{ $log->subbed_by }}">
                    {{ $log->subbed_by_name }}
                </td>

                {{-- Subbed For --}}
                <td class="editable" data-field="subbed_for" data-value="{{ $log->subbed_for }}">
                    {{ $log->subbed_for_name }}
                </td>

                {{-- Reason --}}
                <td class="editable" data-field="reason" data-value="{{ $log->reason }}">
                    {{ $reasons[$log->reason] ?? $log->reason }}
                </td>

                {{-- Subbed At --}}
                <td class="editable" data-field="subbed_at">{{ $log->subbed_at }}</td>

                {{-- Extra Minutes --}}
                <td class="editable" data-field="extra_minutes">{{ $log->extra_minutes }}</td>

                {{-- 🗑️ Delete --}}
                <td>
                    <button class="btn btn-sm btn-danger delete-log">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    var subTeamPlayers = @json($players); // { team_id: [{id, player_name}, ...] }
    var substitutionReasons = @json(\App\Constants\AppConstants::SUBSTITUTION_REASONS);

    $(document).ready(function() {
        // ========= Inline Edit =========
        $('#substitutionLogTable').on('click', '.editable', function() {
            const $cell = $(this);
            const field = $cell.data('field');
            const $row = $cell.closest('tr');
            const id = $row.data('id');
            const teamId = $row.data('team');
            const currentValue = $cell.data('value') || '';

            if ($cell.find('input, select').length > 0) return;

            let input;

            // 🎯 Dropdown for players
            if (field === 'subbed_by' || field === 'subbed_for') {
                input = $('<select class="form-control form-control-sm"></select>');
                const players = subTeamPlayers[teamId] || [];

                players.forEach(p => {
                    const option = $('<option></option>').val(p.id).text(p.player_name);
                    if (p.id == currentValue) option.prop('selected', true);
                    input.append(option);
                });

                if (players.length === 0)
                    input.append('<option value="">No players</option>');
            }

            // ⚙️ Dropdown for substitution reasons
            else if (field === 'reason') {
                input = $('<select class="form-control form-control-sm"></select>');
                $.each(substitutionReasons, function(value, text) {
                    const option = $('<option></option>').val(value).text(text);
                    if (value == currentValue) option.prop('selected', true);
                    input.append(option);
                });
            }

            // ✏️ Text inputs
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
                        url: 'sub-log/' + id,
                        method: 'PATCH',
                        data: {
                            _token: '{{ csrf_token() }}',
                            [field]: newValue
                        },
                        success: function(res) {
                            console.log('✅ Updated successfully', res);
                        },
                        error: function() {
                            alert('❌ Error updating field');
                            $cell.text(currentValue);
                        }
                    });
                }
            });
        });

        // ========= Delete Log =========
        $('#substitutionLogTable').on('click', '.delete-log', function() {
            const $row = $(this).closest('tr');
            const id = $row.data('id');

            if (!confirm('Are you sure you want to delete this substitution log?')) return;

            $.ajax({
                url: 'sub-log/' + id,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                    console.log('🗑️ Log deleted successfully', res);
                },
                error: function() {
                    alert('❌ Failed to delete log');
                }
            });
        });
    });
</script>