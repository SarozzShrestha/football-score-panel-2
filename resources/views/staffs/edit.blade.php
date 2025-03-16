<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Form</title>
</head>
<body>

<a href="{{ route('admin.staffs.index') }}">
    List Staffs
</a>

<h2>Staff Information Form</h2>

<form action="{{ route('admin.staffs.update', ['staff' => $staff]) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Name -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ $staff->name }}" required><br><br>

    <!-- Role -->
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="0" {{ $staff->role == '0' ? 'selected' : '' }}>Manager</option>
        <option value="1" {{ $staff->role == '1' ? 'selected' : '' }}>Referee</option>
    </select><br><br>

    <!-- Image -->
    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" value="{{ $staff->image }}" required><br><br>


    <!-- Status -->
    <label for="status">Active Status:</label>
    <input type="checkbox" id="status" name="status" {{ $staff->status == '1' ? 'checked' : '' }}><br><br>

    <!-- Submit Button -->
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

</body>
</html>
