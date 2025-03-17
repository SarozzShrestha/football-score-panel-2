<h2>Teams Information</h2>

<a href="{{ route('admin.teams.create') }}">
    Add new Team
</a>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Name</th>
        <th>Logo</th>
        <th>Home Jersey</th>
        <th>Away Jersey</th>
        <th>Status</th>
        <th>Manager</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        @foreach($teams as $team)
            <tr>
                <td>{{ $team->name }} ({{$team->abb}})</td>
                <td>{{ $team->logo }}</td>
                <td>
                    <div style="border: 1px solid black; min-height: 10px; min-width: 10px; background: {{ $team->home_color_top }}"></div>
                    <br>
                    <div style="border: 1px solid black; min-height: 10px; min-width: 10px; background: {{ $team->home_color_down }}"></div>
                <td>
                    <div style="border: 1px solid black; min-height: 10px; min-width: 10px; background: {{ $team->away_color_top }}"></div>
                    <br>
                    <div style="border: 1px solid black; min-height: 10px; min-width: 10px; background: {{ $team->away_color_down }}"></div>
                </td>
                <td>{{ $team->status ? 'active' : 'inactive' }}</td>
                <td>{{ $team->manager->name }}</td>
                <td>
                    <a href="{{ route('admin.teams.show', ['team' => $team]) }}">View</a> |
                    <a href="{{ route('admin.teams.edit', ['team' => $team]) }}">Update</a> |
                    <form action="{{ route('admin.teams.destroy', ['team' => $team]) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
