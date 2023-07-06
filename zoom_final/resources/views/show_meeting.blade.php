<!DOCTYPE html>
<html>
    <head>
        <title>Zoom Meeting</title>
    </head>
    <body>
        <h1>Zoom Meeting Created</h1>

        <p>Meeting ID: {{ $meeting['id'] }}</p>
        <p>Topic: {{ $meeting['topic'] }}</p>
        <p>Start Time: {{ $meeting['start_time'] }}</p>
        <!-- Display other meeting details as required -->
    </body>
</html>
