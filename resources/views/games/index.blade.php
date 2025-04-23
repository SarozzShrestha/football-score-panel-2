<h2>Game Information</h2>

<a href="{{ route('admin.games.create') }}">
    Create new game
</a>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Name</th>
        <th>Teams</th>
        <th>Venue</th>
        <th>Weather</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($games as $game)
        <tr>
            <td>{{ $game->name }}</td>
            <td>{{ $game->team_a }} ({{$game->team_a_abb}}) VS {{ $game->team_b }} ({{$game->team_b_abb}})</td>
            <td>{{ $game->venue }}</td>
            <td>{{ $game->weather }}</td>
            <td>{{ $game->date_time }}</td>
            <td>
                @if($game->status == '0')
                    <span>Not yet started</span>
                @elseif($game->status == '1')
                    <span>Match Ongoing</span>
                @elseif($game->status == '2')
                    <span>Match Completed</span>
                @elseif($game->status == '3')
                    <span>Match Cancelled</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.games.show', ['game' => $game]) }}">View</a> |
                <a href="{{ route('admin.games.playingXI', ['game' => $game]) }}">Playing XI</a> |
                <a href="{{ route('admin.games.dashboard', ['game' => $game]) }}">Game Dashboard</a> |
{{--                <a href="{{ route('admin.games.edit', ['game' => $game]) }}">Update</a> |--}}
{{--                <form action="{{ route('admin.players.destroy', ['player' => $game]) }}" method="POST" style="display: inline-block">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>--}}
{{--                </form>--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
