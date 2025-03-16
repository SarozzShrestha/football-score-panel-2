<h2>Player Information</h2>

<a href="{{ route('admin.players.create') }}">
    Add new player
</a>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Position</th>
        <th>Image</th>
        <th>Nationality</th>
        <th>Height</th>
        <th>Height Unit</th>
        <th>Weight</th>
        <th>Weight Unit</th>
        <th>Age</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @foreach($players as $player)
            <td>{{ $player->name }}</td>
            <td>{{ $player->role }}</td>
            <td>{{ $player->position }}</td>
            <td>{{ $player->image }}</td>
            <td>{{ $player->nationality }}</td>
            <td>{{ $player->height }}</td>
            <td>{{ $player->height_unit }}</td>
            <td>{{ $player->weight }}</td>
            <td>{{ $player->weight_unit }}</td>
            <td>{{ $player->age }}</td>
            <td>{{ $player->status ? 'active' : 'inactive' }}</td>
            <td>
                <a href="{{ route('admin.players.show', ['player' => $player]) }}">View</a> |
                <a href="{{ route('admin.players.edit', ['player' => $player]) }}">Update</a> |
                <form action="{{ route('admin.players.destroy', ['player' => $player]) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                </form>
            </td>
        @endforeach

    </tr>
    </tbody>
</table>
