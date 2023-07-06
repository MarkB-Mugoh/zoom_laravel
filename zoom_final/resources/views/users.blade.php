<!DOCTYPE html>
<html>
    <head>
        <title>Zoom Users</title>
    </head>
    <body>
        <h1>Zoom Users</h1>

        <ul>
            @foreach ($users['users'] as $user)
                <li>{{ $user['email'] }}</li>
                <li>{{ $user['id'] }}</li>
            @endforeach
        </ul>
    </body>
</html>
