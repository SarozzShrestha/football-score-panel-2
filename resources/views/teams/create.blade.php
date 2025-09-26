<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Form</title>
</head>
<body>

<a href="{{ route('admin.teams.index') }}">
    List Teams
</a>

<h2>Team Information Form</h2>

<form action="{{ route('admin.teams.store') }}" method="POST">
    @csrf

    <!-- Name -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="abb">Short Abb:</label>
    <input type="text" id="abb" name="abb" required><br><br>

    <!-- Image -->
    <label for="image">Image URL:</label>
    <input type="text" id="image" name="image" required><br><br>

    <label for="home_jersey_top">Home Jersey Top</label>
    <input type="color" id="home_jersey_top" name="home_jersey_top" required><br><br>

    <label for="home_jersey_down">Home Jersey Down</label>
    <input type="color" id="home_jersey_down" name="home_jersey_down" required><br><br>

    <!-- ------------------------------------------------------------ -->
    <label for="away_jersey_top">Away Jersey Top</label>
    <input type="color" id="away_jersey_top" name="away_jersey_top" required><br><br>

    <label for="away_jersey_top">Away Jersey Down</label>
    <input type="color" id="away_jersey_down" name="away_jersey_down" required><br><br>


    <label for="manager">Manager:</label>
    <select id="manager" name="manager" required>
        <option value="">-- Select Manager --</option>

        @foreach($managers as $manager)
            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
        @endforeach

    </select><br><br>

    <!-- Status -->
    <label for="status">Active Status:</label>
    <input type="checkbox" id="status" name="status"><br><br>

    <!-- Submit Button -->
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

</body>
</html>
