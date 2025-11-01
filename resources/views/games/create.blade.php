<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Form</title>
</head>
<body>

<a href="{{ route('admin.games.index') }}">
    List Games
</a>

<h2>Game Create Form</h2>

<form action="{{ route('admin.games.store') }}" method="POST">
    @csrf

    <label for="name">Game Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="name">Game Date & Time:</label>
    <input type="datetime-local" id="date_time" name="date_time" required><br><br>

    <label for="venue">Game Venue:</label>
    <input type="text" id="venue" name="venue" required><br><br>

    <label for="weather">Weather:</label>
    <input type="text" id="weather" name="weather" required><br><br>

    <label for="team_a_id">Team A:</label>
    <select id="team_a_id" name="team_a_id" required>
        <option value="">-- Select Team A --</option>
        @foreach($teams as $team)
            <option value="{{ $team->id }}">{{ $team->name }}</option>
        @endforeach
    </select><br><br>

    <label for="team_b_id">Team B:</label>
    <select id="team_b_id" name="team_b_id" required>
        <option value="">-- Select Team B --</option>
        @foreach($teams as $team)
            <option value="{{ $team->id }}">{{ $team->name }}</option>
        @endforeach
    </select><br><br>

    <label for="referee">Main Referee:</label>
    <select id="referee" name="referee" required>
        <option value="">-- Select Match Referee --</option>
        @foreach($staffs as $staff)
            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
        @endforeach
    </select><br><br>

    <label for="first_linesmen">1st Linesmen:</label>
    <select id="first_linesmen" name="first_linesmen" required>
        <option value="">-- Select Officials --</option>
        @foreach($staffs as $staff)
            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
        @endforeach
    </select><br><br>

    <label for="second_linesmen">2nd Linesmen:</label>
    <select id="second_linesmen" name="second_linesmen" required>
        <option value="">-- Select Officials --</option>
        @foreach($staffs as $staff)
            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
        @endforeach
    </select><br><br>

    <label for="official">Match Official:</label>
    <select id="official" name="official" required>
        <option value="">-- Select Officials --</option>
        @foreach($staffs as $staff)
            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
        @endforeach
    </select><br><br>

    <label for="tournament">Tournament:</label>
    <select id="tournament" name="tournament">
        <option value="">-- Select Tournament --</option>
        @foreach($tournaments as $tournament)
            <option value="{{ $tournament->id }}">{{ $tournament->name }} ({{ $tournament->year }})</option>
        @endforeach
    </select><br><br>

    <!-- Submit Button -->
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
</form>

</body>
</html>
