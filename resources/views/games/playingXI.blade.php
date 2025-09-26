<button type="button" class="btn-submit">Save</button>
<br>
<i>Note: List is sorted by jersey no</i>
<h1>Team A : {{ $game->team_a }}</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Playing XI</th>
        <th>Substitute</th>
        <th>Game Captain</th>
        <th>Name</th>
        <th>Position</th>
        <th>Jersey No</th>
    </tr>
    </thead>
    <tbody>
    @foreach($team_a as $player)
        <tr>
            <td>
                <input type="checkbox" class="team_a_playing-xi" data-id="{{ $player->id }}" {{ $player->is_playing_xi ? 'checked' : '' }}/>
            </td>
            <td>
                <input type="checkbox" class="team_a_substitute"  data-id="{{ $player->id }}" {{ $player->is_substitute ? 'checked' : '' }}/>
            </td>
            <td>
                <input type="radio" class="team_a_captain" name="team_a_captain" data-id="{{ $player->id }}" value="{{ $player->id }}"
                    {{ $player->is_captain ? 'checked' : ($player->pivot->is_captain == '1'  ? 'checked' : '') }} />
            </td>
            <td>
                {{ $player->name }}
                @if( $player->pivot->is_captain == '1')
                    (c)
                @endif
            </td>
            <td>
                {{ $player->role }} ({{ $player->position }})
            </td>
            <td>{{ $player->pivot->jersey_no }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
&nbsp;
<hr>
&nbsp;
<h1>Team B : {{ $game->team_b }}</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Playing XI</th>
        <th>Substitute</th>
        <th>Game Captain</th>
        <th>Name</th>
        <th>Position</th>
        <th>Jersey No</th>
    </tr>
    </thead>
    <tbody>
    @foreach($team_b as $player)
        <tr>
            <td>
                <input type="checkbox" class="team_b_playing-xi" data-id="{{ $player->id }}" {{ $player->is_playing_xi ? 'checked' : '' }}/>
            </td>
            <td>
                <input type="checkbox" class="team_b_substitute"  data-id="{{ $player->id }}" {{ $player->is_substitute ? 'checked' : '' }}/>
            </td>
            <td>
                <input type="radio" class="team_b_captain" name="team_b_captain" data-id="{{ $player->id }}" value="{{ $player->id }}"
                    {{ $player->is_captain ? 'checked' : ($player->pivot->is_captain == '1'  ? 'checked' : '') }} />
            </td>
            <td>
                {{ $player->name }}
                @if( $player->pivot->is_captain == '1')
                    (c)
                @endif
            </td>
            <td>
                {{ $player->role }} ({{ $player->position }})
            </td>
            <td>{{ $player->pivot->jersey_no }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        let team_a_playing_xi = [];
        let team_b_playing_xi = [];
        let team_a_subs = [];
        let team_b_subs = [];

        let teamACaptainPlayer = null;
        let teamBCaptainPlayer = null;

        $('input[name="team_a_captain"]').on('change', function () {
            teamACaptainPlayer = $(this).val();
        });

        $('input[name="team_b_captain"]').on('change', function () {
            teamBCaptainPlayer = $(this).val();
        });

        $('.team_a_playing-xi').on('change', function () {
            if($(this).prop('checked') === true) {
                if(team_a_playing_xi.length > 10) {
                    alert('Team A can only play 11 players!');
                    $(this).prop('checked', false);
                    return;
                }

                team_a_playing_xi.push($(this).data('id'));
            } else {
                const index = team_a_playing_xi.indexOf($(this).data('id'));
                if (index > -1) {
                    team_a_playing_xi.splice(index, 1);
                }
            }
        })

        $('.team_a_substitute').on('change', function () {
            if($(this).prop('checked') === true) {
                team_a_subs.push($(this).data('id'));
            } else {
                const index = team_a_subs.indexOf($(this).data('id'));
                if (index > -1) {
                    team_a_subs.splice(index, 1);
                }
            }
        })

        $('.team_b_playing-xi').on('change', function () {
            if($(this).prop('checked') === true) {
                if(team_b_playing_xi.length > 10) {
                    alert('Team B can only play 11 players!');
                    $(this).prop('checked', false);
                    return;
                }

                team_b_playing_xi.push($(this).data('id'));
            } else {
                const index = team_b_playing_xi.indexOf($(this).data('id'));
                if (index > -1) {
                    team_b_playing_xi.splice(index, 1);
                }
            }
        })

        $('.team_b_substitute').on('change', function () {
            if($(this).prop('checked') === true) {
                team_b_subs.push($(this).data('id'));
            } else {
                const index = team_b_subs.indexOf($(this).data('id'));
                if (index > -1) {
                    team_b_subs.splice(index, 1);
                }
            }
        })

        $('.btn-submit').on('click', function() {
            if (team_a_playing_xi.length < 2)
            {
                alert('Team A must play 11 players!');
                return;
            }

            if (team_b_playing_xi.length < 2)
            {
                alert('Team B must play 11 players!');
                return;
            }

            $.ajax({
                'type': 'POST',
                'url': '{{ route('admin.games.post.playingXI', ['game' => $game]) }}',
                'dataType': "JSON",
                'data': {
                    '_token': '{{ csrf_token() }}',
                    'team_a_playing_xi': team_a_playing_xi,
                    'team_b_playing_xi': team_b_playing_xi,
                    'team_a_subs': team_a_subs,
                    'team_b_subs': team_b_subs,
                    'team_a_captain': teamACaptainPlayer,
                    'team_b_captain': teamBCaptainPlayer,
                },
                'success': function (res) {
                    if (res['status'] == 'success') {
                        window.location = res['url'];
                    }
                },
                'error': function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        })

        $('.team_a_playing-xi').trigger('change');
        $('.team_a_substitute').trigger('change');
        $('.team_b_playing-xi').trigger('change');
        $('.team_b_substitute').trigger('change');
        $('input[name="team_a_captain"]').trigger('change');
        $('input[name="team_b_captain"]').trigger('change');
    })
</script>


