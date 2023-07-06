
<form action="{{url('/meetings')}}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="6NNLSMmgSGmoVE_gUujedg">
    <label for="topic">Meeting Topic:</label>
    <input type="text" name="topic" id="topic" required>

    <label for="type">Meeting Type:</label>
    <select name="type" id="type">
        <option value="1">Instant</option>
        <option value="2">Scheduled</option>
        <option value="3">Recurring</option>
    </select>

    <label for="start_time">Start Time:</label>
    <input type="datetime-local" name="start_time" id="start_time">

    <label for="duration">Duration (in minutes):</label>
    <input type="number" name="duration" id="duration">

    <label for="password">Password:</label>
    <input type="text" name="password" id="password">

    <label for="timezone">Timezone:</label>
    <input type="text" name="timezone" id="timezone">

    <label for="agenda">Agenda:</label>
    <textarea name="agenda" id="agenda"></textarea>

    <label for="settings.host_video">Host Video:</label>
    <select name="settings[host_video]" id="settings.host_video">
        <option value="true">Yes</option>
        <option value="false">No</option>
    </select>

    <!-- Add more meeting parameters as needed -->

    <button type="submit">Create Meeting</button>
</form>
