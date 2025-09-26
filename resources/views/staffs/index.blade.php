<h2>Staff Information</h2>

<a href="{{ route('admin.staffs.create') }}">
    Add new Staff
</a>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Image</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->name }}</td>
                <td>{{ $staff->role == '0' ? 'Manager' : 'Referee' }}</td>
                <td>{{ $staff->image }}</td>
                <td>{{ $staff->status ? 'active' : 'inactive' }}</td>
                <td>
                    <a href="{{ route('admin.staffs.show', ['staff' => $staff]) }}">View</a> |
                    <a href="{{ route('admin.staffs.edit', ['staff' => $staff]) }}">Update</a> |
                    <form action="{{ route('admin.staffs.destroy', ['staff' => $staff]) }}" method="POST" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
