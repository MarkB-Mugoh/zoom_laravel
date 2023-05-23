<!-- resources/views/schedule-meeting.blade.php -->

<form action="{{ url('zoom/schedule-meeting') }}" method="POST">
    @csrf

    <div>
        <label for="topic">Topic:</label>
        <input type="text" name="topic" id="topic" required>
    </div>

    <div>
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" name="start_time" id="start_time" required>
    </div>

    <div>
        <label for="duration">Duration (in minutes):</label>
        <input type="number" name="duration" id="duration" required>
    </div>

    <div>
        <label for="agenda">Agenda:</label>
        <textarea name="agenda" id="agenda"></textarea>
    </div>

    <div>
        <label for="host_video">Host Video:</label>
        <select name="host_video" id="host_video" required>
            <option value="1">Enable</option>
            <option value="0">Disable</option>
        </select>
    </div>

    <div>
        <label for="participant_video">Participant Video:</label>
        <select name="participant_video" id="participant_video" required>
            <option value="1">Enable</option>
            <option value="0">Disable</option>
        </select>
    </div>

    <button type="submit">Schedule Meeting</button>
</form>
