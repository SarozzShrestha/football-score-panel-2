<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Form</title>
</head>
<body>

<a href="{{ route('admin.players.index') }}">
    List Players
</a>

<h2>Player Information Form</h2>

<form action="{{ route('admin.players.update', ['player' => $player]) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Name -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ $player->name }}" required><br><br>

    <!-- Role -->
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="GK" {{ $player->role == 'GK' ? 'selected' : '' }}>GK</option>
        <option value="DEF" {{ $player->role == 'DEF' ? 'selected' : '' }}>DEF</option>
        <option value="MID" {{ $player->role == 'MID' ? 'selected' : '' }}>MID</option>
        <option value="FWD" {{ $player->role == 'FWD' ? 'selected' : '' }}>FWD</option>
    </select><br><br>

    <!-- Position -->
    <label for="position">Position:</label>
    <input type="text" id="position" name="position" value="{{ $player->position }}" required><br><br>

    <!-- Image -->
    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" value="{{ $player->image }}" required><br><br>

    <!-- Nationality -->
    <label for="nationality">Nationality:</label>
    <input type="text" id="nationality" name="nationality" value="{{ $player->nationality }}" required><br><br>

    <!-- Height -->
    <label for="height">Height:</label>
    <input type="text" id="height" name="height" value="{{ $player->height }}" required><br><br>

    <!-- Height Unit -->
    <label for="height_unit">Height Unit:</label>
    <select id="height_unit" name="height_unit" required>
        <option value="inches" {{ $player->height_unit == 'inches' ? 'selected' : '' }}>Inches</option>
        <option value="m" {{ $player->height_unit == 'm' ? 'selected' : '' }}>Meters</option>
        <option value="cm" {{ $player->height_unit == 'cm' ? 'selected' : '' }}>Centimeters</option>
    </select><br><br>

    <!-- Weight -->
    <label for="weight">Weight:</label>
    <input type="text" id="weight" name="weight" value="{{ $player->weight }}" required><br><br>

    <!-- Weight Unit -->
    <label for="weight_unit">Weight Unit:</label>
    <select id="weight_unit" name="weight_unit" required>
        <option value="kg" {{ $player->weight_unit == 'kg' ? 'selected' : '' }}>Kilograms</option>
        <option value="lbs" {{ $player->weight_unit == 'lbs' ? 'selected' : '' }}>Pounds</option>
    </select><br><br>

    <!-- Age -->
    <label for="age">Age:</label>
    <input type="text" id="age" name="age" value="{{ $player->age }}" required><br><br>

    <!-- Status -->
    <label for="status">Active Status:</label>
    <input type="checkbox" id="status" name="status" {{ $player->status == '1' ? 'checked' : '' }}><br><br>

    <!-- Submit Button -->
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

</body>
</html>
