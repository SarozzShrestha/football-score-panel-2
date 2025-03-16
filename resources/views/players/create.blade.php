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

<form action="{{ route('admin.players.update') }}" method="POST">
    @csrf

    <!-- Name -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <!-- Role -->
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="GK">GK</option>
        <option value="DEF">DEF</option>
        <option value="MID">MID</option>
        <option value="FWD">FWD</option>
    </select><br><br>

    <!-- Position -->
    <label for="position">Position:</label>
    <input type="text" id="position" name="position" required><br><br>

    <!-- Image -->
    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" required><br><br>

    <!-- Nationality -->
    <label for="nationality">Nationality:</label>
    <input type="text" id="nationality" name="nationality" required><br><br>

    <!-- Height -->
    <label for="height">Height:</label>
    <input type="text" id="height" name="height" required><br><br>

    <!-- Height Unit -->
    <label for="height_unit">Height Unit:</label>
    <select id="height_unit" name="height_unit" required>
        <option value="inches">Inches</option>
        <option value="m">Meters</option>
        <option value="cm">Centimeters</option>
    </select><br><br>

    <!-- Weight -->
    <label for="weight">Weight:</label>
    <input type="text" id="weight" name="weight" required><br><br>

    <!-- Weight Unit -->
    <label for="weight_unit">Weight Unit:</label>
    <select id="weight_unit" name="weight_unit" required>
        <option value="kg">Kilograms</option>
        <option value="lbs">Pounds</option>
    </select><br><br>

    <!-- Age -->
    <label for="age">Age:</label>
    <input type="text" id="age" name="age" required><br><br>

    <!-- Status -->
    <label for="status">Active Status:</label>
    <input type="checkbox" id="status" name="status"><br><br>

    <!-- Submit Button -->
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

</body>
</html>
